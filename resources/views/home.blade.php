@extends('layouts.app')
@section('title', __('homepage.title'))

@section('page-title', '')
@section('content')
@can('view patients')
<div>
    <h3>{{ __('search.patients') }}</h3>
    <form action="{{ route('patient.search') }}" method="GET">
        <div class="input-group input-medium">
            <input type="text" name="key" class="form-control" placeholder="{{ __('search.placeholder') }}">
            <span class="input-group-btn">
                <button type="submit" class="btn red">
                    <i class="fa fa-search"></i>
                </button>
            </span>
        </div>
    </form>
</div>
@endcan
@endsection