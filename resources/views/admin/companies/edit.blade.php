@extends('admin.layouts.app')

@section('title', 'الشركات')

@section('extra-css')
@endsection

@section('bar-title', 'الشركات')
@section('page-title', 'تعديل شركة')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ route('admin.company.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                @include('admin.companies._form')
            </form>
            <!-- END FORM-->
        </div>        
    </div>
</div>
@endsection

@section('extra-js')
@endsection