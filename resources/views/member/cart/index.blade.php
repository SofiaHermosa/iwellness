@extends('admin.layout')

@section('page_header')
Cart
@endsection

@section('page_title')

@endsection

@section('content')
    @include('content.cart')          
@endsection

@push('scripts')
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/cart.js')}}"></script>
@endpush        