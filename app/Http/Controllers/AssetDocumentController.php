<?php

namespace App\Http\Controllers;

use App\Models\AssetDocument;
use App\Models\HardwareAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AssetDocumentController extends Controller
{
    public function index(HardwareAsset $hardwareAsset)
    {
        $documents = $hardwareAsset->documents()->latest()->paginate(10);
        return view('asset-documents.index', compact('hardwareAsset', 'documents'));
    }

    public function create(HardwareAsset $hardwareAsset)
    {
        return view('asset-documents.create', compact('hardwareAsset'));
    }

    public function store(Request $request, HardwareAsset $hardwareAsset)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'max:10240'],
        ]);

        $file = $validated['file'];
        $path = $file->store('asset-documents/' . $hardwareAsset->id, 'public');

        $document = AssetDocument::create([
            'hardware_asset_id' => $hardwareAsset->id,
            'title' => $validated['title'],
            'file_path' => $path,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'uploaded_by' => auth()->id(),
        ]);

        $this->logAudit('create', $document, 'Uploaded document: ' . $document->title . ' for asset: ' . $hardwareAsset->asset_tag);

        return redirect()->route('hardware-assets.show', $hardwareAsset)->with('success', 'Document uploaded successfully.');
    }

    public function show(AssetDocument $assetDocument)
    {
        return response()->file(storage_path('app/public/' . $assetDocument->file_path));
    }

    public function download(AssetDocument $assetDocument)
    {
        return Storage::disk('public')->download($assetDocument->file_path, $assetDocument->title . '.' . $assetDocument->file_type);
    }

    public function destroy(AssetDocument $assetDocument)
    {
        $hardwareAsset = $assetDocument->hardwareAsset;
        
        Storage::disk('public')->delete($assetDocument->file_path);
        
        $this->logAudit('delete', $assetDocument, 'Deleted document: ' . $assetDocument->title);
        
        $assetDocument->delete();

        return redirect()->route('hardware-assets.show', $hardwareAsset)->with('success', 'Document deleted successfully.');
    }
}
