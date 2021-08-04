@extends('layouts.app')

@section('title', $user->name)

@section('page-style-plugins')
<link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}"
    rel="stylesheet" type="text/css" />
<link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"
    rel="stylesheet" type="text/css" />
<link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
    rel="stylesheet" type="text/css" />
@endsection

@section('page-level-styles')
<link href="{{ custom_asset('metronic/assets/pages/css/profile-2-rtl.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('extra-css')
@endsection

@section('bar-title', __('doctor.title'))
{{-- @section('page-title', $user->name) --}}
@section('content')
<div class="profile">
    <div class="tabbable-line tabbable-full-width">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_1_1" data-toggle="tab"> {{ __('profile.overview') }} </a>
            </li>
            <li>
                <a href="#tab_1_3" data-toggle="tab"> {{ __('profile.editData') }} </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1_1">
                <div class="row">
                    <div class="col-md-3">
                        <ul class="list-unstyled profile-nav">
                            <li>
                                <img src="{{ asset($user->fullPhotoPath) }}" class="img-responsive pic-bordered"
                                    alt="{{ $user->name }}" />
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-8 profile-info">
                                <h1 class="font-green sbold uppercase">{{ $user->name }}</h1>
                                <div class="children-font-size-15">
                                    @doctor
                                    <p>{{ optional($user->data)->specialization }}</p>
                                    @enddoctor
                                    <p>
                                        {{ $user->email }}
                                    </p>
                                    <ul class="list-inline">
                                        <li>
                                            {!! !empty($user->address) ? '<i
                                                class="fa fa-map-marker"></i>'.$user->address : '' !!}
                                        </li>
                                        <li>
                                            <i class="fa fa-phone"></i>{{ $user->phone }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--end col-md-8-->
                            @if ($user->roles->count() >= 1)
                            <div class="col-md-4">
                                <div class="portlet sale-summary">
                                    <div class="portlet-title">
                                        <div class="caption font-red sbold"> {{ __('profile.rolesAndPermissions') }}
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <ul class="list-unstyled">
                                            @foreach ($user->roles as $item)
                                            <li>
                                                <span
                                                    class="sale-info">{{ app()->getLocale() === 'ar' ? $item->ar_name : $item->name }}</span>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!--end col-md-4-->
                            @endif
                        </div>
                        <!--end row-->
                        @if ($user->isDoctor())
                        <div class="portlet-body">
                            <h4>{{ __('profile.clinics') }}</h4>
                            <table class="table table-striped table-bordered table-advance table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-bold font-size-15">
                                            {{ __('profile.clinic.name') }}</i>
                                        </th>
                                        <th class="text-bold font-size-15">
                                            {{ __('profile.workDays') }}</i>
                                        </th>
                                        <th class="text-bold font-size-15">
                                            {{ __('doctor.shift_start_time') }}
                                        </th>
                                        <th class="text-bold font-size-15">
                                            {{ __('doctor.shift_end_time') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->clinics->sortBy('name') as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td class="text-right">
                                            {{ $item->pivot->day_name ? __('days.'.$item->pivot->day_name) : '---' }}
                                        </td>
                                        <td class="dir-ltr text-right">{{ $item->pivot->startTime ?? '---' }}</td>
                                        <td class="dir-ltr text-right">{{ $item->pivot->endTime ?? '---' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!--tab_1_2-->
            <div class="tab-pane" id="tab_1_3">
                <div class="row profile-account">
                    <div class="col-md-3">
                        <ul class="ver-inline-menu tabbable margin-bottom-10">
                            <li class="active">
                                <a data-toggle="tab" href="#tab_1-1">
                                    <i class="fa fa-cog"></i>{{ __('profile.personalInfo') }}</a>
                                <span class="after"> </span>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab_2-2">
                                    <i class="fa fa-picture-o"></i>{{ __('profile.photo') }}</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#tab_3-3">
                                    <i class="fa fa-lock"></i>{{ __('profile.changePassword') }}</a>
                            </li>
                            @if ($user->isDoctor())
                            <li>
                                <a data-toggle="tab" href="#tab_4-4">
                                    <i class="fa fa-clock-o"></i>{{ __('profile.clinic.workTime') }}</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content">
                            <div id="tab_1-1" class="tab-pane active">
                                <form role="form" action="{{ route('user.updateData') }}" method="POST">
                                    @method('PATCH')
                                    @csrf
                                    <div class="form-group">
                                        <label class="control-label">{{ __('profile.name') }}</label>
                                        <input type="text" name="name" placeholder="{{ __('profile.name') }}"
                                            class="form-control" value="{{ $user->name }}" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">{{ __('profile.phone') }}</label>
                                        <input type="number" name="phone" placeholder="{{ __('profile.phone') }}"
                                            class="form-control" value="{{ $user->phone }}" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">{{ __('profile.email') }}</label>
                                        <input type="text" name="email" placeholder="{{ __('profile.email') }}"
                                            class="form-control" value="{{ $user->email }}" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">{{ __('profile.address') }}</label>
                                        <input type="text" name="address" placeholder="{{ __('profile.address') }}"
                                            class="form-control" value="{{ $user->address }}" />
                                    </div>
                                    <div class="margiv-top-10">
                                        <button type="submit" class="btn green">{{ __('profile.submit') }}</button>
                                    </div>
                                </form>
                            </div>
                            <div id="tab_2-2" class="tab-pane">
                                <form action="{{ route('user.updatePhoto') }}" method="POST"
                                    enctype="multipart/form-data" role="form">
                                    @method('PATCH')
                                    @csrf
                                    <div class="form-group">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                {{-- <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /> --}}
                                                <img src="{{ asset($user->fullPhotoPath) }}" alt="" />
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"
                                                style="max-width: 200px; max-height: 150px;"> </div>
                                            <div>
                                                <span class="btn default btn-file">
                                                    <span class="fileinput-new">{{ __('profile.choosePhoto') }}</span>
                                                    <span
                                                        class="fileinput-exists">{{ __('profile.changePhoto') }}</span>
                                                    <input type="file" name="photo" required>
                                                </span>
                                                <a href="javascript:;" class="btn default fileinput-exists"
                                                    data-dismiss="fileinput">{{ __('profile.remove') }}</a>
                                            </div>
                                        </div>
                                        <div class="clearfix margin-top-10"></div>
                                    </div>
                                    <div class="margin-top-10">
                                        <button class="btn green">{{ __('profile.submit') }}</button>
                                    </div>
                                </form>
                            </div>
                            <div id="tab_3-3" class="tab-pane">
                                <form action="{{ route('user.updatePassword') }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <label class="control-label">{{ __('profile.currentPassword') }}</label>
                                        <input type="password" name="old_password" class="form-control" /> </div>
                                    <div class="form-group">
                                        <label class="control-label">{{ __('profile.password') }}</label>
                                        <input type="password" name="new_password" class="form-control" /> </div>
                                    <div class="form-group">
                                        <label class="control-label">{{ __('profile.password_confirmation') }}</label>
                                        <input type="password" name="new_password_confirmation" class="form-control" />
                                    </div>
                                    <div class="margin-top-10">
                                        <button class="btn green">{{ __('profile.submit') }}</button>
                                    </div>
                                </form>
                            </div>
                            @if ($user->isDoctor())
                            <div id="tab_4-4" class="tab-pane">
                                <form role="form" action="{{ route('doctor.updateWorkTimes') }}" method="POST">
                                    @method('PATCH')
                                    @csrf
                                    @foreach ($user->clinics->unique() as $item)
                                    <h3>{{ $item->name }}</h3>
                                    <div class="row">
                                        @foreach (['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday',
                                        'friday'] as $day)
                                        <div class="col-md-3">
                                            <h4>{{ __('days.'.$day) }}</h4>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control timepicker timepicker-no-seconds"
                                                        name="{{ $item->id }}:shift_start_time:{{ strtolower(__('days.'.$day, [], 'en')) }}"
                                                        value="{{ $user->clinics()->where([['clinic_id', '=', $item->id], ['day_name', '=', strtolower(__('days.'.$day, [], 'en'))]])->first()->pivot->shift_start_time ?? '' }}"
                                                        placeholder="{{ __('doctor.shift_start_time') }}"
                                                        autocomplete="off">
                                                    <span class="input-group-btn">
                                                        <button class="btn default" type="button">
                                                            <i class="fa fa-clock-o"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text"
                                                        class="form-control timepicker timepicker-no-seconds"
                                                        name="{{ $item->id }}:shift_end_time:{{ strtolower(__('days.'.$day, [], 'en')) }}"
                                                        value="{{ $user->clinics()->where([['clinic_id', '=', $item->id], ['day_name', '=', strtolower(__('days.'.$day, [], 'en'))]])->first()->pivot->shift_end_time ?? '' }}"
                                                        placeholder="{{ __('doctor.shift_end_time') }}"
                                                        autocomplete="off">
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
                                    @if ($user->clinics->count() !== 0)
                                    <div class="margiv-top-10">
                                        <button type="submit" class="btn green">{{ __('profile.submit') }}</button>
                                    </div>
                                    @endif
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!--end col-md-9-->
                </div>
            </div>
            <!--end tab-pane-->
        </div>
    </div>
</div>
@endsection

@section('page-script-plugins')
<script src="{{ custom_asset('metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"
    type="text/javascript"></script>
<script src="{{ custom_asset('metronic/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"
    type="text/javascript"></script>
<script src="{{ custom_asset('metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
    type="text/javascript"></script>
@endsection

@section('page-level-scripts')
<script src="{{ custom_asset('metronic/assets/pages/scripts/components-date-time-pickers.min.js') }}"
    type="text/javascript"></script>
@endsection

@section('extra-js')
@endsection