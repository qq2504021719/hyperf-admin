<td class="sorting_1 dtr-control">
    @if($isActivityEdit)
        <a href="javascript:void(0)" onclick="viewFaRe('{{$editUrl}}',2)">
            <button type="button" class="btn btn-{{$themeColor}} btn-sm">编辑</button>
        </a>
    @endif
    @if($isActivityDelete)
    <button type="button" class="btn btn-danger btn-sm">删除</button>
    @endif
</td>