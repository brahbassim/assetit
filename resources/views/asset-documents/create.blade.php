@extends('layouts.master')

@section('title', __('app.upload') . ' ' . __('app.file'))

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">@lang('app.upload') @lang('app.file') - {{ $hardwareAsset->asset_tag }}</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('hardware-assets.documents.store', $hardwareAsset) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">@lang('app.title')</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="e.g., Invoice, Warranty Card, Manual">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="file">@lang('app.file')</label>
                        <input type="file" name="file" id="file" class="form-control-file @error('file') is-invalid @enderror" required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">@lang('app.max_size', ['size' => '10MB']). @lang('app.allowed_types', ['types' => 'PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, ZIP'])</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">@lang('app.upload')</button>
                    <a href="{{ route('hardware-assets.show', $hardwareAsset) }}" class="btn btn-secondary">@lang('app.cancel')</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
