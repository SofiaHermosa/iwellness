@extends('admin.layout')

@section('page_header')
Products
@endsection

@section('style')
<link rel="stylesheet" href="{{asset('app/classic/global/vendor/dropify/dropify.css')}}">
@endsection

@section('page_title')
<div class="page-header">
    <h1 class="page-title">{{!empty($product) ? 'Edit' : 'New'}} Product</h1>
</div>
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body container-fluid">
                @include('layouts.alert')
                <form action="{{empty($product) ? url('res/products') : url('res/products/'.$product->id)}}" class="row" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (!empty($product))
                        {{ method_field('PUT') }}
                    @endif
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Name </label>
                            <input type="text" name="name" class="form-control" value="{{$product->name ?? old('name')}}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Price </label>
                            <input type="text" name="price" class="form-control" value="{{$product->price ?? old('price')}}">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label> Images </label>

                            <input data-plugin="dropify" type="file" name="image[]" class="form-control" accept="image/gif, image/jpeg, image/png" multiple>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Description </label>
                            <textarea name="description" id="description--editor" class="form-control" cols="30" rows="10" placeholder="description">
                                {{!empty($product->description) ? base64_decode($product->description) : old('description')}}
                            </textarea>
                        </div>
                    </div>

                    <div class="col-md-12 text-right">
                        @if (!empty($product))
                            <button type="button" class="btn btn-danger btn--archive" data-form="#deleteProdForm">Archive</button>
                        @endif
                        
                        <button class="btn btn-info">Save</button>
                    </div>
                    
                </form>
                @if (!empty($product))
                    <form method="POST" action="{{url('res/products/'.$product->id)}}" id="deleteProdForm">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{asset('app/classic/global/vendor/dropify/dropify.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/products.js')}}"></script>
@endpush 