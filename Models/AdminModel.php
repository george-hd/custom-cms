<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 29.2.2016 г.
 * Time: 12:28
 */

namespace Cms\Models;


class AdminModel extends BaseModel
{
    private $id = null;
    private $name = null;
    private $password = null;
    private $role_id = null;

    public function __construct($id, $name, $password, $role_id)
    {
        if($id) $this->setId($id);
        $this->setName($name);
        if($password) $this->setPassword($password);
        if($role_id) $this->setRoleId($role_id);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $id = \Cms\Common::normalize($id, 'trim, int, xss');
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return null
     */
    public function setName($name)
    {
        $name = \Cms\Common::normalize($name, 'trim, string, xss');
        $validator = new \Cms\Validation();
        $validator->setRule('required', $name, '', 'Admin name is required')
            ->validate();
        if($validator->getErrors()) {
            $this->setErrors('admin-name', $validator->getErrors());
            return $this->getErrors();
        }
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     * @return null
     */
    public function setPassword($password)
    {
        $password = \Cms\Common::normalize($password, 'trim, string, xss');
        $validator = new \Cms\Validation();
        $validator->setRule('required', $password, '', 'password is required')
            ->setRule('minlen', $password, '5', 'Password must be between 5 and 20 characters')
            ->setRule('maxlen', $password, '20', 'Password must be between 5 and 20 characters')
            ->validate();
        if($validator->getErrors()) {
            $this->errors['admin-password'] = $validator->getErrors();
            return $this->getErrors();
        }
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * @param $role_id
     * @return null
     */
    public function setRoleId($role_id)
    {
        $role_id = \Cms\Common::normalize($role_id, 'trim, int, xss');
        $role = \Cms\Repositories\RoleRepository::getInstance()->getRole($role_id);
        if(!$role) {
            $this->setErrors('admin-role_id', 'Role does not exists!');
            return $this->getErrors();
        }
        $this->role_id = $role_id;
    }
}