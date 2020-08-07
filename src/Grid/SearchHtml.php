<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/27
 * Time: 11:34
 */

namespace Pl\HyperfAdmin\Grid;

use Hyperf\HttpServer\Contract\RequestInterface;
use Pl\HyperfAdmin\Lib\Functions;

class SearchHtml
{
    use Functions;

    /**
     * 主题色
     * @var
     */
    public $themeColor;

    /**
     * 可查询字段
     * @var
     */
    public $fields;

    /**
     * 搜索html组合初始化
     * Created by PhpStorm.
     * User: EricPan
     * Date: 2020/7/27
     * Time: 11:35
     * @param RequestInterface $request
     * @param $model
     * @param $searchs
     * @return array
     */
    public function htmlInit(RequestInterface $request,$model,$searchs)
    {
        // fields格式化
        $this->fields = array_keys($this->fields);

        $params = $request->all();
        $page = $this->arrIsKey($params,'page',1);
        $paginate = $this->arrIsKey($params,'paginate',10);
        $id = $this->getID();

        $htmls = '';
        if(count($searchs))
        {
            // html开始
            $htmls = '<div class="card"><div class="card-body"><form method="get" id="'.$id.'" action="">';


            // 隐藏域内容
            $htmls .= '<input name="paginate" value="'.$paginate.'" type="hidden"><input name="page" value="'.$page.'" type="hidden">';

            $i = 0;
            foreach ($searchs as $k=>$v)
            {

                // 设置默认值
                $v->data = $this->arrIsKey($params,$v->name,'');
                if(in_array($v->name,$this->fields))
                {
                    // 查询条件处理
                    $model = $v->queryInit($model);
                }


                // html处理
                if($i == 0) $htmls .= '<div class="row">';
                $htmls .= $v->getHtml();
                $i++;
                if($i == 3 || (count($searchs)-1) == $k)
                {
                    $i = 0;
                    $htmls .= '</div>';
                }

            }

            // html结束
            $htmls .= '<button type="button" onclick="getElements('."'".$id."'".')" class="btn btn-'.$this->themeColor.' float-right">查询</button></form></div></div>';

            // script
            $htmls .= <<<EOT
            <script>
/**
* 获取对应form里面的值
 * @param formId
*/            
function getElements(formId) {  
  var form = document.getElementById(formId);  
  var str = '';
  // var elements = new Array();  
  var tagElements = form.getElementsByTagName('input');  
  for (var j = 0; j < tagElements.length; j++){ 
     // elements.push(tagElements[j].valueOf()); 
     // console.log(tagElements[j].name);
     // console.log(tagElements[j].value);
     var name = tagElements[j].name;
     var value = tagElements[j].value;
     if(name != '' && value != '')
     {
         if(str == '')
         {
             str += name+"="+value;
         }
         else 
         {
             str += "&"+name+"="+value;
         }
     }

  } 
  console.log("search-form参数组合GET参数:"+str)
  viewFaRe(str,1);
}  
</script>
EOT;

        }

        return [
            'html' => $htmls,
            'model' => $model
        ];
    }
}