
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if(count($rows))
                    {{--表格数据--}}
                    <div class="card">
                    {{--<div class="card-header">--}}
                        {{--<h3 class="card-title">Responsive Hover Table</h3>--}}
                        {{--<div class="card-tools">--}}
                            {{--<div class="input-group input-group-sm" style="width: 150px;">--}}
                                {{--<input type="text" name="table_search" class="form-control float-right" placeholder="Search">--}}

                                {{--<div class="input-group-append">--}}
                                    {{--<button type="submit" class="btn btn-default">--}}
                                        {{--<i class="fas fa-search"></i>--}}
                                    {{--</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                @foreach ($fields as $k=>$v)
                                    <th>{{$v?$v:$k}}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($rows as $row)
                                <tr>
                                    @foreach($row->html as $html)
                                        {!! $html !!}
                                    @endforeach
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                    {{--无数据--}}
                @endif
                <div class="card">
                    {{--<div class="card-header">--}}
                        {{--<h3 class="card-title">DataTable with minimal features &amp; hover style</h3>--}}
                    {{--</div>--}}
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            @if(count($rows))
                                {{--表格数据--}}
                                {{--分页数据--}}
                                {!! $pageHtml->html !!}
                            @endif
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- DataTables start -->
{{--<script src="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/datatables/jquery.dataTables.min.js"></script>--}}
{{--<script src="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>--}}
{{--<script src="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>--}}
{{--<script src="{{config('hyperf-admin.app_host')}}/public/vendor/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>--}}
<!-- DataTables end -->
<!-- page script -->
<script>
    // $(function () {
        // $("#example1").DataTable({
        //     "responsive": true,
        //     "autoWidth": false,
        // });
        // $('#example2').DataTable({
        //     "paging": true,
        //     "lengthChange": false,
        //     "searching": false,
        //     "ordering": true,
        //     "info": true,
        //     "autoWidth": false,
        //     "responsive": true,
        // });
    // });
</script>