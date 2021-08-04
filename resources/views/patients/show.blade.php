@extends(request()->routeIs('admin.patient.show') ? 'admin.layouts.app' : 'layouts.app')

@section('page-level-styles')
<link href="{{ custom_asset('metronic/assets/pages/css/invoice-rtl.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', __('patients.patient').' '.$item->code)

@section('extra-css')
@endsection
@section('bar-title', __('patients.patients'))
@section('page-title')
{{ __('patients.patient').' '.$item->code }}
@doctor
@if(!request()->routeIs('admin.*'))
{{-- <a href="#rays" data-toggle="modal" class="btn btn-primary @if(app()->getLocale() === 'ar' ) float-left @else float-right @endif">{{ __('patients.rayRequest') }}</a>
<a href="#medical-test" data-toggle="modal" class="btn btn-primary @if(app()->getLocale() === 'ar' ) float-left @else float-right @endif">{{ __('patients.medicalTestRequest') }}</a> --}}
<div class="btn-group btn-group-solid @if(app()->getLocale() === 'ar' ) float-left @else float-right @endif">
    <button type="button" class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-ellipsis-horizontal"></i> {{ __('patients.sendRequest') }}
        <i class="fa fa-angle-down"></i>
    </button>
    <ul class="dropdown-menu">
        <li>
            <a href="#rays" data-toggle="modal"> {{ __('patients.rayRequest') }} </a>
        </li>
        <li>
            <a href="#medical-test" data-toggle="modal"> {{ __('patients.medicalTestRequest') }} </a>
        </li>
    </ul>
</div>
@endif
@enddoctor
@endsection

@section('content')
<div class="container">
    <table class="show-data">
        <tr class="data-group">
            <th>{{ __('patients.code') }}</th>
            <td>{{ $item->code }}</td>
        </tr>
        <tr class="data-group">
            <th>{{ __('patients.national_id') }}</th>
            <td>{{ $item->national_id }}</td>
        </tr>
        <tr class="data-group">
            <th>{{ __('patients.ar_name') }}</th>
            <td>{{ $item->ar_name }}</td>
        </tr>
        <tr class="data-group">
            <th>{{ __('patients.en_name') }}</th>
            <td>{{ $item->en_name }}</td>
        </tr>
        <tr class="data-group">
            <th>{{ __('patients.phone') }}</th>
            <td>{{ $item->phone }}</td>
        </tr>
        <tr class="data-group">
            <th>{{ __('patients.nationality') }}</th>
            <td>{{ $item->nationality }}</td>
        </tr>
        <tr class="data-group">
            <th>{{ __('patients.age') }}</th>
            <td>{{ $item->age }}</td>
        </tr>
        <tr class="data-group">
            <th>{{ __('patients.gender.title') }}</th>
            <td>{{ __('patients.gender.'.$item->gender) }}</td>
        </tr>
        <tr class="data-group">
            <th>{{ __('patients.social_status.title') }}</th>
            <td>{{ __('patients.social_status.'.$item->social_status) }}</td>
        </tr>
        <tr class="data-group">
            <th>{{ __('patients.type.title') }}</th>
            <td>{{ __('patients.type.'.$item->type) }}</td>
        </tr>
        <tr class="data-group">
            <th>{{ __('patients.payment_method.title') }}</th>
            <td>{{ __('patients.payment_method.'.$item->payment_method) }}</td>
        </tr>
        <tr class="data-group">
            <th>{{ __('patients.status.title') }}</th>
            <td>{{ __('patients.status.'.$item->status) }}</td>
        </tr>
        <tr class="data-group">
            <th>{{ __('patients.address') }}</th>
            <td>{{ $item->address }}</td>
        </tr>
        <tr class="data-group">
            <th>{{ __('patients.room') }}</th>
            <td>{{ optional($item->room)->room_number ?? '---'}}</td>
        </tr>
        <tr class="data-group">
            <th>{{ __('patients.insuranceCompany') }}</th>
            <td>{{ optional($item->company)->name ?? '---'}}</td>
        </tr>
        <tr class="data-group">
            <th>{{ __('discounts.discount') }}</th>
            <td>{{ optional($item->discount)->name ?? '---'}}</td>
        </tr>
    </table>
    @doctor
    <div class="col-md-3">
        <h3>{{ __('patients.diagnoses') }}</h3>
        @forelse ($diagnoses as $key => $value)
        <h4>{{ $key }}</h4>
        <p>{{ $value }}</p>
        @empty
        <p>{{ __('patients.noDiagnoses') }}</p>
        @endforelse
    </div>

    <div class="col-md-3">
        <h3>{{ __('patients.files') }}</h3>
        @forelse ($item->files()->files()->get() as $file)
        <h4>
            <a target="_blank" href="{{ $file->url() }}" style="word-wrap: break-word">{!! $file->HTMLName !!}</a> <small>{{ $file->created_at->diffForHumans() }}</small>
        </h4>
        <p>{{ $file->description }}</p>
        @empty
        <p>{{ __('patients.noFiles') }}</p>
        @endforelse
    </div>

    <div class="col-md-3">
        <h3>{{ __('patients.rays') }}</h3>
        @forelse ($item->files()->rays()->get() as $file)
        <h4>
            <a target="_blank" href="{{ $file->url() }}">{!! $file->HTMLName !!}</a> <small>{{ $file->created_at->diffForHumans() }}</small>
        </h4>
        <p>{{ $file->description }}</p>
        @empty
        <p>{{ __('patients.noRays') }}</p>
        @endforelse
    </div>

    <div class="col-md-3">
        <h3>{{ __('patients.tests') }}</h3>
        @forelse ($item->files()->tests()->get() as $file)
        <h4>
            <a target="_blank" href="{{ $file->url() }}">{!! $file->HTMLName !!}</a> <small>{{ $file->created_at->diffForHumans() }}</small>
        </h4>
        <p>{{ $file->description }}</p>
        @empty
        <p>{{ __('patients.noTests') }}</p>
        @endforelse
    </div>
    @enddoctor
</div>
@doctor
@if(!request()->routeIs('admin.*'))
<div class="modal fade in" id="rays" tabindex="-1" role="basic" aria-hidden="true"
    style="display: none; padding-right: 17px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{ __('patients.rayRequest') }}</h4>
            </div>
            <div class="modal-body">
                <form id="raysRequest-form" action="{{ route('patient.raysRequest', $item->id) }}" method="POST">
                    @csrf
                    <h4>{{ __('patients.chooseRaysTypes') }}</h4>
                    <div class="md-checkbox">
                        <div class="md-checkbox-inline">
                            @foreach($raysTypes as $type)
                            <div class="md-checkbox">
                                <input type="checkbox" name="raysTypes[]" id="checkbox{{ $type->id }}"
                                    value="{{ $type->id }}" class="md-check permission-checkbox">
                                <label for="checkbox{{$type->id}}">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ $type->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="raysRequest-form" class="btn green">{{ __('profile.submit') }}</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

{{-- Medical Tests Modal --}}
<div class="modal fade in" id="medical-test" tabindex="-1" role="basic" aria-hidden="true"
    style="display: none; padding-right: 17px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{ __('patients.medicalTestRequest') }}</h4>
            </div>
            <div class="modal-body">
                <form id="medicalTest-form" action="{{ route('patient.medicalTestRequest', $item->id) }}" method="POST">
                    @csrf
                    <h4>{{ __('patients.chooseMedicalTest') }}</h4>
                    <div class="md-checkbox">
                        <div class="md-checkbox-inline">
                            @foreach($medicalTests as $test)
                            <div class="md-checkbox">
                                <input type="checkbox" name="medicalTests[]" id="test-checkbox{{ $test->id }}"
                                    value="{{ $test->id }}" class="md-check permission-checkbox">
                                <label for="test-checkbox{{ $test->id }}">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ $test->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" form="medicalTest-form" class="btn green">{{ __('profile.submit') }}</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endif
@enddoctor
@endsection

@section('extra-js')
@endsection
