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
            <label class="control-label">الاسم باللغة العربية</label>
            <input type="text" name="ar_name" value="{{ isset($item) ? $item->ar_name : old('ar_name') }}" class="form-control"
                placeholder="ادخل الاسم بالعربية">
        </div>

        <div class="form-group">
            <label class="control-label">الاسم باللغة الإنجليزية</label>
            <input type="text" name="en_name" value="{{ isset($item) ? $item->en_name : old('en_name') }}" class="form-control"
                placeholder="ادخل الاسم بالإنجليزية">
        </div>

        <div class="form-group">
            <label class="control-label">الهاتف</label>
            <input type="text" name="phone" value="{{ isset($item) ? $item->phone : old('phone') }}" class="form-control"
                placeholder="ادخل الهاتف">
        </div>

        <div class="form-group">
            <label class="control-label">البريد الإلكتروني</label>
            <input type="email" name="email" value="{{ isset($item) ? $item->email : old('email') }}" class="form-control"
                placeholder="ادخل البريد الإلكتروني">
        </div>

        <div class="form-group">
            <label class="control-label">المدينة</label>
            <input type="text" name="city" value="{{ isset($item) ? $item->city : old('city') }}" class="form-control"
                placeholder="ادخل المدينة">
        </div>

        <div class="form-group">
            <label class="control-label">العنوان</label>
            <input type="text" name="address" value="{{ isset($item) ? $item->address : old('address') }}" class="form-control"
                placeholder="ادخل العنوان">
        </div>
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