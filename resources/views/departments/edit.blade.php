@extends('layouts.master')

@section('title', __('app.edit') . ' ' . __('app.departments'))

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('app.edit') @lang('app.departments')</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('departments.update', $department) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>@lang('app.name')</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $department->name) }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>@lang('app.description')</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $department->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">@lang('app.save')</button>
            <a href="{{ route('departments.index') }}" class="btn btn-secondary">@lang('app.cancel')</a>
        </form>
    </div>
</div>
@endsection
