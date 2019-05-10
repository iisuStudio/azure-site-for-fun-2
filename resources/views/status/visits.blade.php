@extends('status._layouts.app')

@section('container')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Visits</h1>
        {{--<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official DataTables documentation</a>.</p>--}}

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>IP address</th>
                            <th>Country / City</th>
                            <th>User</th>
                            <th>Device</th>
                            <th>Browser</th>
                            <th>Referer</th>
                            <th>Page Views</th>
                            <th>Last activity</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($field as $row)
                            <tr>
                                <td>{{$row->id ?? ""}}</td>
                                <td>{{$row->client_ip ?? ""}}</td>
                                <td>{{$row->geo_ip->country_name ?? ""}} / {{$row->geo_ip->city ?? ""}}</td>
                                <td>{{$row->user->name ?? ""}}</td>
                                <td>{{$row->device->kind ?? ""}} [{{$row->device->model ?? ""}}] [{{$row->device->platform ?? ""}}]</td>
                                <td>{{$row->agent->browser ?? ""}} ({{$row->agent->browser_version ?? ""}})</td>
                                <td>{{$row->referer->host ?? ""}}</td>
                                <td>{{count($row->log) ?? ""}}</td>
                                <td>{{$row->updated_at ?? ""}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

@section('page-js')
    <!-- Page level plugins -->
    <script src="/status_assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="/status_assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="/status_assets/js/demo/datatables-demo.js"></script>
@endsection