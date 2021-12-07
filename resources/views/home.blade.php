@extends('admin.layout')

@section('page_header')
Home
@endsection

@section('page_title')

@endsection

@section('content')
    @if(auth()->user()->is_active)
        @include('member.conversions.modal.request')
    @endif    

    <div class="col-lg-12">
        <div class="nav-tabs-horizontal" data-plugin="tabs">
            <ul class="nav nav-tabs nav-tabs-line" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link active show" data-action="Cash-in" data-toggle="tab" href="#exampleTabsLineOne" aria-controls="exampleTabsLineOne" role="tab" aria-selected="false">Products</a></li>
                @if(auth()->user()->is_active)
                <li class="nav-item" role="presentation"><a class="nav-link" data-action="Cash-out" data-toggle="{{auth()->user()->is_active ? 'tab' : ''}}" href="{{auth()->user()->is_active ? '#exampleTabsLineTwo' : 'javascript:void(0)'}}" aria-controls="exampleTabsLineTwo" role="tab" aria-selected="true">Diamond Conversion</a></li>
                @endif
                <li class="dropdown nav-item" role="presentation" style="display: none;">
                <a class="dropdown-toggle nav-link" data-toggle="dropdown" href="#" aria-expanded="false">Dropdown </a>
                <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" data-toggle="tab" data-action="Cash-in" href="#exampleTabsLineOne" aria-controls="exampleTabsLineOne" role="tab">Products</a>
                    @if(auth()->user()->is_active)
                    <a class="dropdown-item" data-toggle="{{auth()->user()->is_active ? 'tab' : ''}}" href="{{auth()->user()->is_active ? '#exampleTabsLineTwo' : 'javascript:void(0)'}}" aria-controls="exampleTabsLineTwo" role="tab">Diamond Conversion</a>
                    @endif
                </div>
                </li>
            </ul>
            <div class="tab-content pt-20">
                <div class="tab-pane active show" id="exampleTabsLineOne" role="tabpanel">
                    <div class="row">
                        @include('content.products')   
                    </div>
                </div>

                <div class="tab-pane" id="exampleTabsLineTwo" role="tabpanel">
                    <div class="row">
                        @if(auth()->user()->is_active)
                            @include('content.conversion-items')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/payment.js')}}"></script>
<script src="{{asset('assets/js/diamond-conversion.js')}}"></script>
@endpush        