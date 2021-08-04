@extends('admin.layouts.app')

@section('page-level-styles')
<link href="{{ asset('metronic/assets/pages/css/invoice-rtl.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'عيادة '. $item->ar_name)

@section('extra-css')
@endsection
@section('bar-title', 'العيادات')
@section('page-title', 'عيادة '. $item->ar_name)

@section('content')
<div class="container">
    <table class="show-data">
        <tr class="data-group">
            <th>الاسم باللغة العربية</th>
            <td>{{ $item->ar_name }}</td>
        </tr>
        <tr class="data-group">
            <th>الاسم باللغة الإنجليزية</th>
            <td>{{ $item->en_name }}</td>
        </tr>
        <tr class="data-group">
            <th>أطباء العيادة</th>
            <td>
                <ul>
                    @forelse ($item->doctors as $doctor)
                        <li>{{ $doctor->name }}</li>
                    @empty
                    لا يوجد
                    @endforelse    
                </ul>
            </td>
        </tr>
        <tr class="data-group">
            <th>تاريخ الإنشاء</th>
            <td>{{ $item->created_at }}</td>
        </tr>
        <tr class="data-group">
            <th>تاريخ آخر تعديل</th>
            <td>{{ $item->updated_at }}</td>
        </tr>
    </table>
</div>
@endsection

@section('extra-js')
@endsection