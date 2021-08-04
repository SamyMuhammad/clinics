@extends('admin.layouts.app')

@section('title', 'أنواع الآشعة')

@section('extra-css')
@endsection

@section('bar-title', 'أنواع الآشعة')
@section('page-title', 'تعديل')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ route('admin.rays.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                @include('admin.rays._form')
            </form>
            <!-- END FORM-->
        </div>        
    </div>
</div>
@endsection

@section('extra-js')
@endsection