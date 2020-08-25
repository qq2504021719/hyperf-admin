
<div class="form-group row">
    <label class="col-sm-1 col-form-label" for="exampleInputEmail1">{{$label}}</label>
    <div class="col-sm-11">
        <input type="hidden" id="select2-input-{{$name}}" name="{{$name}}" value="{{$data}}">
        <select class="form-control @if($errorStr) is-invalid @endif select2{{$name}}" style="width: 100%;">
            @if(count($option))
                @foreach($option as $k=>$v)
                    <option value="{{$k}}" >{{$v}}</option>
                @endforeach
            @endif
        </select>
        @if($errorStr)
            <div class="invalid-feedback">
                {{$errorStr}}
            </div>
        @endif

        @if($help)
            <small id="passwordHelpInline" class="text-muted">
                {{$help}}
            </small>
        @endif
    </div>
</div>
<script>
    var {{$name}}key = '.select2{{$name}}';
    var {{$name}}val = "{{$data}}";

    // 设置默认选择事件
    $({{$name}}key).val({{$name}}val).select2()
    //初始化Select2
    $({{$name}}key).select2({
        placeholder: {id: '', text: "{{$placeholder}}"}, // 同上，这里默认空值为 ''
    })

    // 选中事件
    $({{$name}}key).on("select2:select", function(e) {
        var val = $({{$name}}key).select2("val");
        // 设置值
        $('#select2-input-{{$name}}').attr('value',val)
    });
</script>
