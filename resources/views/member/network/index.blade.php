@extends('admin.layout')

@section('page_header')
Network
@endsection
@section('page_title')
<div class="page-header">
    <h1 class="page-title">Network</h1>
</div>
@endsection

@section('content')

<div class="col-lg-12">
    <div class="panel">
        <div class="panel-body container-fluid">
            <div class="table-reponsive">
                <table id="dataTable" class="table table-hover dataTable table-striped w-full" style="width:100%">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Status</th>
                            <th>Level</th>
                            <th>Commission</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    window.url = "{!! url('res/network') !!}";
</script>
<script src="{{asset('assets/js/jquery.mask.min.js')}}"></script>
<script src="{{asset('assets/js/config.js')}}"></script>
<script src="{{asset('assets/js/network.js')}}"></script>
@endpush        