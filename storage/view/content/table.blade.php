
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        {{--搜索--}}
        <div class="row">
            <div class="col-md-12">
                {!! $searchHtml !!}

                    {{--表格数据--}}
                    <div class="card">
                    <div class="card-header">
                        {{--导出--}}
                        @if($isShow['export'])
                            {!! $excelHtml !!}
                        @endif
                        {{--添加按钮--}}
                        @if($isShow['isAdd'])
                            {!! $addHtml !!}
                        @endif
                        {{--头部html自定义--}}
                        @if($headerHtml)
                            {!! $headerHtml !!}
                        @endif
                    </div>
                    @if(count($rows))
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                {{--表头--}}
                                @foreach ($fields as $k=>$v)
                                    <th>{{$v?$v:$k}}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            {{--内容--}}
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
                    @else

                        <div align="center">
                            <i class="fa fa-inbox fa-5x" aria-hidden="true" style="color: rgba(0,0,0,.5)"></i>
                        </div>

                        {{--无数据--}}
                    @endif
                </div>

                @if(count($rows))
                    <div class="card">
                        <div class="card-body">
                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                    {{--分页数据--}}
                                    {!! $pageHtml->html !!}
                            </div>
                        </div>
                    <!-- /.card-body -->
                    </div>
                @endif
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->


<script>
    f_path = '';
</script>