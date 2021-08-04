<div class="row form-body">
    <div class="col-md-6">
        <div class="form-group">
            <label class="control-label">التخصص</label>
            <input type="text" name="specialization" value="{{ isset($item) ? optional($item->data)->specialization : old('specialization') }}" class="form-control"
                placeholder="ادخل التخصص">
        </div>
    </div>
</div>
<div class="form-actions">
    <button type="submit" class="btn green">حفظ</button>
</div>

@section('extra-js')
@endsection