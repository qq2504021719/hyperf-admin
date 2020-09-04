<div class="form-group row">
    <label class="col-sm-{{$labelCol}} col-form-label">{{$label}}</label>
    <div class="col-sm-{{$inputCol}}">
        <input type="{{$inputType}}" class="custom-file-input form-control @if($errorStr) is-invalid @endif" id="{{$name}}uploadFile" >
        <input name="{{$name}}" type="hidden" value="{{$valueData}}" id="{{$name}}uploadFile-value">
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
// 默认值初始化
var preList{{$name}} = new Array();
var num{{$name}} = 0;
        @if(count($data) > 0)
      @foreach($data as $k => $v)
        preList{{$name}}['{{$k}}'] = '<img src="{{$v}}" style="max-width:100%" />';
      @endforeach
@endif
    $("#{{$name}}uploadFile").fileinput({
        language: 'zh', //设置语言
        uploadUrl:"{{$url}}", //上传的地址
        allowedFileExtensions: ['jpg', 'gif', 'png','jpge'],//接收的文件后缀
        //uploadExtraData:{"id": 1, "fileName":'123.mp3'},
        uploadAsync: true, //默认异步上传
        showUpload:false, //是否显示上传按钮
        showRemove :false, //显示移除按钮
        showPreview :true, //是否显示预览
        showCaption:false,//是否显示标题
        // browseClass:"form-control", //按钮样式
        dropZoneEnabled: false,//是否显示拖拽区域
        layoutTemplates:{
            actionUpload:'',
        },
        maxFileCount:1, //表示允许同时上传的最大文件个数
        minFileCount:1,
        autoReplace:true,// 是否自动替换当前图片，设置为true时，再次选择文件，会将当前的文件替换掉。
        enctype:'multipart/form-data',
        validateInitialCount:true,
        previewFileType:['image'],     // 预览文件类型[‘image’, ‘html’, ‘text’, ‘video’, ‘audio’, ‘flash’, ‘object’,‘other‘]
        initialPreview:preList{{$name}}, // 类型string或array。显示的初始化预览内容。你可以传入一个简单的HTML标签用于显示图片、文本或文件。如果设置一个字符串，会在初始化预览图中显示一个文件。你可以在initialDelimiter属性中设置分隔符用于显示多个预览图。如果设置为数组，初始化预览图中会显示数组中所有的文件。
        previewFileIcon: "<iclass='glyphicon glyphicon-king'></i>",

        msgFilesTooMany: "选择上传的文件数量({n}) 超过允许的最大数值{m}！",

    }).on("filebatchselected", function (event, data){
          if(num{{$name}} >= 1)
          {
              toastr.warning('上传失败,上传的图片不能超过1张');
          }
          else
          {
              $(this).fileinput("upload");
          }
          // 清空预览
          // $(event.target).fileinput('clear').fileinput('unlock');
          // 选择完文件-自动上传
    })
      // 异步上传错误结果处理
      .on('fileerror', function(event, data, msg) {
          // 清除当前的预览图 ，并隐藏 【移除】 按钮
          // $(event.target)
          //     .fileinput('clear')
          //     .fileinput('unlock')
          // $(event.target)
          //     .parent()
          //     .siblings('.fileinput-remove')
          //     .hide()
          // // 打开失败的信息弹窗
          // toastr.warning('请求失败，请稍后重试')
      })
      .on("fileuploaded", function(event, data) {
      var key = '{{$name}}uploadFile-value';
      var re = data.response;
      if(re.code == 200)
      {
          num{{$name}}++;
          // 设置图片值
          $('#'+key).attr('value',re.data.path);
      }
      else
      {
          toastr.error(re.msg)
      }
    })
          //删除单张图片事件，只针对已经上传的图片
    .on("filesuccessremove",function(event, data, msg){

    })
          // 删除单张图片，但只针对未上传的图片
    .on("fileremoved",function(event, data, msg){

    });
</script>