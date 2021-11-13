@extends('admin.layout')

@section('page_title')
<div class="page-header">
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-title">Users</h1>
        </div>
        <div class="col-md-4">
            <a href="{{url('res/users/create')}}" class="btn btn-tagged social-linkedin float-right">
                <span class="btn-tag"><i class="icon md-plus" aria-hidden="true"></i></span>
                New User
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="col-lg-12">
    <div class="panel">
        <div class="panel-body container-fluid">
            @include('admin.users.table.users')
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    window.url = "{!! url('res/users') !!}";
</script>
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/config.js')}}"></script>
<script src="{{asset('assets/js/users.js')}}"></script>
@endpush        