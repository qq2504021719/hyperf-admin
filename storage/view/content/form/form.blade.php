<!-- Main content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card card-{{$themeColor}}">
                    <div class="card-header">
                        <h3 class="card-title">编辑</h3>
                    </div>
                    <form method="get" action="{{$action}}">
                        <input type="hidden" name="id" value="{{$id}}">
                        <div class="card-body">
                            {!! $html !!}
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-{{$themeColor}} float-right">提交</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
<script>
f_path = '{{$f_path}}';
</script>


