<div class="row form-body">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">الاسم</label>
            <input type="text" name="name" value="{{ isset($user) ? $user->name : old('name') }}" class="form-control"
                placeholder="ادخل الاسم">
        </div>
        <div class="form-group">
            <label class="control-label">الهاتف</label>
            <div class="input-icon">
                <i class="fa fa-phone"></i>
                <input type="text" name="phone" value="{{ isset($user) ? $user->phone : old('phone') }}"
                    class="form-control" placeholder="ادخل الهاتف">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">البريد الإلكتروني</label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-envelope"></i>
                </span>
                <input type="email" name="email" value="{{ isset($user) ? $user->email : old('email') }}"
                    class="form-control" placeholder="البريد الإلكتروني"> </div>
        </div>
        <div class="form-group">
            <label class="control-label">كلمة المرور</label>
            <div class="input-group">
                <input type="password" name="password" class="form-control" placeholder="كلمة المرور">
                <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                </span>
            </div>
            @if (request()->routeIs('admin.user.edit'))
            <span class="help-block">اتركه فارغاً في حالة عدم الرغبة في تغيير كلمة المرور.</span>
            @endif
        </div>
        <div class="form-group">
            <label class="control-label">أعد إدخال كلمة المرور</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="كلمة المرور">
        </div>

        <div class="form-group">
            <label class="control-label">الوظيفة</label>
            <select name="job" class="form-control select2">
                @foreach ($jobs as $item)
                    <option value="{{ $item }}" {{ (isset($user) && $user->job === $item ) ? 'selected' : '' }}>{{ __('users.job.'.$item) }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="control-label">العنوان</label>
            <div class="input-icon">
                <i class="fa fa-home"></i>
                <input type="text" name="address" value="{{ isset($user) ? $user->address : old('address') }}"
                    class="form-control" placeholder="ادخل العنوان">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">الراتب</label>
            <div class="input-icon">
                <i class="fa fa-money"></i>
                <input type="number" name="salary" value="{{ isset($user) ? $user->salary : old('salary') }}" min="1" step="0.01"
                    class="form-control" placeholder="ادخل الراتب">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">مدة التعاقد</label>
            <div class="input-icon">
                <i class="fa fa-money"></i>
                <input type="text" name="contract_period" value="{{ isset($user) ? $user->contract_period : old('contract_period', '1 Year') }}"
                    class="form-control" placeholder="ادخل مدة التعاقد">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">الصورة الشخصية</label>
            @if (request()->routeIs('admin.user.edit'))
            <img src="{{ asset($user->fullPhotoPath) }}" class="form-photo" alt="{{ $user->name }}">
            @endif
            <input type="file" name="photo">
        </div>
    </div>
    <div class="col-md-6" style="font-size: 17px;">
        <h3 style="margin-bottom: 20px;">تحديد الأدوار والصلاحيات</h3>
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
                @foreach($roles as $role)
                <div class="md-checkbox">
                    <input type="checkbox" name="roles[]" id="checkbox{{ $role->name }}"
                        value="{{ $role->id }}" class="md-check permission-checkbox"
                        {{ isset($user) && $user->hasRole($role->id) ? 'checked' :'' }}>
                    <label for="checkbox{{$role->name}}">
                        <span class="inc"></span>
                        <span class="check"></span>
                        <span class="box"></span> {{ $role->ar_name }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <button type="submit" class="btn green submit-btn">حفظ</button>
</div>

@section('extra-js')
<script>
    submitButtonText();
    $('select[name="job"]').on('change', submitButtonText);

    function submitButtonText() {
        let select =  $('select[name="job"]');
        let submitButton = $('.submit-btn');

        if (select.val() == 'doctor'){
            submitButton.text('حفظ وإكمال بيانات الطبيب');
        }else{
            submitButton.text('حفظ');
        }
    }

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
