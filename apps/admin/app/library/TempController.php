<?php

/**
 * 控制器入口基类
 * Class BaseController
 * @package admin\base
 */
class TempController extends \BaseController
{
    /**
     * @desc
     * @var string
     */
    protected $model;

    /**
     * @desc
     * @var string
     */
    protected $with = [];

    /**
     * @desc
     * @var string
     */
    protected $joinwith = [];

    /**
     * @desc 排序
     * @var string
     */
    protected $order = 'id DESC';

    /**
     * @desc
     * @var string
     */
    protected $andWhere = '';

    /**
     * @desc 分页
     * @var string
     */
    protected $limit = 20;

    /**
     * @desc  编辑是否弹窗
     * @var string
     */
    protected $editLayer = 1;

    /**
     * @desc  是否执行事务
     * @var string
     */
    protected $routine = false;

    /**
     * @desc  编辑视图
     * @var string
     */
    protected $deitView = 'form';

    /**
     * @desc  0 修改数据状态  1删除数据
     * @var string
     */
    protected $isDel = 1;

    /**
     * @desc   返回对象类名
     * @access public
     * @param  object $object
     * @return string
     */
    public function getClassName($object)
    {
        $objectArr = explode('\\', $object);
        return $objectArr[count($objectArr) - 1];
    }

    /**
     * @desc   搜索
     * @access public
     * @return array
     */
    public function doWhere($option)
    {
        return $option;
    }

    /**
     * @desc   列表处理
     * @access public
     * @param
     * @return array
     */
    public function doList($list = [])
    {

    }


    /**
     * @desc   列表页
     * @access public
     * @return string
     */
    public function indexAction()
    {
        $search = $this->request->get('sear');
        $where = $this->doWhere($search);
        $builder = $this->modelsManager->createBuilder()->from(get_class($this->model))->where($where)->orderBy($this->order);
        $pages = new \Phalcon\Paginator\Adapter\QueryBuilder([
            "builder" => $builder,
            "limit" => $this->limit,
            "page" => (int)$this->request->getQuery("page", "int", 1),
        ]);
        $data = $pages->getPaginate();
        $this->view->pages = $pages->getPaginate();
        $this->view->sear = $search;
        $this->doList($data->items);
        return parent::render();
    }

    /**
     * @desc   编辑视图
     * @access public
     * @return array
     */
    public function editForm()
    {

    }

    /**
     * @desc   添加处理项
     * @access public
     * @return
     */
    public function doEdit($data, $type = 'add')
    {
        if (!$this->model->save($data)) {
            return parent::JsonFormat(500, \Base::modelError($this->model->getMessages()));
        }
        $this->afterEdit($this->model, $this->model->id);
        return parent::JsonFormat(200, $this->lang->t('app', $type . '_suc'));
    }

    /**
     * @desc   添加处理项
     * @access public
     * @param  array $data 表单数据
     * @return array
     */
    public function beforeSave($data)
    {
        return $data;
    }

    /**
     * @desc
     * @access public
     * @param
     * @return array
     */
    public function afterEdit($model, $id = 0)
    {

    }

    /**
     * @desc   添加
     * @access public
     * @return string
     */
    public function addAction()
    {
        if ($this->request->isAjax() && $this->request->isPost()) {
            $data = $this->beforeSave($this->request->getPost(get_class($this->model)));
            return $this->doEdit($data);
        }

        $this->view->model = $this->model;
        $this->editForm();
        if ($this->editLayer) $this->view->setMainView("../layer");
        return parent::render($this->deitView);
    }

    /**
     * @desc   修改
     * @access public
     * @return string
     */
    public function editAction()
    {
        $this->model = $this->model->findFirstById(parent::getId());
        if ($this->request->isAjax() && $this->request->isPost()) {
            if (empty($this->model->id)) {
                return parent::JsonFormat(500, $this->lang->t('app', 'params_err'));
            }
            $data = $this->beforeSave($this->request->getPost(get_class($this->model)));
            return $this->doEdit($data, 'update');
        }

        $this->view->model = $this->model;
        $this->editForm();
        if ($this->editLayer) $this->view->setMainView("../layer");
        return parent::render($this->deitView);
    }

    /**
     * @desc   删除前操作
     * @access public
     * @param
     * @return array
     */
    public function beforeDel()
    {

    }

    /**
     * @desc
     * @access public
     * @param
     * @return array
     */
    public function afterDel($model)
    {
        return true;
    }

    /**
     * @desc   删除
     * @access public
     * @return json
     */
    public function delAction()
    {
        if ($this->request->isAjax() && $this->request->isPost()) {
            $id = parent::postId();
            $this->model = $this->model->findFirstById($id);
            $oldData = $this->model;
            if (empty($this->model->id)) {
                return parent::JsonFormat(500, $this->lang->t('app', $this->lang->t('app', 'data_empty')));
            }
            $db = $this->model->getDI()->get('db');
            $db->begin();
            if ($this->isDel) {
                $delState = $this->model->delete();
            } else {
                $this->beforeDel();
                $delState = $this->model->save();
            }
            if ($delState) {
                $after = $this->afterDel($oldData);
                if ($after) {
                    $db->commit();
                    return parent::JsonFormat(200, $this->lang->t('app', $this->lang->t('app', 'del_suc')));
                } else {
                    $db->rollback();
                    return parent::JsonFormat(500, $this->lang->t('app', 'del_err'));
                }
            } else {
                $db->rollback();
                return parent::JsonFormat(500, \Base::modelError($this->model->getMessages()));
            }
        }
        return parent::JsonFormat(500, $this->lang->t('app', 'params_err'));
    }

    /**
     * @desc   无限分类树
     * @access public
     * @return array
     */
    public function tree($data)
    {
        $tree = new \app\modules\settings\models\Tree($this);
        $tree->tmplate = $this->lang->t('app', 'options');
        $tree->init($data);
        return $tree->getShiftTree();
    }
}
