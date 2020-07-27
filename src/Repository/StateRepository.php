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
}