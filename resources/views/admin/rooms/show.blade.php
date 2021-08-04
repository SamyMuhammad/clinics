@extends('admin.layouts.app')

@section('page-level-styles')
<link href="{{ asset('metronic/assets/pages/css/invoice-rtl.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'غرفة '. $item->room_number)

@section('extra-css')
@endsection
@section('bar-title', 'الغرف')
@section('page-title', 'غرفة '. $item->room_number)

@section('content')
<div class="container">
    <table class="show-data">
        <tr class="data-group">
            <th>رقم الطابق</th>
            <td>{{ $item->floor_number }}</td>
        </tr>
        <tr class="data-group">
            <th>رقم الغرفة</th>
            <td>{{ $item->room_number }}</td>
        </tr>
    </table>
</div>
@endsection

@section('extra-js')
@endsection