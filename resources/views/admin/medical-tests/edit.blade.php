@extends('admin.layouts.app')

@section('title', 'أنواع التحاليل')

@section('extra-css')
@endsection

@section('bar-title', 'أنواع التحاليل')
@section('page-title', 'تعديل')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ route('admin.medical-test.update', $item->id) }}" method="POST">
                @method('PATCH')
                @csrf
                @include('admin.medical-tests._form')
            </form>
            <!-- END FORM-->
        </div>        
    </div>
</div>
@endsection

@section('extra-js')
@endsection