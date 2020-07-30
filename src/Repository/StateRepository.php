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
}