@extends('admin.layouts.app')

@section('title', 'الأعضاء')

@section('extra-css')
@endsection

@section('bar-title', 'الأعضاء')
@section('page-title', 'تعديل العضو')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                @include('admin.users._form')
            </form>
            <!-- END FORM-->
        </div>        
    </div>
</div>
@endsection

@section('extra-js')
@endsection