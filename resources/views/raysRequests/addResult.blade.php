@extends('layouts.app')

@section('title', __('raysRequests.title'))

@section('extra-css')
@endsection

@section('bar-title', __('raysRequests.title'))
@section('page-title', __('raysRequests.addResult'))
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <form action="{{ route('raysRequest.storeResult', $item->id) }}" method="POST" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="row form-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label font-size-15">{{ __('raysRequests.uploadFile') }}</label>
                            <input type="file" name="file" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn green">{{ __('profile.submit') }}</button>
                </div>

            </form>
            <!-- END FORM-->
        </div>
    </div>
</div>
@endsection

@section('extra-js')
@endsection