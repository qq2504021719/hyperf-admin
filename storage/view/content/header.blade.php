<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class=" float-left">
                    <span class="text-capitalize">{{$title}}</span>
                    <small style="color: #777;">{{$subTitle}}</small>
                </h3>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @if(count($breadcrumb))
                        @foreach($breadcrumb as $v)
                            <li class="breadcrumb-item {{$v['active']}}">
                                @if($v['active'])
                                    {{$v['name']}}
                                @else
                                    <a href="javascript:void(0)" onclick="viewFaRe('/{{$config["prefix"]}}{{$v["path"]}}')" >{{$v['name']}}</a>
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->