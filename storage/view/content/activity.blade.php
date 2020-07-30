<td class="sorting_1 dtr-control">
    @if($isActivityEdit)
        <button type="button" class="btn btn-{{$themeColor}} btn-sm">编辑</button>
    @endif
    @if($isActivityDelete)
    <button type="button" class="btn btn-danger btn-sm">删除</button>
    @endif
</td>