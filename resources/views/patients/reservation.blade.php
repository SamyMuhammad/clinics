@extends(request()->routeIs('admin.patient.create') ? 'admin.layouts.app' : 'layouts.app')

@section('title', __('patients.makeReservation'))

@section('page-style-plugins')
<link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}"
    rel="stylesheet" type="text/css" />
<link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"
    rel="stylesheet" type="text/css" />
<link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
    rel="stylesheet" type="text/css" />
@endsection

@section('extra-css')
@endsection

@section('bar-title', __('patients.patients'))
@section('page-title', __('patients.makeReservation'))
@section('content')

@if ($items->count() > 0)
<h4>{{ __('reservations.previousReservations') }}</h4>
@include('reservations._table', $items)
@endif

<div id="alert-div" class="alert alert-warning text-center display-none">
    <button type="button" class="close" onclick="document.getElementById('alert-div').style.display='none';"></button>
    <p id="warning-msg"></p>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body form">
            <div class="row form-body">
                <div class="col-md-6">
                    <select class="form-control" id="doctors-select">
                        <option>{{ __('patients.chooseDoctor') }}</option>
                        @foreach ($patient->doctors as $doctor)
                        <option data-element="{{ $doctor->id }}">{{ $doctor->name }}</option>
                        @endforeach
                    </select>

                    @foreach ($patient->doctors as $doctor)
                    <div class="row">
                        <div class="col-md-6 margin-top-30 date-div display-none" id="{{ $doctor->id }}">
                            <div class="form-group">
                                <div class="input-group input-medium date date-picker" data-doctor-id="{{ $doctor->id }}"
                                    data-date-format="yyyy-mm-dd" data-date-start-date="+0d"
                                    data-date-days-of-week-disabled="{{ $doctor->getDisabledDaysForDatePicker() }}">
                                    <input type="text" class="form-control" id="{{ 'date-input-'.$doctor->id }}" name=""
                                        placeholder="{{ __('reservations.chooseDate') }}" autocomplete="off">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-md-6">
                    <div id="avTimes-div" class="row display-none">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h2 class="panel-title">{{ __('reservations.availableTimes') }}</h2>
                            </div>
                            <div class="panel-body">
                                <form action="{{ route('reservation.store') }}" method="POST">
                                    @csrf
                                    <div id="avTimes-form">
                                        
                                    </div>
                                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                                    <button class="form-controm btn btn-primary">{{ __('reservations.reserve') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="loader" class="col-md-4 display-none">
            <img src="{{ asset('assets/images/ajax-loader.gif') }}" class="img-fluid" style="margin-right: 50%;">
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
<script>
    $(document).ready(function() {
        $('#doctors-select').change(function() {
            $('.date-div').addClass('display-none');
            var id = $('#doctors-select option:selected').data('element');
            $('#'+id).removeClass('display-none');
            $("#avTimes-div").hide();
        });

        // To show the loader.
        $(document).ajaxStart(function(){
            $("#loader").show();
        });
        $(document).ajaxComplete(function(){
            $("#loader").hide();
        });

        $('.date-picker').on('changeDate', function(e) {
            $("#avTimes-div").hide();
            $('#avTimes-form').empty();
            var id = $('#doctors-select option:selected').data('element');
            $.ajax({
                url: "{{ route('reservation.getDoctorTimes') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    day_number: e.date.getDay(),
                    doctor_id: e.target.getAttribute('data-doctor-id'),
                    date: $('#date-input-'+id).val(),
                },
                type: "POST",
                success: function (response) {
                    // console.log(response);
                    if (!response.status) {
                        $('#warning-msg').empty();
                        $('#warning-msg').append(response.msg);
                        $("#alert-div").show();
                    }else{
                        $('#warning-msg').empty();
                        $("#alert-div").hide();

                        var timesByClinics = response.content;
                        for (var clinic in timesByClinics) {
                            if (timesByClinics.hasOwnProperty(clinic)) {
                                var times = timesByClinics[clinic].times;
                                var clinic_id = timesByClinics[clinic].id;
                                var labels = '';
                                times.forEach(function(time) {
                                    labels += 
                                    '<label class="radio-inline time-radio">\
                                        <input type="radio" name="reservation_time" value="'+ clinic_id + '|' + time + '">'
                                        +time+
                                    '</label>';
                                });
                                var html =
                                '<div class="form-group">\
                                    <h4>'+ clinic +'</h4>'
                                    + labels +
                                '</div>\
                                <input type="hidden" name="doctor_id" value="'+ e.target.getAttribute('data-doctor-id') +'" />\
                                <input type="hidden" name="date" value="'+ e.date.toDateString() +'" />';

                                $('#avTimes-form').append(html);
                                $("#avTimes-div").show();
                            }
                        }
                    }
                }
            })
        });

    });
</script>
@endsection

@section('extra-js')
@endsection