@extends('admin.layout')

@section('page_header')
Items
@endsection

@section('style')
<link rel="stylesheet" href="{{asset('app/classic/global/vendor/dropify/dropify.css')}}">
@endsection

@section('page_title')
<div class="page-header">
    <h1 class="page-title">{{!empty($item) ? 'Edit' : 'New'}} Item</h1>
</div>
@endsection

@section('content')
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body container-fluid">
                @include('layouts.alert')
                <form action="{{empty($item) ? url('res/diamond/conversion/items') : url('res/diamond/conversion/items/'.$item->id)}}" class="row" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (!empty($item))
                        {{ method_field('PUT') }}
                    @endif
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Name </label>
                            <input type="text" name="name" class="form-control" value="{{$item->name ?? old('name')}}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Price </label>
                            <input type="text" name="price" class="form-control" value="{{$item->price ?? old('price')}}">
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
                            <textarea name="mechanics" id="description--editor" class="form-control" cols="30" rows="10" placeholder="mechanics">
                                {{!empty($item->mechanics) ? $item->mechanics : old('mechanics')}}
                            </textarea>
                        </div>
                    </div>

                    <div class="col-md-12 text-right">
                        @if (!empty($item))
                            <button type="button" class="btn btn-danger btn--archive" data-form="#deleteItemForm">Archive</button>
                        @endif
                        
                        <button class="btn btn-info">Save</button>
                    </div>
                    
                </form>
                @if (!empty($item))
                    <form method="POST" action="{{url('res/diamond/conversion/items/'.$item->id)}}" id="deleteItemForm">
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
<script src="{{asset('assets/js/items.js')}}"></script>
@endpush 