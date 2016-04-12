<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 19.11.2015 г.
 * Time: 14:22
 */
namespace Cms\Repositories;
use \Cms\Database as db;
use \Cms\Models\UserModel;

class UserRepository
{
    /** @var \Cms\Repositories\UserRepository @ */
    private static $instance = null;
    /** @var \Cms\Database */
    private $db = null;

    private function __construct()
    {
        $this->db = new db();
    }

    /**
     * @return db
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param UserModel $user
     * @return bool|UserModel
     */
    public function register(UserModel $user)
    {
        $sql = "SELECT user_name, email FROM users WHERE user_name = ? OR email = ?";
        $result = $this->db->prepare($sql)
            ->execute([$user->getName(), $user->getEmail()])
            ->fetchAllAssoc();
        if(count($result) > 0) {
            foreach ($result as $value) {
                foreach ($value as $k => $v) {
                    if($user->getEmail() === $v) {
                        $user->setErrors($k, $v);
                    } elseif($user->getName() === $v) {
                        $user->setErrors($k, $v);
                    }
                }
            }
            return false;
        } else {
            $sql = "INSERT INTO users (user_name, password, real_name, family, email) VALUES (?, ?, ?, ?, ?)";
            $result = $this->db->prepare($sql)
                ->execute([
                    $user->getName(),
                    $user->getPassword(),
                    $user->getRealName(),
                    $user->getFamily(),
                    $user->getEmail()
                ]);
            if(!$result) {
                return false;
            }
            return $this->login($user->getName(), $user->getPassword());
        }
    }

    /**
     * @param $name
     * @param $password
     * @return bool|UserModel
     */
    public function login($name, $password)
    {
        $sql = "SELECT user_id, user_name, password, real_name, family, email, role_id FROM users WHERE user_name = ? AND password = ?";
        $result = $this->db->prepare($sql)
            ->execute([$name, $password])
            ->fetchRowAssoc();
        if(!$result) {
            return false;
        }
        return new \Cms\Models\UserModel($result['user_name'], $result['password'], $result['real_name'], $result['family'], $result['email'], $result['role_id'], $result['user_id']);
    }

    /**
     * @param $id
     * @return bool|UserModel
     */
    public function getUser($id)
    {
        $result = $this->db->prepare("SELECT user_id, user_name, password, role, real_name, family, email FROM users WHERE user_id = ?")
            ->execute([$id])
            ->fetchRowAssoc();
        if(!$result) {
            return false;
        }
        return  new UserModel($result['user_name'], $result['password'], $result['real_name'], $result['family'], $result['email'], $result['role'], $result['user_id']);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getUserByName($name)
    {
        $name .= '%';
        $sql = "SELECT user_id, user_name, email, role FROM users WHERE user_name LIKE ?";

        $result = $this->db->prepare($sql)->execute([$name])->fetchAllAssoc();
        return $result;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getAdminByName($name)
    {
        $name .= '%';
        $role = 'role < 3';
        $sql = "SELECT user_id, user_name, email, role FROM users WHERE $role AND user_name LIKE ?";
        $result = $this->db->prepare($sql)->execute([$name])->fetchAllAssoc();
        return $result;
    }

    /**
     * @param UserModel $user
     * @return mixed
     */
    public function updateUser(\Cms\Models\UserModel $user)
    {
        $sql = "UPDATE users SET user_name = ?, password = ?, real_name = ?, family = ?, email = ?, role = ? WHERE user_id =?";
        $result = $this->db->prepare($sql)
            ->execute([$user->getName(), $user->getPassword(), $user->getRealName(), $user->getFamily(), $user->getEmail(), $user->getRole(), $user->getUserId()])
            ->getAffectedRows();
        return $result;
    }

    /**
     * @param $id
     * @return $this
     */
    public function deleteById($id)
    {
        $sql = "DELETE FROM users WHERE user_id = ?";
        $result = $this->db->prepare($sql)
            ->execute([$id]);
        return $result;
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function getUsers($role, $order, $limit)
    {
        $sql = "SELECT user_id, user_name, email, role_id FROM users WHERE role_id = ? $order LIMIT $limit";
        $result = $this->db->prepare($sql)
            ->execute([$role])
            ->fetchAllAssoc();
        return $result;
    }

    /**
     * @return mixed
     */
    public function getCountUsers($where)
    {
        $sql = "SELECT count(*) FROM users WHERE $where";
        $result = $this->db->prepare($sql)
            ->execute()
            ->fetchRowNum();
        return $result[0];
    }

    /**
     * @return \Cms\Repositories\UserRepository
     */
    public static function getInstance()
    {
        if(self::$instance === null) {
            self::$instance = new \Cms\Repositories\UserRepository();
        }
        return self::$instance;
    }
}