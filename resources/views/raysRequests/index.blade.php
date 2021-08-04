@extends(request()->routeIs('admin.*') ? 'admin.layouts.app' : 'layouts.app')

@section('title', __('raysRequests.title'))
@include('layouts._datatables_assets')

@section('extra-css')
@endsection
@section('bar-title', __('raysRequests.title'))
@section('page-title', __('raysRequests.title'))

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
                            <th>{{ __('raysRequests.doctor') }}</th>
                            <th>{{ __('raysRequests.patient') }}</th>
                            <th>{{ __('raysRequests.rayType') }}</th>
                            <th>{{ __('raysRequests.technician') }}</th>
                            <th>{{ __('raysRequests.file') }}</th>
                            <th class="text-center">{{ __('datatables.options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td class="iteration text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->doctor->name }}</td>
                            <td>{{ $item->patient->ar_name }}</td>
                            <td>{{ $item->ray_type->name }}</td>
                            <td>{{ optional($item->technician)->name }}</td>
                            <td><a href="{{ optional($item->file)->url() }}"
                                    target="_blank">{!! optional($item->file)->HTMLName !!}</a></td>
                            <td>
                                @if (! request()->routeIs('admin.*'))
                                    @technician
                                    <a href="{{ route('raysRequest.addResult', $item->id) }}"
                                        class="btn blue-sharp btn-outline sbold uppercase">{{ __('raysRequests.addResult') }}</a>
                                    @endtechnician
                                    @doctor
                                    @if (is_null($item->file_id))
                                    <form action="{{ route('doctor.raysRequests.destroy', $item->id) }}" method="POST"
                                        class="destroy-form">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" onclick="deleteConfirmation()"
                                            class="btn red-mint btn-outline sbold uppercase">{{ __('datatables.delete') }}</button>
                                    </form>
                                    @endif
                                    @enddoctor
                                @else
                                    <form action="{{ route('admin.rays-requests.destroy', $item->id) }}" method="POST"
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
