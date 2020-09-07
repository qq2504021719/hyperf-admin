<div class="row">
    <div class="col-sm-12 col-md-5">
        <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">
            显示{{$pageHtml->count}}个条目中的{{$pageHtml->start}}到{{$pageHtml->end}}个
        </div>
    </div>
    <div class="col-sm-12 col-md-7">
        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            <ul class="pagination">
                <li class="paginate_button page-item previous @if ($pageHtml->page == 1) disabled @endif" id="example2_previous">
                    <a href="javascript:void(0)" onclick="viewFaRe('page={{$pageHtml->page-1}}',1)" class="page-link">上一页</a>
                </li>

                {{--页头跳转--}}
                @if($pageHtml->page > $pageHtml->step+2)
                    @for ($i = 1; $i <= 2; $i++)
                        <li class="paginate_button page-item @if ($pageHtml->page == $i) active @endif">
                            <a href="javascript:void(0)" onclick="viewFaRe('page={{$i}}',1)" class="page-link">{{$i}}</a>
                        </li>
                    @endfor
                    <li class="paginate_button page-item">
                        <a href="javascript:void(0)" class="page-link">...</a>
                    </li>
                @endif


                {{--当前页前--}}
                @for ($i = ($pageHtml->page-$pageHtml->step)>0?($pageHtml->page-$pageHtml->step):1; $i < $pageHtml->page; $i++)
                    <li class="paginate_button page-item @if ($pageHtml->page == $i) active @endif">
                        <a href="javascript:void(0)" onclick="viewFaRe('page={{$i}}',1)" class="page-link">{{$i}}</a>
                    </li>
                @endfor


                {{--当前页后--}}
                @for ($i = $pageHtml->page; $i <= ($pageHtml->pageNum>($pageHtml->step+$pageHtml->page)?($pageHtml->step+$pageHtml->page):$pageHtml->pageNum); $i++)
                    <li class="paginate_button page-item @if ($pageHtml->page == $i) active @endif">
                        <a href="javascript:void(0)" onclick="viewFaRe('page={{$i}}',1)" class="page-link">{{$i}}</a>
                    </li>
                @endfor

                {{--页尾跳转--}}
                @if($pageHtml->pageNum-(2+$pageHtml->step) > $pageHtml->page)
                    <li class="paginate_button page-item">
                        <a href="javascript:void(0)" class="page-link">...</a>
                    </li>
                    @for ($i = $pageHtml->pageNum-1; $i <= $pageHtml->pageNum; $i++)
                        <li class="paginate_button page-item @if ($pageHtml->page == $i) active @endif">
                            <a href="javascript:void(0)" onclick="viewFaRe('page={{$i}}',1)" class="page-link">{{$i}}</a>
                        </li>
                    @endfor
                @endif

                <li class="paginate_button page-item next @if ($pageHtml->pageNum == $pageHtml->page) disabled @endif" id="example2_next">
                    <a href="javascript:void(0)" onclick="viewFaRe('page={{$pageHtml->page+1}}',1)" class="page-link">下一页</a>
                </li>
            </ul>
        </div>
    </div>
</div>