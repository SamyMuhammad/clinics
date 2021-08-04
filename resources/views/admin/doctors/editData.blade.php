@extends('admin.layouts.app')

@section('title', 'الأطباء')

@section('extra-css')
@endsection

@section('bar-title', 'الأطباء')
@section('page-title', 'بيانات الطبيب ' . $item->name)
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ route('admin.doctorData.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                @include('admin.doctors._fields')
            </form>
            <!-- END FORM-->
        </div>        
    </div>
</div>
@endsection

@section('extra-js')
@endsection