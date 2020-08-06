<div class="col-lg-4">
    <div class="form-group">
        <label for="exampleInputEmail1">{{$label}}</label>
        <input type="hidden" id="select2-input-{{$name}}" name="{{$name}}" value="{{$data}}">
        <select class="form-control select2{{$name}}" style="width: 100%;">
            @if(count($option))
                @foreach($option as $k=>$v)
                    <option value="{{$k}}" >{{$v}}</option>
                @endforeach
            @endif
        </select>
    </div>
    <script>
        var key{{$name}} = '.select2{{$name}}';
        var val{{$name}} = "{{$data}}";

        // 设置默认选择事件
        $(key{{$name}}).val(val{{$name}}).select2()
        //初始化Select2
        $(key{{$name}}).select2({
            placeholder: {id: '', text: "{{$place}}"}, // 同上，这里默认空值为 ''
        })

        // 选中事件
        $(key{{$name}}).on("select2:select", function(e) {
            var val = $(key{{$name}}).select2("val");
            // 设置值
            $('#select2-input-{{$name}}').attr('value',val)
        });
    </script>
</div>