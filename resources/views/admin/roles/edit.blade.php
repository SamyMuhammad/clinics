@extends('admin.layouts.app')

@section('title', 'الأدوار')

@section('extra-css')
@endsection

@section('bar-title', 'الأدوار')
@section('page-title', 'تعديل دور')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ route('admin.role.update', $role->id) }}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
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