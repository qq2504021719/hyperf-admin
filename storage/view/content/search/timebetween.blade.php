<div class="col-lg-4">
    <div class="form-group">
        <label for="exampleInputEmail1">{{$label}}</label>
        <input type="text" class="form-control float-right" id="reservation{{$name}}" placeholder="{{$place}}">
        @if(is_array($data) && count($data) && $data[0] && $data[1])
            <input type="hidden" name="{{$name}}[0]" id="{{$name}}1" value="{{$data[0]}}">
            <input type="hidden" name="{{$name}}[1]" id="{{$name}}2" value="{{$data[1]}}">
        @else
            <input type="hidden" name="{{$name}}[0]" id="{{$name}}1" value="">
            <input type="hidden" name="{{$name}}[1]" id="{{$name}}2" value="">
        @endif
    </div>
    <script>
        // 字段名称
        var name = "{{$name}}";

        // 配置信息
        var config = {
            autoUpdateInput: false,
            timePicker : true, //是否显示小时和分钟
            showDropdowns: true, //年月份下拉框
            opens : 'right', //日期选择框的弹出位置
            // startDate: undefined, //设置开始日期
            // endDate:undefined,
            // maxDate: moment(new Date()), //设置最大日期
            "locale":{
                "format": 'YYYY-MM-DD HH:mm:ss',
                "separator": " - ",
                "applyLabel": "确定",
                "cancelLabel": "取消",
                "fromLabel": "起始时间",
                "toLabel": "结束时间'",
                "customRangeLabel": "自定义",
                "weekLabel": "W",
                "daysOfWeek": ["日", "一", "二", "三", "四", "五", "六"],
                "monthNames": ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
            }
        };

        // 判断是否有默认值
        var startDate = '';
        var endDate = '';

        @if(is_array($data) && count($data))
            startDate = "{{$data[0]}}";
            endDate = "{{$data[1]}}";
            if(startDate != '' && endDate != '')
            {
                config['startDate'] = startDate;
                config['endDate'] = endDate;
                // 显示时间
                $('#reservation'+name).attr('value',startDate + ' ~ ' + endDate);
            }

        @endif

        // 时间格式化
        $('#reservation'+name).daterangepicker(config, function(start, end, label) {//格式化日期显示框
            $('#reservation'+name).attr('value',start.format('YYYY-MM-DD HH:mm:ss') + ' ~ ' + end.format('YYYY-MM-DD HH:mm:ss'));
            $("#"+name+"1").attr('value',start.format('YYYY-MM-DD HH:mm:ss'));
            $("#"+name+"2").attr('value',end.format('YYYY-MM-DD HH:mm:ss'));
        })
    </script>
</div>