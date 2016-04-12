<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 3.4.2016 г.
 * Time: 9:58
 */

namespace Cms\Repositories;


class ResourceRepository
{
    private static $instance = null;
    private $db = null;

    private function __construct()
    {
        $this->db = new \Cms\Database();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getResourceById($id) {
        $sql = "SELECT * FROM resources WHERE `id` = ?";
        return $this->db->prepare($sql)->execute([$id])->fetchRowAssoc();
    }

    /**
     * @param \Cms\Models\ResourceModel $resource
     * @return mixed
     */
    public function getResourceByKey(\Cms\Models\ResourceModel $resource) {
        $sql = "SELECT * FROM resources WHERE `key` = ?";
        return $this->db->prepare($sql)->execute([$resource->getKey()])->fetchAllObj();
    }

    /**
     * @param \Cms\Models\SectionModel $section
     * @return mixed
     */
    public function getResourcesBySection(\Cms\Models\SectionModel $section) {
        $sql = "SELECT * FROM resources WHERE `section_id` = ?";
        return $this->db->prepare($sql)->execute([$section->getId()])->fetchAllAssoc();
    }

    /**
     * @param \Cms\Models\ResourceModel $res
     * @return mixed
     */
    public function addResource(\Cms\Models\ResourceModel $res) {
        $sql = "INSERT INTO resources (`key`, `value`, `section_id`)  VALUES (?, ?, ?)";
        return $this->db->prepare($sql)->execute([$res->getKey(), $res->getValue(), $res->getSectionId()])->getAffectedRows();
    }

    /**
     * @param \Cms\Models\ResourceModel $res
     * @return mixed
     */
    public function updateResource(\Cms\Models\ResourceModel $res) {
        $sql = "UPDATE resources SET `value` = ? WHERE `key` = ?";
        return $this->db->prepare($sql)->execute([$res->getValue(), $res->getKey()])->getAffectedRows();
    }

    /**
     * @return ResourceRepository
     */
    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new \Cms\Repositories\ResourceRepository();
        }
        return self::$instance;
    }
}