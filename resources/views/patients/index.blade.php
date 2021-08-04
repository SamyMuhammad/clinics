@extends(request()->routeIs('admin.*') ? 'admin.layouts.app' : 'layouts.app')

@section('title', __('patients.patients'))
@include('layouts._datatables_assets')

@section('extra-css')
@endsection
@section('bar-title', __('patients.patients'))
{{-- @section('page-title', (request()->routeIs('patient.blockedPatients') || request()->routeIs('admin.patient.blockedPatients')) ? __('patients.blockedPatients') : __('patients.patients')) --}}
@section('page-title', $title)

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
                            <th>{{ __('patients.code') }}</th>
                            <th>{{ __('patients.ar_name') }}</th>
                            <th>{{ __('patients.phone') }}</th>
                            <th>{{ __('patients.national_id') }}</th>
                            <th>{{ __('patients.nationality') }}</th>
                            <th>{{ __('patients.age') }}</th>
                            <th>{{ __('patients.gender.title') }}</th>
                            <th class="text-center">{{ __('datatables.options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patients as $item)
                        <tr>
                            <td class="iteration text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->ar_name }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->national_id }}</td>
                            <td>{{ $item->nationality }}</td>
                            <td>{{ $item->age }}</td>
                            <td>{{ __('patients.gender.'.$item->gender) }}</td>
                            <td>
                                {{-- Start Button Group --}}
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Actions <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @can('make reservations')
                                            <li><a href="{{ request()->routeIs('admin.*') ? route('admin.reservation.showForm', $item->id) : route('reservation.showForm', $item->id) }}">
                                                    {{ __('patients.makeReservation') }}
                                                </a></li>
                                        @endcan
                                        @can('show patients')
                                            <li><a href="{{ request()->routeIs('admin.*') ? route('admin.patient.show', $item->id) : route('patient.show', $item->id) }}">
                                                    {{ __('datatables.show') }}
                                                </a></li>
                                            @if (! request()->routeIs('admin.*'))
                                                @doctor
                                                <li><a href="{{ route('patient.diagnoses', $item->id) }}">
                                                        {{ __('patients.diagnoses') }}
                                                    </a></li>
                                                @enddoctor
                                            @endif
                                        @endcan

                                        @can('edit patients')
                                            <li><a href="{{ request()->routeIs('admin.*') ? route('admin.patient.edit', $item->id) : route('patient.edit', $item->id) }}">
                                                    {{ __('datatables.edit') }}
                                                </a></li>
                                        @endcan

                                        @can('delete patients')
                                            <li><form action="{{ request()->routeIs('admin.*') ? route('admin.patient.destroy', $item->id) : route('patient.destroy', $item->id) }}" method="POST"
                                                      class="destroy-form mt-5">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" onclick="deleteConfirmation()"
                                                            class="btn-group-btn">{{ __('datatables.delete') }}
                                                    </button>
                                                </form></li>
                                        @endcan

                                        @can('view reservations')
                                            <li><a href="{{ route('admin.patient.reservations', $item->id) }}">الحجوزات</a></li>
                                        @endcan

                                        @can('view files')
                                            <li><a href="{{ route('admin.patient.files.index', $item->id) }}">الملفات</a></li>
                                        @endcan
                                    </ul>
                                </div>
                                {{-- End Button Group --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
    <div class="col-md-12">{!! $patients->render() !!}</div>
</div>
@endsection

@section('extra-js')
@endsection
