@section('page-style-plugins')
<link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
{{-- <link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" /> --}}
{{-- <link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" /> --}}
@endsection
@section('page-level-styles')
<link href="{{ custom_asset('metronic/assets/pages/css/profile-2-rtl.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

<div class="row form-body">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">رقم الغرفة</label>
            <input type="number" name="room_number" value="{{ isset($item) ? $item->room_number : old('room_number') }}" class="form-control"
                placeholder="ادخل رقم الغرفة">
        </div>

        <div class="form-group">
            <label class="control-label">رقم الطابق</label>
            <input type="number" name="floor_number" value="{{ isset($item) ? $item->floor_number : old('floor_number') }}" class="form-control"
                placeholder="ادخل رقم الطابق">
        </div>

        <div class="form-group">
            <label class="control-label">عدد الأسرة</label>
            <input type="number" name="beds_count" value="{{ isset($item) ? $item->beds_count : old('beds_count') }}" class="form-control"
                placeholder="ادخل عدد الأسرة">
        </div>

        {{-- <div class="form-group">
            <label class="control-label">عدد الأشخاص</label>
            <input type="number" name="residents_count" value="{{ isset($item) ? $item->residents_count : old('residents_count') }}" class="form-control"
                placeholder="ادخل عدد الأشخاص">
        </div> --}}

    </div>
</div>
<div class="form-actions">
    <button type="submit" class="btn green">حفظ</button>
</div>

@section('page-script-plugins')
<script src="{{ custom_asset('metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
{{-- <script src="{{ custom_asset('metronic/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script> --}}
{{-- <script src="{{ custom_asset('metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script> --}}
@endsection

@section('page-level-scripts')
{{-- <script src="{{ custom_asset('metronic/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script> --}}
@endsection