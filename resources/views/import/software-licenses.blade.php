@extends('layouts.master')

@section('title', __('app.import') . ' ' . __('app.software_licenses'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.import') @lang('app.software_licenses')</h1>
    <a href="{{ route('software-licenses.index') }}" class="btn btn-sm btn-secondary">@lang('app.back')</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.upload') @lang('app.file')</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('import.software-licenses.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">@lang('app.select_file') (Excel .xlsx)</label>
                        <input type="file" name="file" id="file" class="form-control-file @error('file') is-invalid @enderror" accept=".xlsx" required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">@lang('app.import')</button>
                    <a href="{{ route('import.software-licenses.template') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-download"></i> @lang('app.download_template')
                    </a>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.import_instructions')</h6>
            </div>
            <div class="card-body">
                <p><strong>@lang('app.required_columns'):</strong></p>
                <ul>
                    <li>software_name</li>
                    <li>license_key</li>
                    <li>total_seats</li>
                </ul>
                <p><strong>@lang('app.optional_columns'):</strong></p>
                <ul>
                    <li>vendor_id (dropdown - select from list)</li>
                    <li>purchase_date (YYYY-MM-DD)</li>
                    <li>expiration_date (YYYY-MM-DD)</li>
                    <li>notes</li>
                </ul>
                <p class="text-muted"><small>* Columns with dropdowns have selectable options. The "Reference" sheet contains all available options.</small></p>
            </div>
        </div>
    </div>
</div>
@endsection
