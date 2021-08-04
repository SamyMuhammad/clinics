@extends('admin.layouts.app')

@section('title', 'العيادات')

@section('extra-css')
@endsection

@section('bar-title', 'العيادات')
@section('page-title', 'تعديل عيادة')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ route('admin.clinic.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                @include('admin.clinics._form')
            </form>
            <!-- END FORM-->
        </div>        
    </div>
</div>
@endsection

@section('extra-js')
@endsection