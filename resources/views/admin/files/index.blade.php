@extends(request()->routeIs('admin.*') ? 'admin.layouts.app' : 'layouts.app')

@section('title', 'ملفات المريض ' . $patient->name)
@include('layouts._datatables_assets')

@section('extra-css')
@endsection
@section('bar-title', 'ملفات المريض ' . $patient->name)
@section('page-title')
ملفات المريض {{ $patient->name }}

@can('create files')
<a href="{{ route('admin.patient.files.create', $patient->id) }}" style="float: left" class="btn blue-sharp btn-outline sbold uppercase">
    إضافة ملف
</a>
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
                            <th>الاسم</th>
                            <th>الوصف</th>
                            <th>النوع</th>
                            <th class="text-center">{{ __('datatables.options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td class="iteration text-center">{{ $loop->iteration }}</td>
                            <td>
                                <a target="_blank" href="{{ $item->url() }}">{!! $item->HTMLName !!}</a>
                            </td>
                            <td>{{ $item->description ?? '---' }}</td>
                            <td>{{ $item->arType }}</td>
                            <td>
                                @can('edit files')
                                <a href="{{ route('admin.patient.files.edit', ['patient' => $patient->id, 'file' => $item->id]) }}" class="btn blue-sharp btn-outline sbold uppercase">
                                    تعديل
                                </a>
                                @endcan

                                @can('delete files')
                                <form action="{{ route('admin.patient.files.destroy', ['patient' => $patient->id, 'file' => $item->id]) }}" method="POST"
                                    class="destroy-form">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" onclick="deleteConfirmation()"
                                        class="btn red-mint btn-outline sbold uppercase">{{ __('datatables.delete') }}</button>
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
