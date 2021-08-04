@extends('admin.layouts.app')

@section('page-level-styles')
<link href="{{ asset('metronic/assets/pages/css/invoice-rtl.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', 'العضو '. $user->name)

@section('extra-css')
@endsection
@section('bar-title', 'الأعضاء')
@section('page-title', 'العضو '. $user->name)

@section('content')
<div class="container">
    <table class="show-data">
        <tr class="data-group">
            <th>الاسم</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr class="data-group">
            <th>الهاتف</th>
            <td>{{ $user->phone }}</td>
        </tr>
        <tr class="data-group">
            <th>البريد الإلكتروني</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr class="data-group">
            <th>الوظيفة</th>
            <td>{{ __('users.job.'.$user->job) }}</td>
        </tr>
        <tr class="data-group">
            <th>العنوان</th>
            <td>{{ $user->address }}</td>
        </tr>
        <tr class="data-group">
            <th>الراتب</th>
            <td>{{ $user->salary }}</td>
        </tr>
        <tr class="data-group">
            <th>مدة التعاقد</th>
            <td>{{ $user->contract_period }}</td>
        </tr>
        <tr class="data-group">
            <th>الصورة</th>
            <td>
                <img src="{{ asset($user->fullPhotoPath) }}" class="form-photo" alt="{{ $user->name }}" style="margin: 10px auto;">
            </td>
        </tr>
        @if ($user->isDoctor())
        <tr class="data-group">
            <th>التخصص الطبي</th>
            <td>{{ $user->data->specialization ?? '----' }}</td>
        </tr>
        <tr class="data-group">
            <th>العيادات المسجل بها</th>
            <td>
                <ul>
                    @forelse ($user->clinics->unique() as $item)
                        <li>{{ $item->ar_name }}</li>
                    @empty
                    <p>----</p>
                    @endforelse    
                </ul>
            </td>
        </tr>
        @endif
        <tr class="data-group">
            <th>الأدوار والصلاحيات</th>
            <td>
                <ul>
                    @forelse ($user->roles as $item)
                        <li>{{ $item->ar_name }}</li>
                    @empty
                    <p>----</p>
                    @endforelse   
                </ul>
            </td>
        </tr>
        <tr class="data-group">
            <th>تاريخ الإنشاء</th>
            <td>{{ $user->created_at }}</td>
        </tr>
        <tr class="data-group">
            <th>تاريخ آخر تعديل</th>
            <td>{{ $user->updated_at }}</td>
        </tr>
    </table>
</div>
{{-- <div class="col-xs-8 invoice-block">
    <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();"> طباعة
        <i class="fa fa-print"></i>
    </a>
</div> --}}
@endsection

@section('extra-js')
@endsection