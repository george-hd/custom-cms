<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 26.3.2016 г.
 * Time: 12:09
 */

namespace Cms\Repositories;


class ExternalSectionFieldRepository
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
    public function getExtFieldById($id) {
        $sql = "SELECT * FROM external_fields WHERE `id` = ?";
        return $this->db->prepare($sql)->execute([$id])->fetchRowAssoc();
    }

    /**
     * @param $label
     * @return mixed
     */
    public function deleteExtField($label) {
        $sql = "DELETE FROM external_fields WHERE `label` = ?";
        return $this->db->prepare($sql)->execute([$label])->getAffectedRows();
    }

    /**
     * @param \Cms\Models\SectionModel $section
     * @return mixed
     */
    public function getExtSecFields(\Cms\Models\SectionModel $section) {
        $sql = "SELECT f.id as `id`,
            f.label as `label`,
            f.type as `type`,
            s.key as `section`
            FROM external_fields f
            LEFT JOIN sections s
            ON (f.section_id = s.id)
            WHERE section_id = ?";
        return $this->db->prepare($sql)->execute([$section->getId()])->fetchAllObj();
    }

    /**
     * @param \Cms\Models\SectionModel $section
     * @param \Cms\Models\ExternalSectionFieldModel $field
     * @return mixed
     */
    public function createExtSecField(\Cms\Models\SectionModel $section, \Cms\Models\ExternalSectionFieldModel $field) {
        $sql = "INSERT INTO external_fields (`label`, `type`, `section_id`) VALUES (?, ?, ?)";
        return $this->db->prepare($sql)->execute([$field->getLabel(), $field->getType(), $section->getId()])->getAffectedRows();
    }

    /**
     * @param \Cms\Models\ExternalSectionFieldModel $field
     * @return mixed
     */
    public function updateExtSecField(\Cms\Models\ExternalSectionFieldModel $field) {
        $sql = "UPDATE external_fields SET `label` = ? , `type` = ?, `section_id` = ?";
        return $this->db->prepare($sql)->execute([$field->getLabel(), $field->getType(), $field->getSectionId()])->getAffectedRows();
    }

    /**
     * @return ExternalSectionFieldRepository
     */
    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new \Cms\Repositories\ExternalSectionFieldRepository();
        }
        return self::$instance;
    }
}