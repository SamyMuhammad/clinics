@extends('admin.layouts.app')

@section('title', $item->name)

@section('page-style-plugins')
<link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-level-styles')
<link href="{{ custom_asset('metronic/assets/pages/css/profile-2-rtl.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('extra-css')
@endsection

@section('bar-title', 'العيادات')
@section('page-title', 'مواعيد الأطباء في عيادة ' . $item->name)
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form class="form-inline" role="form" action="{{ route('admin.clinic.updateAppointments', $item->id) }}" method="POST">
                @method('PATCH')
                @csrf
                @foreach ($doctors as $doctor)
                <h3>الطبيب {{ $doctor->name }}</h3>
                <div class="row">
                    @foreach ($days as $day)
                        <div class="col-md-2">
                            <h4>{{ __('days.'.$day) }}</h4>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control timepicker timepicker-no-seconds" name="{{ $doctor->id }}:shift_start_time:{{ strtolower(__('days.'.$day, [], 'en')) }}"
                                    value="{{ $doctor->clinics()->where([['clinic_id', '=', $item->id], ['day_name', '=', strtolower(__('days.'.$day, [], 'en'))]])->first()->pivot->shift_start_time ?? '' }}"
                                    placeholder="{{ __('doctor.shift_start_time') }}"  autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-clock-o"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control timepicker timepicker-no-seconds" name="{{ $doctor->id }}:shift_end_time:{{ strtolower(__('days.'.$day, [], 'en')) }}"
                                    value="{{ $doctor->clinics()->where([['clinic_id', '=', $item->id], ['day_name', '=', strtolower(__('days.'.$day, [], 'en'))]])->first()->pivot->shift_end_time ?? '' }}"
                                    placeholder="{{ __('doctor.shift_end_time') }}"  autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-clock-o"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>
                @endforeach
                <div class="form-actions">
                    <button type="submit" class="btn green">حفظ</button>
                </div>
            </form>
            <!-- END FORM-->
        </div>        
    </div>
</div>
@endsection

@section('page-script-plugins')
<script src="{{ custom_asset('metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
<script src="{{ custom_asset('metronic/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ custom_asset('metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-level-scripts')
<script src="{{ custom_asset('metronic/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
@endsection
@section('extra-js')
@endsection