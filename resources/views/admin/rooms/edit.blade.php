@extends('admin.layouts.app')

@section('title', 'الغرف')

@section('extra-css')
@endsection

@section('bar-title', 'الغرف')
@section('page-title', 'تعديل غرفة')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ route('admin.room.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                @include('admin.rooms._form')
            </form>
            <!-- END FORM-->
        </div>        
    </div>
</div>
@endsection

@section('extra-js')
@endsection