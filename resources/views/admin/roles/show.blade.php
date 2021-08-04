@extends('admin.layouts.app')

@section('page-level-styles')
<link href="{{ asset('metronic/assets/pages/css/invoice-rtl.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'الدور '. $role->name)

@section('extra-css')
@endsection
@section('bar-title', 'الأدوار')
@section('page-title', 'الدور '. $role->name)

@section('content')
<div class="container">
    <table class="show-data">
        <tr class="data-group">
            <th>الاسم بالعربية</th>
            <td>{{ $role->ar_name }}</td>
        </tr>
        <tr class="data-group">
            <th>الاسم بالإنجليزية</th>
            <td>{{ $role->name }}</td>
        </tr>
        <tr class="data-group">
            <th>الصلاحيات</th>
            <td>
                <ul>
                    @foreach ($role->permissions as $item)
                        <li class="col-md-4">{{ $item->ar_name }}</li>
                    @endforeach    
                </ul>
            </td>
        </tr>
    </table>
</div>
@endsection

@section('extra-js')
@endsection