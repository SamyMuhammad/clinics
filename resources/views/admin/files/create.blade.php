@extends('admin.layouts.app')

@section('title', 'ملفات المريض '  . $patient->name)

@section('extra-css')
@endsection

@section('bar-title', 'ملفات المريض '  . $patient->name)
@section('page-title', 'إضافة')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ route('admin.patient.files.store', ['patient' => $patient->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.files._form')
            </form>
            <!-- END FORM-->
        </div>        
    </div>
</div>
@endsection

@section('extra-js')
@endsection