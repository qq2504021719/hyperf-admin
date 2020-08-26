<div class="form-group row">
    <label class="col-sm-1 col-form-label" for="exampleInputEmail1">{{$label}}</label>
    <div class="col-sm-11">
        <input type="{{$inputType}}" class="form-control @if($errorStr) is-invalid @endif float-right" name="{{$name}}" value="{{$data}}" id="reservation{{$name}}" placeholder="{{$placeholder}}" data-target="#reservation{{$name}}" data-toggle="datetimepicker">
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
    <script>
        $('#reservation{{$name}}').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            pickerPosition: "bottom-left",
            autoclose: true
        });
    </script>
</div>