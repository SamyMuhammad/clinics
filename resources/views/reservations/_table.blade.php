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
                            <th>{{ __('patients.patient') }}</th>
                            <th>{{ __('patients.age') }}</th>
                            <th>{{ __('patients.gender.title') }}</th>
                            <th>{{ __('reservations.doctor') }}</th>
                            <th>{{ __('reservations.clinic') }}</th>
                            <th>{{ __('reservations.date') }}</th>
                            <th>{{ __('reservations.time') }}</th>
                            <th>{{ __('reservations.status.title') }}</th>

                            @if (request()->routeIs('admin.reservation.*') || ! request()->routeIs('admin.*'))
                            <th class="text-center">{{ __('datatables.options') }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items->sortBy('clinic_id') as $item)
                        <tr>
                            <td class="iteration text-center">{{ $loop->iteration }}</td>
                            <td>{{ optional($item->patient)->name }}</td>
                            <td>{{ optional($item->patient)->age }}</td>
                            <td>{{ optional($item->patient)->gender }}</td>
                            <td>{{ optional($item->doctor)->name }}</td>
                            <td>{{ optional($item->clinic)->name }}</td>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->timeInFormat }}</td>
                            <td>
                                <select name="status" class="form-control" data-item-id="{{ $item->id }}" onchange="reservationChangeStatus(this)">
                                    @foreach (App\Models\Reservation::getEnumValues('status') as $value)
                                        <option value="{{ $value }}" {{ $item->status === $value ? 'selected' : '' }}>
                                            {{ __('reservations.status.'.$value) }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            @if (request()->routeIs('admin.reservation.*') || ! request()->routeIs('admin.*'))
                            <td>
                                @if (! request()->routeIs('admin.*'))
                                    @can('show patients')
                                        <a href="{{ route('patient.show', optional($item->patient)->id) }}"
                                            class="btn blue-sharp btn-outline sbold uppercase">{{ __('datatables.show') }}
                                        </a>

                                        @doctor
                                        <a href="{{ route('patient.diagnoses', optional($item->patient)->id) }}" class="btn dark btn-outline sbold uppercase">
                                            {{ __('patients.diagnoses') }}
                                        </a>
                                        @enddoctor

                                    @endcan
                                @endif

                                @can('delete reservations')
                                <form action="{{ route('reservation.destroy', $item->id) }}" method="POST"
                                    class="destroy-form mt-5">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" onclick="deleteConfirmation()"
                                        class="btn red-mint btn-outline sbold uppercase">{{ __('reservations.remove') }}
                                    </button>
                                </form>
                                @endcan

                                {{-- @doctor
                                <form action="{{ route('patient.changeStatus', optional($item->patient)->id) }}" method="POST">
                                    @method('PATCH')
                                    @csrf
                                    <button type="submit" onclick="deleteConfirmation()" class="btn yellow btn-outline sbold uppercase">
                                        {{ __('patients.closeFile') }}
                                    </button>
                                </form>
                                @enddoctor --}}
                            </td>
                            @endif
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
@section('extra-js')
    @include('reservations.statusChangeScript')
@endsection
