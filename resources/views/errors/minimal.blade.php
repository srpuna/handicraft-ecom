@extends('errors::layout')

@section('title', __('Error'))

@section('message')
    <div style="font-size: 72px; font-weight: bold; margin-bottom: 20px;">
        @yield('code')
    </div>
    <div style="font-size: 24px;">
        @hasSection('message')
            @yield('message')
        @else
            An error occurred
        @endif
    </div>
@endsection
