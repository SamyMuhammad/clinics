@extends(request()->routeIs('admin.patient.create') ? 'admin.layouts.app' : 'layouts.app')

@section('title', __('patients.register'))

@section('extra-css')
@endsection

@section('bar-title', __('patients.patients'))
@section('page-title', __('patients.register'))
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ request()->routeIs('admin.patient.create') ? route('admin.patient.store') : route('patient.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('patients._form')
            </form>
            <!-- END FORM-->
        </div>        
    </div>
</div>
@endsection

@section('extra-js')
@endsection