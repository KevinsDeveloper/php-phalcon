<?php

class DbAuthUser extends \Phalcon\Mvc\Model
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
     * @Column(type="integer", length=10, nullable=false)
     */
    public $role_id;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $account;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $realname;

    /**
     *
     * @var string
     * @Column(type="string", length=20, nullable=false)
     */
    public $phone;

    /**
     *
     * @var string
     * @Column(type="string", length=40, nullable=false)
     */
    public $position;

    /**
     *
     * @var string
     * @Column(type="string", length=64, nullable=false)
     */
    public $password;

    /**
     *
     * @var string
     * @Column(type="string", length=100, nullable=false)
     */
    public $password_token;

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
    public $login_at;

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
        $this->setSource("admin_auth_user");
        $this->hasOne('role_id', 'DbAuthRole', 'id', ['alias' => 'role']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'admin_auth_user';
    }

    /**
     * beforeSave
     */
    public function beforeSave()
    {
        $this->updated_at = time();
    }

    /**
     * beforeCreate
     */
    public function beforeCreate()
    {
        $this->created_at = $this->updated_at = time();
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return DbAuthUser[]|DbAuthUser|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return DbAuthUser|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * @desc
     * @access public
     * @return array
     */
    public function validation()
    {
        $validation = new Phalcon\Validation;
        $validation->add('account', new Phalcon\Validation\Validator\StringLength([
            'max' => 20,
            'min' => 5,
            "messageMaximum" => "账号长度5~20位",
            "messageMinimum" => "账号长度5~20位",
        ]));
        return $this->validate($validation);
    }
}
