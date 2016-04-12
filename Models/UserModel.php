<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 19.11.2015 г.
 * Time: 14:15
 */
namespace Cms\Models;
use Cms\Common;
use \Cms\Validation;

class UserModel extends BaseModel
{
    private $user_id;
    private $name;
    private $password;
    private $realName;
    private $family;
    private $email;
    private $role_id;

    /**
     * UserModel constructor.
     * @param $name
     * @param $password
     * @param $realName
     * @param $family
     * @param $email
     * @param int $role_id
     */
    public function __construct($name, $password, $realName, $family, $email, $role_id = 3, $user_id = null)
    {
        $this->setName($name);
        $this->setPassword($password);
        $this->setRealName($realName);
        $this->setFamily($family);
        $this->setEmail($email);
        $this->setUserId($user_id);
        $this->setRoleId($role_id);
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return void | array
     */
    private function setName($name)
    {
        $name = \Cms\Common::normalize($name, 'trim, string, xss');
        $validator = new Validation();
        $validator->setRule('required', $name, '', 'Potrebitelskoto ime e zadylvitelno.')
            ->setRule('minLen', $name, '3', 'Потребителското име трябва да е най-малко 3 символа.')
            ->setRule('maxLen', $name, '20', 'Потребителското име не може да е повече от 20 символа.')
            ->validate();
        if($validator->getErrors()) {
            return $this->errors['user'] = $validator->getErrors()[0];
        }
        $this->name = $name;
    }

    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     * @return void | array
     */
    private function setPassword($password)
    {
        $password = \Cms\Common::normalize($password, 'trim, string, xss');
        $validator = new Validation();
        $validator->setRule('required', $password, '', 'Паролата е задължителна.')
            ->setRule('minLen', $password, '3', 'Паролата не може да е по-малко от 5 символа.')
            ->setRule('maxLen', $password, '20', 'Паролата не може да е повече от 20 символа.')
            ->validate();
        if($validator->getErrors()) {
            return $this->errors['password'] = $validator->getErrors()[0];
        }
        $this->password = $password;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param $user_id
     * @return void | array
     */
    private function setUserId($user_id)
    {
        $user_id = \Cms\Common::normalize($user_id, 'trim, int, xss');
        $validator = new Validation();
        $validator->setRule('required', $user_id, '', 'missing user id.')
            ->validate();
        if($validator->getErrors()) {
            return $this->errors['user_id'] = $validator->getErrors()[0];
        }
        $this->user_id = $user_id;
    }

    public function getRealName()
    {
        return $this->realName;
    }

    /**
     * @param $realName
     * @return mixed
     */
    public function setRealName($realName)
    {
        $realName = \Cms\Common::normalize($realName, 'trim, string, xss');
        $validator = new Validation();
        $validator->setRule('required', $realName, '', 'Името е задължително.')
            ->setRule('minLen', $realName, '3', 'Името не може да е по-малко от 3 символа.')
            ->setRule('maxLen', $realName, '20', 'Името не може да е повече от 20 символа.')
            ->validate();
        if($validator->getErrors()) {
            return $this->errors['realName'] = $validator->getErrors()[0];
        }
        $this->realName = $realName;
    }

    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @param $family
     * @return mixed
     */
    public function setFamily($family)
    {
        $family = Common::normalize($family, 'trim, string, xss');
        $validator = new Validation();
        $validator->setRule('required', $family, '', 'Фамилията е задължителна.')
            ->setRule('minLen', $family, '3', 'Фамилията не може да е по-малко от 3 символа.')
            ->setRule('maxLen', $family, '20', 'Фамилията не може да е повече от 20 символа.')
            ->validate();
        if($validator->getErrors()) {
            return $this->errors['family'] = $validator->getErrors()[0];
        }
        $this->family = $family;
    }

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     * @return mixed
     */
    public function setEmail($email)
    {
        $email = Common::normalize($email, 'trim, string, xss');
        $validator = new Validation();
        $validator->setRule('required', $email, '', 'Фамилията е задължителна.')
            ->setRule('email', $email, 'Невалиден email.')
            ->validate();
        if($validator->getErrors()) {
            return $this->errors['email'] = $validator->getErrors()[0];
        }
        $this->email = $email;
    }

    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * @param $role_id
     * @return mixed
     */
    public function setRoleId($role_id)
    {
        $role_id = Common::normalize($role_id, 'trim, int, xss');
        $validator = new Validation();
        $validator->setRule('gt', $role_id, 0)
            ->setRule('lt', $role_id, 4)
            ->validate();
        if($validator->getErrors()) {
            return $this->errors['role'] = $validator->getErrors()[0];
        }
        $this->role_id = $role_id;
    }
}