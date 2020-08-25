<div class="form-group row">
    <label class="col-sm-1 col-form-label">{{$label}}</label>
    <div class="col-sm-11">
        <input type="text" class="form-control @if($errorStr) is-invalid @endif" name="{{$name}}" value="{{$data}}" id="exampleInputEmail1" placeholder="{{$placeholder}}">
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