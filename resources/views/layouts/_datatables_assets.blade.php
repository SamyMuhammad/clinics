@section('page-style-plugins')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="{{ custom_asset('metronic/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ custom_asset('metronic/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ custom_asset('metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ custom_asset('metronic/assets/global/plugins/icheck/skins/all.css') }}" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('page-level-styles')
@endsection
@section('theme-layout-styles')
@endsection

{{-- Scripts --}}
@section('page-script-plugins')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ custom_asset('metronic/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ custom_asset('metronic/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ custom_asset('metronic/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ custom_asset('metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ custom_asset('metronic/assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('page-level-scripts')
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ custom_asset('metronic/assets/pages/scripts/table-datatables-buttons.min.js') }}" type="text/javascript"></script>
{{-- <script src="{{ custom_asset('metronic/assets/pages/scripts/table-datatables-responsive.min.js') }}" type="text/javascript"></script> --}}
<script src="{{ custom_asset('metronic/assets/pages/scripts/form-icheck.min.js') }}" type="text/javascript"></script>

<script>
    function deleteConfirmation(){
        if (!confirm('{{ __('datatables.deleteConfirmation') }}')) {
            event.preventDefault();
        }
    }
</script>
<!-- END PAGE LEVEL SCRIPTS -->
@endsection