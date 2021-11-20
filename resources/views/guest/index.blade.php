@extends('guest.layout')

@section('content')
    <div class="space-y-0">
        @include('guest.sections.banner')
        @include('guest.sections.products')
        @include('guest.sections.join-us')
        @include('guest.footer')
    </div>
@endsection