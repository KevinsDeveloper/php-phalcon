<?php
/**
 * @copyright Copyright (c) 2017
 * @version   Beta 1.0
 * @author    Kevin
 * @time      2017/10/21 0021 上午 11:09
 */

namespace app\modules\settings\controllers;

/**
 * @desc 管理员日志
 * Class LogsController
 * @package app\modules\settings\controllers
 */
class LogsController extends \BaseController
{
    /**
     * @desc 查看
     */
    public function indexAction()
    {
        $search = $this->request->get('search');
        $conditions = 'status=?0';
        $bind[0] = 1;
        if (!empty($search)) {
            if (!empty($search['type'])) {
                $conditions .= " and {$search['type']}=?1";
                $bind[1] = $search['values'];
            }
            if (!empty($search['stime'])) {
                $conditions .= " and created_at>=?2";
                $bind[2] = strtotime($search['stime']);
            }
            if (!empty($search['etime'])) {
                $conditions .= " and created_at<=?3";
                $bind[3] = strtotime($search['etime']);
            }
        }

        $builder = $this->modelsManager->createBuilder()->from('DbAuthLogs')->where($conditions, $bind)->orderBy('created_at desc');
        $pages = new \Phalcon\Paginator\Adapter\QueryBuilder([
            "builder" => $builder,
            "limit" => 20,
            "page" => (int)$this->request->getQuery("page", "int", 1),
        ]);
        $this->view->pages = $pages->getPaginate();
        $this->view->roles = \app\modules\settings\models\Roles::getRoles();
        $this->view->search = $search;
    }
}