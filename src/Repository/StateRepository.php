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
     *
     */
    const FORM_TEXT                 = 'text';                               // 文本
    const FORM_NUMBER               = 'number';                             // 数字
    const FORM_UPLOAD               = 'upload';                             // 上传
    const FORM_MANY_UPLOAD          = 'many_upload';                        // 多选上传
    const FORM_SELECT               = 'select';                             // 下拉框
    const FORM_SELECT_AJAX          = 'select_ajax';                        // 下拉框ajax加载
    const FORM_TIME                 = 'time';                               // 日期选择
    const FORM_CHECKBOX             = 'checkbox';                           // 多选
    const FORM_RADIO                = 'radio';                              // 单选
    const FORM_EDIT                 = 'edit';                               // 编辑
    const FORM_EDIT_SAVE            = 'edit_save';                          // 编辑保存
    const FORM_ADD                  = 'add';                                // 添加
    const FORM_ADD_SAVE             = 'add_save';                           // 添加保存
    const GRID_LIST                 = 'list';                               // list
    const GRID_EXCEL                = 'excel';                              // 导出
    const FORM_INPUT_TEXT           = 'text';                               // input文本类型-文本
    const FORM_INPUT_HIDDEN         = 'hidden';                             // input文本类型-隐藏
    const FORM_INPUT_FILE           = 'file';                               // input文本类型-文件




    /**
     * 固定格式url
     */
    const URL_LOGIN                 = 'auth';                               // 登录页
    const URL_LOGIN_OUT             = 'auth/out';                           // 退出
    const URL_EXCEL                 = 'excel';                              // 导出
    const URL_EDIT                  = 'edit';                               // 编辑
    const URL_EDIT_SAVE             = 'edit_save';                          // 编辑保存
    const URL_ADD                   = 'add';                                // 添加
    const URL_ADD_SAVE              = 'add_save';                           // 添加保存
    const URL_DEL                   = 'delete';                             // 删除

    /**
     * SESSION键名
     */
    const TOASTR_NAME               = 'toastr';                             // 提示键名

    /**
     * Toastr提示类型
     */
    const TOASTR_WARNING            = 'warning';                            // 警告
    const TOASTR_SUCCESS            = 'success';                            // 成功
    const TOASTR_ERROR              = 'error';                              // 错误
    const TOASTR_INFO               = 'info';                               // 提示

}