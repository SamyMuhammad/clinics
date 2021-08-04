@extends('admin.layouts.app')

@section('title', __('doctor.waitingList'))
@include('layouts._datatables_assets')

@section('extra-css')
@endsection
@section('bar-title', __('doctor.waitingList'))
@section('page-title', __('doctor.waitingList'))

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
                            <th>{{ __('patients.code') }}</th>
                            <th>الاسم</th>
                            <th>العمر</th>
                            <th>الجنس</th>
                            <th>الحالة الاجتماعية</th>
                            <th class="text-center">الخيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $item)
                            <tr>
                                <td class="iteration text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->age }}</td>
                                <td>{{ $item->gender }}</td>
                                <td>{{ $item->social_status }}</td>
                                <td>
                                    <a href="{{ route('admin.admin.show', $item->id) }}" class="btn blue-sharp btn-outline sbold uppercase">عرض</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
    <div class="col-md-12">{!! $admins->render() !!}</div>
</div>
@endsection

@section('extra-js')
@endsection
