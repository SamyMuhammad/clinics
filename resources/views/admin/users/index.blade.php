@extends('admin.layouts.app')

@section('title', 'الأعضاء')
@include('layouts._datatables_assets')

@section('extra-css')
<style>
    td.photo-field{
       width: 10%;
    }
</style>
@endsection
@section('bar-title', 'الأعضاء')
@section('page-title', 'الأعضاء')

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
                            <th>الصورة</th>
                            <th>الاسم</th>
                            <th>الهاتف</th>
                            <th>البريد الإلكتروني</th>
                            <th>العنوان</th>
                            <th class="text-center">الخيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                            <tr>
                                <td class="iteration text-center">{{ $loop->iteration }}</td>
                                <td class="photo-field">
                                    <img class="table-photo" src="{{ asset($item->fullPhotoPath) }}" alt="{{ $item->name }}">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->address }}</td>
                                <td>
                                    @can('edit users')
                                    <a href="{{ route('admin.user.edit', $item->id) }}" class="btn purple-sharp btn-outline sbold uppercase">تعديل</a>
                                    @endcan

                                    @can('show users')
                                    <a href="{{ route('admin.user.show', $item->id) }}" class="btn blue-sharp btn-outline sbold uppercase">عرض</a>
                                    @endcan

                                    @can('view reservations')
                                    @if ($item->isDoctor())
                                    <a href="{{ route('admin.doctorData.reservations', $item->id) }}" class="btn green btn-outline sbold uppercase">الحجوزات</a>
                                    @endif
                                    @endcan

                                    @can('delete users')
                                    <form action="{{ route('admin.user.destroy', $item->id) }}" method="POST" class="destroy-form">
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
    <div class="col-md-12">{!! $users->render() !!}</div>
</div>
@endsection

@section('extra-js')
@endsection
