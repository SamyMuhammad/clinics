@extends('admin.layouts.app')

@section('page-level-styles')
<link href="{{ asset('metronic/assets/pages/css/invoice-rtl.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'تخفيض '. $item->ar_name)

@section('extra-css')
@endsection
@section('bar-title', 'التخفيضات')
@section('page-title', 'تخفيض '. $item->ar_name)

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
            <th>الهاتف</th>
            <td>{{ $item->phone }}</td>
        </tr>
        <tr class="data-group">
            <th>البريد الإلكتروني</th>
            <td>{{ $item->email }}</td>
        </tr>
        <tr class="data-group">
            <th>المدينة</th>
            <td>{{ $item->city }}</td>
        </tr>
        <tr class="data-group">
            <th>العنوان</th>
            <td>{{ $item->address }}</td>
        </tr>
    </table>
</div>
@endsection

@section('extra-js')
@endsection