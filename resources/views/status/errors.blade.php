@extends('status._layouts.app')

@section('container')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Errors</h1>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <!-- Collapsable Card Example -->
                @foreach($logs as $key => $log)
                <div class="card shadow mb-4">
                    <!-- Card Header - Accordion -->
                    <a href="#collapseCardExample{{$key}}" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample{{$key}}">
                        <h6 class="m-0 font-weight-bold text-primary">{{$log->created_at ?? "0000-00-00 00:00:00"}} [{{$log->path->path ?? ""}}]</h6>
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse show" id="collapseCardExample{{$key}}">
                        <div class="card-body">
                            {{$log->error->message ?? "No Message"}}
                        </div>
                    </div>
                </div>

                @endforeach
                {{$logs->links()}}
            </div>
        </div>


    </div>
    <!-- /.container-fluid -->
@endsection

@section('page-js')
    <!-- Page level plugins -->
    <script src="/status_assets/vendor/chart.js/Chart.min.js"></script>
    <!-- Page level custom scripts -->
    {{--<script src="/status_assets/js/demo/chart-area-demo.js"></script>--}}
    {{--<script src="/status_assets/js/demo/chart-pie-demo.js"></script>--}}
@endsection
