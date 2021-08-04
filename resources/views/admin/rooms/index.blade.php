@extends('admin.layouts.app')

@section('title', 'الغرف')
@include('layouts._datatables_assets')

@section('extra-css')
<style>
    td.photo-field{
       width: 10%;
    }
</style>
@endsection
@section('bar-title', 'الغرف')
@section('page-title', 'الغرف')

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
                            <th>رقم الطابق</th>
                            <th>رقم الغرفة</th>
                            <th>عدد الأسرة</th>
                            <th>عدد الأشخاص</th>
                            <th class="text-center">الخيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td class="iteration text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->floor_number }}</td>
                                <td>{{ $item->room_number }}</td>
                                <td>{{ $item->beds_count }}</td>
                                <td>{{ $item->residentsCount }}</td>
                                <td class="text-center">

                                    @can('edit rooms')
                                    <a href="{{ route('admin.room.edit', $item->id) }}" class="btn purple-sharp btn-outline sbold uppercase">تعديل</a>
                                    @endcan

                                    @can('delete rooms')
                                    <form action="{{ route('admin.room.destroy', $item->id) }}" method="POST" class="destroy-form">
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
