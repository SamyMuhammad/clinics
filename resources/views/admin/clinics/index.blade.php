@extends('admin.layouts.app')

@section('title', 'العيادات')
@include('layouts._datatables_assets')

@section('extra-css')
@endsection
@section('bar-title', 'العيادات')
@section('page-title', 'العيادات')

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
                                    {{-- Start Button Group --}}
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            @can('show clinics')
                                                <li><a href="{{ route('admin.clinic.show', $item->id) }}">عرض</a></li>
                                            @endcan

                                            @can('edit clinics')
                                                <li><a href="{{ route('admin.clinic.edit', $item->id) }}">تعديل</a></li>
                                                <li><a href="{{ route('admin.clinic.editAppointments', $item->id) }}">مواعيد الأطباء</a></li>
                                            @endcan

                                            @can('view reservations')
                                                <li><a href="{{ route('admin.clinic.reservations', $item->id) }}">الحجوزات</a></li>
                                            @endcan

                                            @can('delete clinics')
                                                <li>
                                                    <form action="{{ route('admin.clinic.destroy', $item->id) }}" method="POST" class="destroy-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" onclick="deleteConfirmation()" class="btn-group-btn">حذف</button>
                                                    </form>
                                                </li>
                                            @endcan
                                        </ul>
                                    </div>
                                    {{-- End Button Group --}}
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
