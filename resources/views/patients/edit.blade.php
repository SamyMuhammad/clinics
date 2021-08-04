@extends(request()->routeIs('admin.patient.edit') ? 'admin.layouts.app' : 'layouts.app')

@section('title', __('patients.patients'))

@section('extra-css')
@endsection

@section('bar-title', __('patients.patients'))
@section('page-title', __('patients.patient').' '.$item->code)
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ request()->routeIs('admin.patient.edit') ? route('admin.patient.update', $item->id) :route('patient.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
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