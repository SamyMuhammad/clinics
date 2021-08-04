@extends('admin.layouts.app')

@section('title', 'الشركات')
@include('layouts._datatables_assets')

@section('extra-css')
<style>
    td.photo-field{
       width: 10%;
    }
</style>
@endsection
@section('bar-title', 'الشركات')
@section('page-title', 'الشركات')

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
                            <th>الهاتف</th>
                            <th>البريد الإلكتروني</th>
                            <th>المدينة</th>
                            {{-- <th>العنوان</th> --}}
                            <th class="text-center">الخيارات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td class="iteration text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->ar_name }}</td>
                                <td>{{ $item->en_name }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->city }}</td>
                                {{-- <td>{{ $item->address }}</td> --}}
                                <td class="text-center">
                                    @can('show companies')
                                    <a href="{{ route('admin.company.show', $item->id) }}" class="btn blue-sharp btn-outline sbold uppercase">عرض</a>
                                    @endcan

                                    @can('edit companies')
                                    <a href="{{ route('admin.company.edit', $item->id) }}" class="btn purple-sharp btn-outline sbold uppercase">تعديل</a>
                                    @endcan

                                    @can('delete companies')
                                    <form action="{{ route('admin.company.destroy', $item->id) }}" method="POST" class="destroy-form">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit"  onclick="deleteConfirmation()" class="btn red-mint btn-outline sbold uppercase">حذف</button>
                                    </form>
                                    @endcan

                                    @can('view patients')
                                            <a href="{{ route('admin.company.patients', $item->id) }}" class="btn green-sharp btn-outline sbold uppercase">المرضى</a>
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
