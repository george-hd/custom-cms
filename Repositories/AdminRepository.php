<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 28.2.2016 г.
 * Time: 22:50
 */

namespace Cms\Repositories;

use \Cms\Database as db;

class AdminRepository
{
    private static $instance = null;
    private $db = null;

    private function __construct()
    {
        $this->db = new db;
    }

    /**
     * @param \Cms\Models\AdminModel $adminModel
     * @return mixed
     */
    public function createAdmin(\Cms\Models\AdminModel $adminModel) {
        $sql = "INSERT INTO admins (`name`, `password`, `role_id`) VALUES (?, ?, ?)";
        $result = $this->db->prepare($sql)->execute([
            $adminModel->getName(),
            $adminModel->getPassword(),
            $adminModel->getRoleId()
        ])->getAffectedRows();
        return $result;
    }

    /**
     * @param \Cms\Models\AdminModel $adminModel
     * @return mixed
     */
    public function deleteAdmin(\Cms\Models\AdminModel $adminModel) {
        $sql = "DELETE FROM admins WHERE `id` = ?";
        $result = $this->db->prepare($sql)->execute([$adminModel->getId()])->getAffectedRows();
        return $result;
    }

    public function updateAdmin(\Cms\Models\AdminModel $adminModel) {
        $sql = "UPDATE admins SET `name` = ?, `password` = ?, `role_id` = ? WHERE `id` = ?";
        $result = $this->db->prepare($sql)->execute([
            $adminModel->getName(),
            $adminModel->getPassword(),
            $adminModel->getRoleId(),
            $adminModel->getId()
        ])
            ->getAffectedRows();
        return $result;
    }

    /**
     * @return mixed
     */
    public function getAdmins() {
        $sql = "SELECT
            admins.id as admin_id,
            admins.name as admin_name,
            roles.id as role_id,
            roles.name as role_name
            FROM admins
            LEFT JOIN roles
            ON (admins.role_id = roles.id)";
        $result = $this->db->prepare($sql)->execute([])->fetchAllAssoc();
        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAdminById($id) {
        $sql = 'SELECT `id`, `name`, `password`, `role_id` FROM admins WHERE `id` = ?';
        $result = $this->db->prepare($sql)->execute([$id])->fetchRowAssoc();
        return $result;
    }

    /**
     * @param $adminModel
     * @return mixed
     */
    public function getAdminByName(\Cms\Models\AdminModel $adminModel) {
        $sql = "SELECT `id`, `name`, `password`, `role_id` FROM admins WHERE `name` = ?";
        $result = $this->db->prepare($sql)->execute([$adminModel->getName()])->fetchRowAssoc();
        return $result;
    }

    /**
     * @param $role_id
     * @return mixed
     */
    public function getAdminsByRole($role_id) {
        $sql = "SELECT `id`, `name`, `role_id` FROM admins WHERE `role_id` = ?";
        $result = $this->db->prepare($sql)->execute([$role_id])->fetchAllAssoc();
        return $result;
    }

    /**
     * @return AdminRepository
     */
    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new \Cms\Repositories\AdminRepository();
        }
        return self::$instance;
    }
}