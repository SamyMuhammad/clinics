@if (session()->has('success'))
<div class="alert alert-success text-center">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <p>{{ session('success') }}</p>
</div>
@endif

@if (session()->has('warning'))
<div class="alert alert-warning text-center">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <p>{{ session('warning') }}</p>
</div>
@endif

@if (session()->has('error'))
<div class="alert alert-danger text-center">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <p>{{ session('error') }}</p>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger text-center">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <ul style="list-style-type: none;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif