<button type="button"  class="btn btn-{{$themeColor}}" onclick="hyperfAdminExcel()"><i class="fa fa-download" id="hyperfAdmin-loading" aria-hidden="true"></i> 导出</button>
<script>
var hyperfAdminExcel_url = "{{$excel_url}}";

/**
 * 导出请求
 * 没有数据的情况url等于空
 * {
    "code": 200,
    "msg": "成功",
    "data": {
    "url": "http://hyperf-admin.it/public/storage/download/excel/管理员信息0.xlsx",
    "count": 4,
    "msg": "",
    "count_page": 1
    }
    }
 <i class="fas fa-spinner fa-spin" aria-hidden="true"></i>
 */
function hyperfAdminExcel() {
    var key = 'hyperfAdmin-loading';
    loadingI(key,true);
    get(hyperfAdminExcel_url,function (data) {
        if(data.code == 200)
        {
            var url = data.data.url;
            if(url)
            {
                window.location = url;
                toastr.success('下载了'+data.data.count+'条数据');
            }
            else
            {
                toastr.info("数据为空");
            }
        }
        else
        {
            toastr.error(data.msg);
        }
        // 关闭加载loading
        loadingI(key,false);

    },function (data,status) {
        // 关闭加载loading
        loadingI(key,false);
    })
}


</script>