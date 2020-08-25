<div class="col-lg-4">
    <div class="form-group">
        <label for="exampleInputEmail1">{{$label}}</label>
        <input type="hidden" id="select2-input-{{$name}}" name="{{$name}}" value="{{$data}}">
        <select class="form-control select2_ajax_{{$name}}" style="width: 100%;">
        </select>
    </div>
    <script>
        var {{$name}}key = '.select2_ajax_{{$name}}';
        var {{$name}}val = "{{$data}}";

        // 设置默认选择事件
        $({{$name}}key).val({{$name}}val).select2()
        //初始化Select2
        var flag = (typeof formatResult === "function") ? true : false;
        $({{$name}}key).select2({
            placeholder: {id: '', text: "{{$place}}"}, // 同上，这里默认空值为 ''
            allowClear:true, // 允许清除
            // 最少输入N个字符才开始检索，如果想在点击下拉框时加载数据，请设置为 0
            minimumInputLength: 0,
            ajax: {
                url: "{{$url}}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        // 模糊查询
                        q: params.term,
                        page:params.page || 1,
                        paginate:"{{$paginate}}"
                    };
                },
                // 全部加载
                // processResults: function (data) {
                //     return {
                //         results: data.data  //必须赋值给results并且必须返回一个obj，否则会报错；
                //     };
                // },
                cache: true,
                // 滚动分页加载数据
                processResults: function (res, params) {
                    params.page = params.page || 1;
                    var cbData = [];
                    if (flag) {
                        cbData = res.data;
                    } else {
                        var data = res.data;
                        var len = data.length;
                        for(var i= 0; i<len; i++){
                            var option = {"id": data[i]["id"], "text": data[i]["text"]};
                            cbData.push(option);
                        }
                    }
                    return {
                        results: cbData,
                        pagination: {
                            more: params.page < res.last_page
                        }
                    };
                },
            },

        })

        // 选中事件
        $({{$name}}key).on("select2:select", function(e) {
            var val = $({{$name}}key).select2("val");
            // 设置值
            $('#select2-input-{{$name}}').attr('value',val)
        });
    </script>
</div>