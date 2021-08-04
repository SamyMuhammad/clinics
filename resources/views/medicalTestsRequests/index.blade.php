@extends(request()->routeIs('admin.*') ? 'admin.layouts.app' : 'layouts.app')

@section('title', __('medicalTestsRequests.title'))
@include('layouts._datatables_assets')

@section('extra-css')
@endsection
@section('bar-title', __('medicalTestsRequests.title'))
@section('page-title', __('medicalTestsRequests.title'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>{{ __('medicalTestsRequests.doctor') }}</th>
                            <th>{{ __('medicalTestsRequests.patient') }}</th>
                            <th>{{ __('medicalTestsRequests.medicalTestType') }}</th>
                            <th>{{ __('medicalTestsRequests.testsResponsible') }}</th>
                            <th>{{ __('medicalTestsRequests.file') }}</th>
                            <th class="text-center">{{ __('datatables.options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td class="iteration text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->doctor->name }}</td>
                            <td>{{ $item->patient->ar_name }}</td>
                            <td>{{ $item->medical_test->name }}</td>
                            <td>{{ optional($item->tests_responsible)->name }}</td>
                            <td><a href="{{ optional($item->file)->url() }}"
                                    target="_blank">{!! optional($item->file)->HTMLName !!}</a></td>
                            <td>
                                @if (! request()->routeIs('admin.*'))
                                    @testResponsible
                                    <a href="{{ route('testRequest.addResult', $item->id) }}"
                                        class="btn blue-sharp btn-outline sbold uppercase">{{ __('medicalTestsRequests.addResult') }}</a>
                                    @endtestResponsible
                                    @doctor
                                    @if (is_null($item->file_id))
                                    <form action="{{ route('doctor.testRequest.destroy', $item->id) }}" method="POST"
                                        class="destroy-form">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" onclick="deleteConfirmation()"
                                            class="btn red-mint btn-outline sbold uppercase">{{ __('datatables.delete') }}</button>
                                    </form>
                                    @endif
                                    @enddoctor
                                @else
                                    <form action="{{ route('admin.medical-test.request.destroy', $item->id) }}" method="POST"
                                        class="destroy-form">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" onclick="deleteConfirmation()"
                                            class="btn red-mint btn-outline sbold uppercase">{{ __('datatables.delete') }}</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
    <div class="col-md-12">{!! $items->render() !!}</div>
</div>
@endsection

@section('extra-js')
@endsection
