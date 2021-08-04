@section('page-style-plugins')
<link href="{{ custom_asset('metronic/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ custom_asset('metronic/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

<div class="row form-body">
    <div class="col-sm-12">
        <div class="form-group col-sm-6">
            <label class="control-label">{{ __('patients.code') }}</label>
            <input type="text" name="code" value="{{ isset($item) ? $item->code : old('code') }}" class="form-control"
                placeholder="{{ __('patients.code') }}">
        </div>
        <div class="form-group col-sm-6">
            <label class="control-label">{{ __('patients.ar_name') }}</label>
            <input type="text" name="ar_name" value="{{ isset($item) ? $item->ar_name : old('ar_name') }}" class="form-control"
                placeholder="{{ __('patients.ar_name') }}">
        </div>
        <div class="form-group col-sm-6">
            <label class="control-label">{{ __('patients.en_name') }}</label>
            <input type="text" name="en_name" value="{{ isset($item) ? $item->en_name : old('en_name') }}" class="form-control"
                placeholder="{{ __('patients.en_name') }}">
        </div>
        <div class="form-group col-sm-6">
            <label class="control-label">{{ __('patients.phone') }}</label>
            <input type="text" name="phone" value="{{ isset($item) ? $item->phone : old('phone') }}" class="form-control"
                placeholder="{{ __('patients.phone') }}">
        </div>
        <div class="form-group col-sm-6">
            <label class="control-label">{{ __('patients.national_id') }}</label>
            <input type="text" name="national_id" value="{{ isset($item) ? $item->national_id : old('national_id') }}" class="form-control"
                placeholder="{{ __('patients.national_id') }}">
        </div>
        <div class="form-group col-sm-6">
            <label class="control-label">{{ __('patients.nationality') }}</label>
            <input type="text" name="nationality" value="{{ isset($item) ? $item->nationality : old('nationality') }}" class="form-control"
                placeholder="{{ __('patients.nationality') }}">
        </div>
        <div class="form-group col-sm-6">
            <label class="control-label">{{ __('patients.age') }}</label>
            <input type="number" min="1" max="255" name="age" value="{{ isset($item) ? $item->age : old('age') }}" class="form-control"
                placeholder="{{ __('patients.age') }}">
        </div>
        <div class="form-group col-sm-6">
            <label class="control-label">{{ __('patients.address') }}</label>
            <input type="text" name="address" value="{{ isset($item) ? $item->address : old('address') }}" class="form-control"
                placeholder="{{ __('patients.address') }}">
        </div>
        <div class="form-group col-sm-6">
            <label class="control-label">{{ __('patients.gender.title') }}</label>
            <select name="gender" class="form-control">
                <option value="male">{{ __('patients.gender.male') }}</option>
                <option value="female" {{ isset($item) && $item->gender == 'female' ? 'selected' : '' }}>{{ __('patients.gender.female') }}</option>
            </select>
        </div>
        <div class="form-group col-sm-6">
            <label class="control-label">{{ __('patients.social_status.title') }}</label>
            <select name="social_status" class="form-control">
                <option value="single">{{ __('patients.social_status.single') }}</option>
                <option value="married" {{ isset($item) && $item->social_status == 'married' ? 'selected' : '' }}>{{ __('patients.social_status.married') }}</option>
            </select>
        </div>
        <div class="form-group col-sm-6">
            <label class="control-label">{{ __('patients.type.title') }}</label>
            <select name="type" class="form-control">
                <option value="citizen">{{ __('patients.type.citizen') }}</option>
                <option value="resident" {{ isset($item) && $item->type == 'resident' ? 'selected' : '' }}>{{ __('patients.type.resident') }}</option>
                <option value="visitor" {{ isset($item) && $item->type == 'visitor' ? 'selected' : '' }}>{{ __('patients.type.visitor') }}</option>
            </select>
        </div>
        <div class="form-group col-sm-6">
            <label class="control-label">{{ __('patients.payment_method.title') }}</label>
            <select id="payment-method" name="payment_method" class="form-control">
                <option value="cash">{{ __('patients.payment_method.cash') }}</option>
                <option value="cash_with_discount" {{ isset($item) && $item->payment_method == 'cash_with_discount' ? 'selected' : '' }}>{{ __('patients.payment_method.cash_with_discount') }}</option>
                <option value="insurance_company" {{ isset($item) && $item->payment_method == 'insurance_company' ? 'selected' : '' }}>{{ __('patients.payment_method.insurance_company') }}</option>
                <option value="family" {{ isset($item) && $item->payment_method == 'family' ? 'selected' : '' }}>
                    {{ __('patients.payment_method.family') }}
                </option>
            </select>
        </div>
        <div id="company-div" class="form-group col-sm-6 display-none">
            <label class="control-label">{{ __('patients.insuranceCompany') }}</label>
            <select name="company_id" class="form-control select2" data-placeholder="{{ __('patients.chooseCompany') }}">
                <option value="">{{ __('patients.chooseCompany') }}</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}"
                    {{ isset($item) && $item->company_id == $company->id ? 'selected' : '' }}>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div id="discount-div" class="form-group col-sm-6 display-none">
            <label class="control-label">{{ __('discounts.discount') }}</label>
            <select name="discount_id" class="form-control select2" data-placeholder="{{ __('patients.chooseDiscount') }}">
                <option value="">{{ __('patients.chooseDiscount') }}</option>
                @foreach($discounts as $discount)
                    <option value="{{ $discount->id }}"
                    {{ isset($item) && $item->discount_id == $discount->id ? 'selected' : '' }}>
                        <bdi>{{ $discount->name . ' ' . $discount->renderedAmount }}</bdi>
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group col-sm-6">
            <label class="control-label">{{ __('patients.chooseDoctor') }}</label>
            <select name="doctors[]" class="form-control select2" multiple data-placeholder="{{ __('patients.chooseDoctor') }}">
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ (isset($item) && $item->doctors->contains($doctor->id)) || (is_array(old('doctors')) && in_array($doctor->id, old('doctors'))) ? 'selected' : '' }}>{{ $doctor->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-sm-6">
            <label class="control-label">{{ __('patients.room') }}</label>
            <select name="room_id" class="form-control select2" data-placeholder="{{ __('patients.chooseRoom') }}">
                <option value="">{{ __('patients.chooseRoom') }}</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}"
                    {{ (isset($item) && $item->room_id == $room->id) || old('room_id') == $room->id ? 'selected' : '' }}>
                        {{ __('rooms.floor') . ' ' . $room->floor_number . ' ' . __('rooms.room') . ' ' . $room->room_number }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-sm-6">
            <label class="control-label">{{ __('patients.files') }}</label>
            <input class="form-control" type="file" name="files[]" multiple>
        </div>
        @if (request()->routeIs('patient.edit') || request()->routeIs('admin.patient.edit'))
        <div class="form-group col-sm-6">
            <label class="control-label">{{ __('patients.status.title') }}</label>
            <select name="status" class="form-control">
                <option value="closed">{{ __('patients.status.closed') }}</option>
                <option value="blocked" {{ isset($item) && $item->status == 'blocked' ? 'selected' : '' }}>{{ __('patients.status.blocked') }}</option>
                <option value="opened" {{ isset($item) && $item->status == 'opened' ? 'selected' : '' }}>{{ __('patients.status.opened') }}</option>
            </select>
        </div>
        @endif

        <div class="form-group col-sm-6 margin-top-10">
            <div class="md-checkbox">
                <input type="checkbox" name="is_emergency" id="is-emergency-chk" value="1" class="md-check" {{ (isset($item) && $item->is_emergency) || old('is_emergency') ? 'checked' : '' }}>
                <label for="is-emergency-chk">
                    <span class="inc"></span>
                    <span class="check"></span>
                    <span class="box"></span> مريض طوارئ؟
                </label>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <button type="submit" class="btn green">حفظ</button>
</div>

@section('page-script-plugins')
<script src="{{ custom_asset('metronic/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
@endsection
@section('page-level-scripts')
<script src="{{ custom_asset('metronic/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
@endsection
@section('extra-js')
    <script>
        $(document).ready(function (){
            @if(isset($item))
            showExtraField()
            @endif

            $('#payment-method').on('change', showExtraField);

            function showExtraField() {
                switch ($('#payment-method').val()) {
                    case 'insurance_company':
                        $('#discount-div').hide();
                        $('select[name="discount_id"]').val(null);
                        $('#company-div').show();
                        break;
                    
                    case 'cash_with_discount':
                        $('#company-div').hide();
                        $('select[name="company_id"]').val(null);
                        $('#discount-div').show();
                        break;
                    
                    default:
                        $('#company-div').hide();
                        $('select[name="company_id"]').val(null);

                        $('#discount-div').hide();
                        $('select[name="discount_id"]').val(null);
                        break;
                }
            }
        });
    </script>
@endsection
