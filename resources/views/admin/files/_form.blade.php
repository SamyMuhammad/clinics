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
        @if (request()->routeIs('admin.patient.files.create'))
        <div class="form-group">
            <label class="control-label">الملف</label>
            <input type="file" name="file" class="form-control">
        </div>
        @endif

        <div class="form-group">
            <label class="control-label">الوصف</label>
            <input type="text" name="description" value="{{ isset($item) ? $item->description : old('description') }}" class="form-control"
                placeholder="ادخل الوصف">
        </div>

        <div class="form-group">
            <label class="control-label">النوع</label>
            <select name="type" placeholder="اختر النوع" class="form-control">
                <option value="file" {{ isset($item) && $item->type == 'file' ? 'selected' : '' }}>بيانات</option>
                <option value="rays" {{ isset($item) && $item->type == 'rays' ? 'selected' : '' }}>آشعة</option>
                <option value="test" {{ isset($item) && $item->type == 'test' ? 'selected' : '' }}>تحاليل</option>
            </select>
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