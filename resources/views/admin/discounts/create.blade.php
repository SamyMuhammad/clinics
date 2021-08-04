@extends('admin.layouts.app')

@section('title', 'التخفيضات')

@section('extra-css')
@endsection

@section('bar-title', 'التخفيضات')
@section('page-title', 'إضافة تخفيض')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ route('admin.discount.store') }}" method="POST"{{--  enctype="multipart/form-data" --}}>
                @csrf
                @include('admin.discounts._form')
            </form>
            <!-- END FORM-->
        </div>        
    </div>
</div>
@endsection

@section('extra-js')
@endsection