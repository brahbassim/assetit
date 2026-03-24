<?php

namespace App\Http\Controllers;

use App\Models\HardwareAsset;
use App\Models\AssetCategory;
use App\Models\Vendor;
use App\Models\SoftwareLicense;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ImportController extends Controller
{
    public function hardwareAssetsForm()
    {
        $categories = AssetCategory::all();
        $vendors = Vendor::all();
        return view('import.hardware-assets', compact('categories', 'vendors'));
    }

    public function downloadHardwareAssetsTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Hardware Assets');

        $headers = ['asset_tag', 'name', 'category_id', 'vendor_id', 'assigned_employee_id', 'serial_number', 'purchase_date', 'purchase_cost', 'warranty_expiry', 'status', 'notes'];
        $sheet->fromArray($headers, null, 'A1');

        $requiredColumns = ['asset_tag', 'name', 'category_id', 'status'];
        $optionalColumns = ['vendor_id', 'assigned_employee_id', 'serial_number', 'purchase_date', 'purchase_cost', 'warranty_expiry', 'notes'];

        $redFill = new Fill();
        $redFill->setFillType(Fill::FILL_SOLID);
        $redFill->getStartColor()->setRGB('FF6B6B');

        $greenFill = new Fill();
        $greenFill->setFillType(Fill::FILL_SOLID);
        $greenFill->getStartColor()->setRGB('6BCB77');

        foreach ($headers as $colIndex => $header) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
            if (in_array($header, $requiredColumns)) {
                $sheet->getStyle($colLetter . '1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FF6B6B');
            } else {
                $sheet->getStyle($colLetter . '1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('6BCB77');
            }
        }

        $categories = AssetCategory::pluck('name')->toArray();
        $vendors = Vendor::pluck('name')->toArray();
        $employees = Employee::all()->map(function ($emp) {
            return $emp->first_name . ' ' . $emp->last_name;
        })->toArray();
        $statuses = ['available', 'assigned', 'maintenance', 'retired'];

        $categoryList = implode(',', $categories);
        $vendorList = implode(',', $vendors);
        $employeeList = implode(',', $employees);
        $statusList = implode(',', $statuses);

        $categoryValidation = $sheet->getDataValidation('C2:C1000');
        $categoryValidation->setType(DataValidation::TYPE_LIST);
        $categoryValidation->setFormula1('"' . $categoryList . '"');
        $categoryValidation->setAllowBlank(true);
        $categoryValidation->setShowDropDown(true);

        $vendorValidation = $sheet->getDataValidation('D2:D1000');
        $vendorValidation->setType(DataValidation::TYPE_LIST);
        $vendorValidation->setFormula1('"' . $vendorList . '"');
        $vendorValidation->setAllowBlank(true);
        $vendorValidation->setShowDropDown(true);

        $employeeValidation = $sheet->getDataValidation('E2:E1000');
        $employeeValidation->setType(DataValidation::TYPE_LIST);
        $employeeValidation->setFormula1('"' . $employeeList . '"');
        $employeeValidation->setAllowBlank(true);
        $employeeValidation->setShowDropDown(true);

        $statusValidation = $sheet->getDataValidation('J2:J1000');
        $statusValidation->setType(DataValidation::TYPE_LIST);
        $statusValidation->setFormula1('"' . $statusList . '"');
        $statusValidation->setAllowBlank(true);
        $statusValidation->setShowDropDown(true);

        $sheet->setCellValue('A2', 'HW-001');
        $sheet->setCellValue('B2', 'Dell Laptop');
        $sheet->setCellValue('C2', !empty($categories) ? $categories[0] : '');
        $sheet->setCellValue('D2', !empty($vendors) ? $vendors[0] : '');
        $sheet->setCellValue('E2', !empty($employees) ? $employees[0] : '');
        $sheet->setCellValue('F2', 'SN123456');
        $sheet->setCellValue('G2', '2024-01-15');
        $sheet->setCellValue('H2', '1200.00');
        $sheet->setCellValue('I2', '2025-01-15');
        $sheet->setCellValue('J2', 'available');
        $sheet->setCellValue('K2', 'Example notes');

        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Reference');
        
        $sheet2->setCellValue('A1', 'Legend:');
        $sheet2->getStyle('A1')->getFont()->setBold(true);
        $sheet2->setCellValue('A2', 'Required');
        $sheet2->getStyle('A2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FF6B6B');
        $sheet2->setCellValue('B2', 'Optional');
        $sheet2->getStyle('B2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('6BCB77');
        
        $sheet2->setCellValue('A4', 'Categories');
        $sheet2->fromArray(array_merge([''], $categories), null, 'A5');
        $sheet2->setCellValue('C4', 'Vendors');
        $sheet2->fromArray(array_merge([''], $vendors), null, 'C5');
        $sheet2->setCellValue('E4', 'Employees');
        $sheet2->fromArray(array_merge([''], $employees), null, 'E5');
        $sheet2->setCellValue('G4', 'Statuses');
        $sheet2->fromArray(array_merge([''], $statuses), null, 'G5');

        $writer = new Xlsx($spreadsheet);
        $filename = 'hardware_assets_template.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    public function hardwareAssetsImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx',
        ]);

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file('file')->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        $header = array_shift($data);
        $header = array_map('trim', $header);

        $requiredColumns = ['asset_tag', 'name', 'category_id', 'status'];
        $missingColumns = array_diff($requiredColumns, $header);

        if (!empty($missingColumns)) {
            return back()->with('error', __('app.import_error') . ': Missing columns: ' . implode(', ', $missingColumns));
        }

        $categoryMap = AssetCategory::pluck('id', 'name')->toArray();
        $vendorMap = Vendor::pluck('id', 'name')->toArray();
        $employeeMap = Employee::selectRaw("CONCAT(first_name, ' ', last_name) as full_name, id")->pluck('id', 'full_name')->toArray();
        
        $successCount = 0;
        $errors = [];

        DB::beginTransaction();
        try {
            foreach ($data as $rowIndex => $row) {
                if (empty(array_filter($row))) continue;

                $rowData = array_combine($header, $row);
                foreach ($rowData as $key => $value) {
                    $rowData[$key] = trim($value);
                }

                $categoryName = $rowData['category_id'] ?? '';
                $categoryId = $categoryMap[$categoryName] ?? null;
                if (!$categoryId) {
                    $errors[] = "Row " . ($rowIndex + 2) . ": Invalid category '{$categoryName}'";
                    continue;
                }

                $vendorName = $rowData['vendor_id'] ?? '';
                $vendorId = $vendorMap[$vendorName] ?? null;

                $employeeName = $rowData['assigned_employee_id'] ?? '';
                $employeeId = $employeeMap[$employeeName] ?? null;

                $status = strtolower($rowData['status'] ?? 'available');
                if (!in_array($status, ['available', 'assigned', 'maintenance', 'retired'])) {
                    $status = 'available';
                }

                HardwareAsset::create([
                    'asset_tag' => $rowData['asset_tag'],
                    'name' => $rowData['name'],
                    'category_id' => $categoryId,
                    'vendor_id' => $vendorId,
                    'assigned_employee_id' => $employeeId,
                    'serial_number' => $rowData['serial_number'] ?? null,
                    'purchase_date' => !empty($rowData['purchase_date']) ? $rowData['purchase_date'] : null,
                    'purchase_cost' => !empty($rowData['purchase_cost']) ? floatval($rowData['purchase_cost']) : null,
                    'warranty_expiry' => !empty($rowData['warranty_expiry']) ? $rowData['warranty_expiry'] : null,
                    'status' => $status,
                    'notes' => $rowData['notes'] ?? null,
                ]);

                $successCount++;
            }

            DB::commit();
            return redirect()->route('hardware-assets.index')->with('success', __('app.import_success', ['count' => $successCount]));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', __('app.import_error') . ': ' . $e->getMessage());
        }
    }

    public function softwareLicensesForm()
    {
        $vendors = Vendor::all();
        return view('import.software-licenses', compact('vendors'));
    }

    public function downloadSoftwareLicensesTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Software Licenses');

        $headers = ['software_name', 'license_key', 'total_seats', 'vendor_id', 'purchase_date', 'expiration_date', 'notes'];
        $sheet->fromArray($headers, null, 'A1');

        $requiredColumns = ['software_name', 'license_key', 'total_seats'];
        $optionalColumns = ['vendor_id', 'purchase_date', 'expiration_date', 'notes'];

        foreach ($headers as $colIndex => $header) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
            if (in_array($header, $requiredColumns)) {
                $sheet->getStyle($colLetter . '1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FF6B6B');
            } else {
                $sheet->getStyle($colLetter . '1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('6BCB77');
            }
        }

        $vendors = Vendor::pluck('name')->toArray();
        $vendorList = implode(',', $vendors);

        $vendorValidation = $sheet->getDataValidation('D2:D1000');
        $vendorValidation->setType(DataValidation::TYPE_LIST);
        $vendorValidation->setFormula1('"' . $vendorList . '"');
        $vendorValidation->setAllowBlank(true);
        $vendorValidation->setShowDropDown(true);

        $sheet->setCellValue('A2', 'Microsoft Office 365');
        $sheet->setCellValue('B2', 'XXXXX-XXXXX-XXXXX-XXXXX');
        $sheet->setCellValue('C2', '10');
        $sheet->setCellValue('D2', !empty($vendors) ? $vendors[0] : '');
        $sheet->setCellValue('E2', '2024-01-15');
        $sheet->setCellValue('F2', '2025-01-15');
        $sheet->setCellValue('G2', 'Example notes');

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Reference');
        
        $sheet2->setCellValue('A1', 'Legend:');
        $sheet2->getStyle('A1')->getFont()->setBold(true);
        $sheet2->setCellValue('A2', 'Required');
        $sheet2->getStyle('A2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FF6B6B');
        $sheet2->setCellValue('B2', 'Optional');
        $sheet2->getStyle('B2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('6BCB77');
        
        $sheet2->setCellValue('A4', 'Vendors');
        $sheet2->fromArray(array_merge([''], $vendors), null, 'A5');

        $writer = new Xlsx($spreadsheet);
        $filename = 'software_licenses_template.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }

    public function softwareLicensesImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx',
        ]);

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file('file')->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        $header = array_shift($data);
        $header = array_map('trim', $header);

        $requiredColumns = ['software_name', 'license_key', 'total_seats'];
        $missingColumns = array_diff($requiredColumns, $header);

        if (!empty($missingColumns)) {
            return back()->with('error', __('app.import_error') . ': Missing columns: ' . implode(', ', $missingColumns));
        }

        $vendorMap = Vendor::pluck('id', 'name')->toArray();
        
        $successCount = 0;
        $errors = [];

        DB::beginTransaction();
        try {
            foreach ($data as $rowIndex => $row) {
                if (empty(array_filter($row))) continue;

                $rowData = array_combine($header, $row);
                foreach ($rowData as $key => $value) {
                    $rowData[$key] = trim($value);
                }

                $vendorName = $rowData['vendor_id'] ?? '';
                $vendorId = $vendorMap[$vendorName] ?? null;

                SoftwareLicense::create([
                    'software_name' => $rowData['software_name'],
                    'vendor_id' => $vendorId,
                    'license_key' => $rowData['license_key'],
                    'total_seats' => intval($rowData['total_seats']),
                    'purchase_date' => !empty($rowData['purchase_date']) ? $rowData['purchase_date'] : null,
                    'expiration_date' => !empty($rowData['expiration_date']) ? $rowData['expiration_date'] : null,
                    'notes' => $rowData['notes'] ?? null,
                ]);

                $successCount++;
            }

            DB::commit();
            return redirect()->route('software-licenses.index')->with('success', __('app.import_success', ['count' => $successCount]));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', __('app.import_error') . ': ' . $e->getMessage());
        }
    }
}
