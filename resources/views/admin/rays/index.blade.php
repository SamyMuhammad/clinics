@extends('admin.layouts.app')

@section('title', 'أنواع الآشعة')
@include('layouts._datatables_assets')

@section('extra-css')
<style>
    td.photo-field{
       width: 10%;
    }
</style>
@endsection
@section('bar-title', 'أنواع الآشعة')
@section('page-title', 'أنواع الآشعة')

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>الاسم باللغة العربية</th>
                            <th>الاسم باللغة الإنجليزية</th>
                            <th class="text-center">الخيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td class="iteration text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->ar_name }}</td>
                                <td>{{ $item->en_name }}</td>
                                <td class="text-center">
                                    @can('edit rays')
                                    <a href="{{ route('admin.rays.edit', $item->id) }}" class="btn purple-sharp btn-outline sbold uppercase">تعديل</a>
                                    @endcan

                                    @can('show rays')
                                    <a href="{{ route('admin.rays.show', $item->id) }}" class="btn blue-sharp btn-outline sbold uppercase">عرض</a>
                                    @endcan

                                    @can('delete rays')
                                    <form action="{{ route('admin.rays.destroy', $item->id) }}" method="POST" class="destroy-form">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit"  onclick="deleteConfirmation()" class="btn red-mint btn-outline sbold uppercase">حذف</button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
    <div class="col-md-12">{!! $items->render() !!}</div>
</div>
@endsection

@section('extra-js')
@endsection
