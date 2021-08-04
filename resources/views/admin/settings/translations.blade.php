@extends('admin.layouts.app')
@section('title', "الترجمة")

@section('extra-css')
<style>
    h1.page-title{
        display: none;
    }
</style>
@endsection

@section('bar-title', 'الترجمة')

@section('content')
    <iframe src="{{ url('translations') }}" width="100%" frameborder="0" scrolling="no" onload="resizeIframe(this)"></iframe>
@endsection

@section('extra-js')
    <script>
        function resizeIframe(obj) {
            obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
        }
    </script>
@endsection