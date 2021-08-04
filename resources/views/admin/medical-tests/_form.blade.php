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
</div>
<div class="form-actions">
    <button type="submit" class="btn green">حفظ</button>
</div>