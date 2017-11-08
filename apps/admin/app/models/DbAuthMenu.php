<?php

class DbAuthMenu extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $pid;

    /**
     *
     * @var string
     * @Column(type="string", length=60, nullable=false)
     */
    public $title;

    /**
     *
     * @var string
     * @Column(type="string", length=60, nullable=false)
     */
    public $url;

    /**
     *
     * @var string
     * @Column(type="string", length=40, nullable=false)
     */
    public $module;

    /**
     *
     * @var string
     * @Column(type="string", length=40, nullable=false)
     */
    public $controller;

    /**
     *
     * @var string
     * @Column(type="string", length=40, nullable=false)
     */
    public $action;

    /**
     *
     * @var string
     * @Column(type="string", length=60, nullable=false)
     */
    public $params;

    /**
     *
     * @var string
     * @Column(type="string", length=40, nullable=false)
     */
    public $icon;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=true)
     */
    public $rank;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=false)
     */
    public $orderby;

    /**
     *
     * @var integer
     * @Column(type="integer", length=1, nullable=false)
     */
    public $status;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $created_at;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $updated_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("admin_auth_menu");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'admin_auth_menu';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return DbAuthMenu[]|DbAuthMenu|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return DbAuthMenu|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
