@extends(request()->routeIs('admin.*') ? 'admin.layouts.app' : 'layouts.app')

@section('title', request()->routeIs('doctor.waitingList') ? __('doctor.waitingList') : __('reservations.reservations'))
@include('layouts._datatables_assets')

@section('extra-css')
@endsection
@section('bar-title', __('doctor.waitingList'))
@section('page-title', __('patients.patients'))

@section('content')

@if (request()->routeIs('admin.reservation.index') || request()->routeIs('admin.reservation.search'))
<div class="margin-bottom-20">
    <h4>البحث في جميع المواعيد</h4>
    <form action="{{ route('admin.reservation.search') }}" method="GET" class="form-inline">
        <div class="form-group">
            <div class="input-group input-medium">
                <input type="text" value="{{ request()->key }}" name="key" class="form-control" placeholder="{{ __('search.placeholder') }}">
                <span class="input-group-btn">
                    <button type="submit" class="btn red">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </div>
    </form>
</div>
@endif

@include('reservations._table', $items)
@endsection