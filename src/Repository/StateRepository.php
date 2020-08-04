<?php
/**
 * Created by PhpStorm.
 * User: EricPan
 * Date: 2020/7/27
 * Time: 14:35
 */

namespace Pl\HyperfAdmin\Repository;


class StateRepository
{
    /**
     * 搜索
     */
    const SEARCH_LIKE               = 'like';
    const SEARCH_E_THAN             = '<';
    const SEARCH_G_THAN             = '>';
    const SEARCH_NOT_EQUAL          = '<>';
    const SEARCH_EQUAL              = '=';
    const SEARCH_TIME_BETWEEN       = 'time_between';
    const SEARCH_SELETE2            = 'select';
    const SEARCH_SELETE2_AJAX       = 'select_ajax';


    /**
     * bootstrap通用颜色
     */
    const BOOTSTRAP_COLOR_DANGER    = 'danger';
    const BOOTSTRAP_COLOR_WARNING   = 'warning';
    const BOOTSTRAP_COLOR_PRIMARY   = 'primary';
    const BOOTSTRAP_COLOR_SUCCESS   = 'success';


    /**
     * Form页面
     */
    const FORM_TEXT                 = 'text';                               // 文本
    const FORM_NUMBER               = 'number';                             // 数字
    const FORM_UPLOAD               = 'upload';                             // 上传
    const FORM_MANY_UPLOAD          = 'many_upload';                        // 多选上传
    const FORM_SELECT               = 'select';                             // 下拉框
    const FORM_SELECT_AJAX          = 'select_ajax';                        // 下拉框ajax加载
    const FORM_CHECKBOX             = 'checkbox';                           // 多选
    const FORM_RADIO                = 'radio';                              // 单选
    const FORM_EDIT                 = 'edit';                               // 编辑
    const FORM_ADD                  = 'add';                                // 添加


}