@extends('guest.layout')

@section('content')
    <div class="space-y-0">
        @include('guest.sections.banner')
        @include('guest.sections.about-us')
        @include('guest.sections.testimonial')
        @include('guest.sections.products')
        @include('guest.sections.join-us')
        @include('guest.sections.charity')
        @include('guest.footer')
    </div>
@endsection