@extends('admin.layouts.app')

@section('title', 'الأدوار')

@section('extra-css')
@endsection

@section('bar-title', 'الأدوار')
@section('page-title', 'إضافة دور')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ route('admin.role.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.roles._form')
            </form>
            <!-- END FORM-->
        </div>        
    </div>
</div>
@endsection

@section('extra-js')
@endsection