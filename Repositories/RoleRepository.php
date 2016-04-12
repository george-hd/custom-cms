<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 29.2.2016 г.
 * Time: 12:51
 */

namespace Cms\Repositories;


class RoleRepository
{
    private static $instance = null;
    private $db = null;

    /**
     * RoleRepository constructor.
     */
    private function __construct()
    {
        $this->db = new \Cms\Database();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getRole($id) {
        $sql = "SELECT `id`, `name` FROM roles WHERE `id` = ?";
        $result = $this->db->prepare($sql)->execute([$id])->fetchRowAssoc();
        return $result;
    }

    public function getAllRoles() {
        $sql = "SELECT `id`, `name` FROM roles";
        $result = $this->db->prepare($sql)->execute([])->fetchAllAssoc();
        return $result;
    }

    /**
     * @return RoleRepository
     */
    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new \Cms\Repositories\RoleRepository();
        }
        return self::$instance;
    }
}