@extends('admin.layouts.app')

@section('title', 'التخفيضات')

@section('extra-css')
@endsection

@section('bar-title', 'التخفيضات')
@section('page-title', 'تعديل تخفيض')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ route('admin.discount.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
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