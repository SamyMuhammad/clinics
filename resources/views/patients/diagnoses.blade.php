@extends(request()->routeIs('admin.patient.show') ? 'admin.layouts.app' : 'layouts.app')

@section('page-level-styles')
<link href="{{ custom_asset('metronic/assets/pages/css/invoice-rtl.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title', __('patients.patientDiagnoses').' '.$item->code)

@section('extra-css')
@endsection
@section('bar-title', __('patients.patients'))
@section('page-title', __('patients.patientDiagnoses').' '.$item->code)

@section('content')
<div class="container">
    @doctor
    {{-- Check if this patient associated with the authenticated doctor. --}}
    @if (auth()->user()->patients->pluck('id')->contains($item->id))
    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('patient.addDiagnose', $item->id) }}" method="POST" class="font-size-15">
                @method('PATCH')
                @csrf
                <div class="form-group">
                    <label class="control-label">{{ __('patients.addDiagnose') }}</label>
                    <textarea name="diagnose" class="form-control" cols="30" rows="10">{{ $diagnoses[auth()->user()->name] ?? '' }}</textarea>
                </div>
                <button class="btn btn-primary" type="submit">{{ __('datatables.submit') }}</button>
            </form>
        </div>
    </div>
    <hr>
    @endif

    <div class="font-size-15">
        @forelse ($diagnoses as $key => $value)
            <h4>{{ $key }}</h4>
            <p>{{ $value }}</p>
        @empty
        <p>{{ __('patients.noDiagnoses') }}</p>
        @endforelse
    </div>
    @enddoctor
</div>
@endsection

@section('extra-js')
@endsection