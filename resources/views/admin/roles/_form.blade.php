<div class="row form-body">
    <div class="col-md-12">
        <div class="form-group col-sm-6">
            <label class="control-label">اسم الدور باللغة العربية</label>
            <input type="text" name="ar_name" value="{{ isset($role) ? $role->ar_name : old('ar_name') }}" class="form-control"
                placeholder="ادخل الاسم باللغة العربية">
        </div>
        <div class="form-group col-sm-6">
            <label class="control-label">اسم الدور باللغة الإنجليزية</label>
            <input type="text" name="name" value="{{ isset($role) ? $role->name : old('name') }}" class="form-control"
                placeholder="ادخل الاسم باللغة الإنجليزية">
        </div>
        <input type="hidden" name="guard_name" value="{{ $guard }}">
        {{-- <div class="form-group">
            <label class="control-label">هذا الدور يتبع</label>
            <select name="guard_name" class="form-control">
                <option value="admin">أدوار المديرين</option>
                <option value="web" {{ isset($role) && $role->guard_name == 'web' ? 'selected' : ''}}>أدوار المستخدمين</option>
            </select>
        </div> --}}
    </div>
    <div class="col-md-12" style="font-size: 17px;">
        <h3 style="margin-bottom: 20px;">تحديد الصلاحيات</h3>
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
            {{-- @foreach($permissions as $permission) --}}
            {{-- <div> --}}
                {{-- <div class="md-checkbox">
                    <input type="checkbox" name="permissions[]" id="checkbox{{$permission->name}}"
                        value="{{ $permission->id }}" class="md-check select_role permission-checkbox" data-parent="{{ $permission->name }}"
                        {{ isset($role) && $role->hasPermmissionTo($permission->id) ? 'checked' :'' }}>
                    <label for="checkbox{{$role->name}}" style="font-weight: 600">
                        <span class="inc"></span>
                        <span class="check"></span>
                        <span class="box"></span> {{ $permission->ar_name }}
                    </label>
                </div> --}}
                <div class="md-checkbox-inline">
                    @foreach($permissions as $permission)
                        <div class="md-checkbox">
                            <input type="checkbox" name="permissions[]" id="checkbox{{$permission->name}}"
                                value="{{ $permission->id }}" class="md-check permission-checkbox" {{-- data-parent="{{ $role->name }} --}}"
                            {{ isset($role) && $role->hasPermissionTo($permission->id) ? 'checked' :'' }}>
                            <label for="checkbox{{$permission->name}}">
                                <span class="inc"></span>
                                <span class="check"></span>
                                <span class="box"></span> {{ $permission->ar_name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            {{-- </div> --}}
            {{-- <hr class="roles"> --}}
            {{-- @endforeach --}}
        </div>
    </div>
</div>
<div class="form-actions">
    <button type="submit" class="btn green">حفظ</button>
</div>

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

    // Select permissions when select the associated role.
    // $(".select_role").change(function(){  //"select all" change
    //     var parent= $(this).data('parent');
    //     $('*[data-parent="'+parent+'"]').prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
    // });

    //".checkbox" change
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