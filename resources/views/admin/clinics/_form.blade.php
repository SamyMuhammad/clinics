@section('page-style-plugins')
<link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-level-styles')
<link href="{{ custom_asset('metronic/assets/pages/css/profile-2-rtl.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

<div class="row form-body">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">الاسم باللغة العربية</label>
            <input type="text" name="ar_name" value="{{ isset($item) ? $item->ar_name : old('ar_name') }}" class="form-control"
                placeholder="ادخل الاسم بالعربية">
        </div>

        <div class="form-group">
            <label class="control-label">الاسم باللغة الإنجليزية</label>
            <input type="text" name="en_name" value="{{ isset($item) ? $item->en_name : old('en_name') }}" class="form-control"
                placeholder="ادخل الاسم بالإنجليزية">
        </div>
    </div>
    <div class="col-md-6" style="font-size: 17px;">
        <h3 style="margin-bottom: 20px;">تحديد أطباء هذه العيادة</h3>
        <div class="md-checkbox">
            <input type="checkbox" id="select_all" class="md-check" onclick="selectAll()">
            <label for="select_all">
                <span class="inc"></span>
                <span class="check"></span>
                <span class="box"></span>تحديد الكل
            </label>
        </div>
        <hr class="roles">
        <div class="md-checkbox">
            <div class="md-checkbox-inline">
                @foreach($doctors as $doctor)
                <div class="md-checkbox">
                    <input type="checkbox" name="doctors[]" id="checkbox{{ $doctor->name }}"
                        value="{{ $doctor->id }}" class="md-check permission-checkbox"
                        {{ isset($item) && $item->doctors->pluck('id')->contains($doctor->id) ? 'checked' :'' }}>
                    <label for="checkbox{{$doctor->name}}">
                        <span class="inc"></span>
                        <span class="check"></span>
                        <span class="box"></span> {{ $doctor->name }}
                        {{-- <a href="#modal{{ $loop->iteration }}" data-toggle="modal" title="تحديد أوقات العمل"><i class="fa fa-clock-o"></i></a> --}}
                    </label>
                </div>
                {{-- <div class="modal fade in" id="modal{{ $loop->iteration }}" tabindex="-1" role="basic" aria-hidden="true" style="display: none; padding-right: 17px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">تحديد أوقات عمل الطبيب {{ $doctor->name }}</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <h5>وقت البداية</h5>
                                    <div class="input-group col-md-4">
                                        <input type="text" class="form-control timepicker timepicker-no-seconds" name="{{ $doctor->id }}:shift_start_time" @if(isset($item)) value="{{ $doctor->clinics()->where('clinic_id', $item->id)->first()->pivot->shift_start_time ?? '' }}" @endif placeholder="{{ __('doctor.shift_start_time') }}"  autocomplete="off">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-clock-o"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h5>وقت النهاية</h5>
                                    <div class="input-group col-md-4">
                                        <input type="text" class="form-control timepicker timepicker-no-seconds" name="{{ $doctor->id }}:shift_end_time" @if(isset($item)) value="{{ $doctor->clinics()->where('clinic_id', $item->id)->first()->pivot->shift_end_time ?? '' }}" @endif placeholder="{{ __('doctor.shift_end_time') }}"  autocomplete="off">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-clock-o"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn dark btn-outline" data-dismiss="modal">حفظ</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div> --}}
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <button type="submit" class="btn green">حفظ</button>
</div>

@section('page-script-plugins')
<script src="{{ custom_asset('metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
<script src="{{ custom_asset('metronic/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ custom_asset('metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-level-scripts')
<script src="{{ custom_asset('metronic/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
@endsection

@section('extra-js')
<script>
    function selectAll() {
        const select_all_element = $('#select_all');
        if (select_all_element.is(":checked")) {
            $('.permission-checkbox').prop('checked', true);
        }else{
            $('.permission-checkbox').removeAttr('checked');
        }
        return void(0);
    }

    $('.permission-checkbox').change(function(){
        //uncheck "select all", if one of the listed checkbox item is unchecked
        var parent=$(this).data('parent');
        if(false == $(this).prop("checked")){ //if this item is unchecked

            $('.select_role[data-parent="'+parent+'"]').prop('checked', false); //change "select all" checked status to false

            $("#select_all").prop('checked', false); //change "select all" checked status to false
        }

        if ($('.permission-checkbox[data-parent="'+parent+'"]:checked').length == $('.permission-checkbox[data-parent="'+parent+'"]').length ){

            $('.select_role[data-parent="'+parent+'"]').prop('checked', true);
            if ($('.md-check:checked').length == $('.md-check').length ){
                $("#select_all").prop('checked', true);
            }
        }
    });
</script>
@endsection