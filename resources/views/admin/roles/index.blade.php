@extends('admin.layouts.app')

@section('title', request()->routeIs('admin.role.admins') ? 'أدوار المديرين' : 'أدوار المستخدمين ')
@include('layouts._datatables_assets')

@section('extra-css')
@endsection
@section('bar-title', request()->routeIs('admin.role.admins') ? 'أدوار المديرين' : 'أدوار المستخدمين ')
@section('page-title')
    {{ request()->routeIs('admin.role.admins') ? 'أدوار المديرين' : 'أدوار المستخدمين ' }}
    @can('create roles')
        @if (request()->routeIs('admin.role.admins'))
        <a class="btn btn-primary" href="{{ route('admin.role.createFor', 'admins') }}" style="float: left;">إضافة</a>
        @else
        <a class="btn btn-primary" href="{{ route('admin.role.createFor', 'users') }}" style="float: left;">إضافة</a>
        @endif
    @endcan
@endsection

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
                            <th class="text-center">الاسم بالعربية</th>
                            <th class="text-center">الاسم بالإنجليزية</th>
                            <th class="text-center">عدد الصلاحيات</th>
                            <th class="text-center">الخيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $item)
                            <tr>
                                <td class="iteration text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->ar_name }}</td>
                                <td class="text-center">{{ $item->name }}</td>
                                <td class="text-center">{{ $item->permissions->count() }} من مجمل {{ $permissions_count }}</td>
                                <td class="text-center">
                                    @can('edit roles')
                                    <a href="{{ request()->routeIs('admin.role.admins') ? route('admin.role.editFor',['role' => $item->id, 'param' => 'admins']) : route('admin.role.editFor',['role' => $item->id, 'param' => 'users']) }}" class="btn purple-sharp btn-outline sbold uppercase">تعديل</a>
                                    @endcan

                                    @can('show roles')
                                    <a href="{{ route('admin.role.show', $item->id) }}" class="btn blue-sharp btn-outline sbold uppercase">عرض</a>
                                    @endcan

                                    @can('delete roles')
                                    <form action="{{ route('admin.role.destroy', $item->id) }}" method="POST" class="destroy-form">
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
    <div class="col-md-12">{!! $roles->render() !!}</div>
</div>
@endsection

@section('extra-js')
@endsection
