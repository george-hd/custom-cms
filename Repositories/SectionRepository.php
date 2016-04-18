<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 21.2.2016 г.
 * Time: 13:10
 */

namespace Cms\Repositories;

use \Cms\Database as db;
class SectionRepository
{
    private static $instance = null;
    private $db = null;

    private function __construct()
    {
        $this->db = new db();
    }

    /**
     * @param \Cms\Models\SectionModel $section
     * @return mixed
     */
    public function createSection(\Cms\Models\SectionModel $section) {
        $sql = 'CALL addSection(?, ?, ?, ?, ?)';
        $result = $this->db->prepare($sql)->execute([
            $section->getKey(),
            $section->getTitle(),
            $section->getBody(),
            $section->getDescription(),
            $section->getCategoryKey()
        ])->getAffectedRows();
        return $result;
    }

    /**
     * @param $language
     * @return mixed
     */
    public function getAllSections(\Cms\Models\LanguageModel $language, $filter = null) {
        if($filter) {
            $sql = "SELECT
                sec.id as id,
                sec.key as `key`,
                sec.title as title,
                lang.key as `language`,
                cat.value as `category`,
                sec.visibility as visibility
                FROM sections sec
                LEFT JOIN languages lang
                ON (sec.language_key = lang.key)
                LEFT JOIN categories cat
                ON (sec.category_key = cat.key)
                WHERE lang.parent_key = lang.key
                AND sec.language_key = ?
                AND lang.key = lang.parent_key
                AND cat.language_key = lang.key
                AND cat.key = ?";
            $params = [$language->getKey(), $filter];
        } else {
            $sql = "SELECT
                sec.id as id,
                sec.key as `key`,
                sec.title as title,
                lang.key as `language`,
                cat.value as `category`,
                sec.visibility as visibility
                FROM sections sec
                LEFT JOIN languages lang
                ON (sec.language_key = lang.key)
                LEFT JOIN categories cat
                ON (sec.category_key = cat.key)
                WHERE lang.parent_key = lang.key
                AND sec.language_key = ?
                AND cat.language_key = lang.key";
            $params = [$language->getKey()];
        }
        $result = $this->db->prepare($sql)->execute($params)->fetchAllAssoc();
        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getSectionById($id) {
        $sql = "SELECT * FROM sections WHERE `id` = ?";
        return $this->db->prepare($sql)->execute([\Cms\Common::normalize($id, 'trim, int, xss')])->fetchRowAssoc();
    }

    /**
     * @param \Cms\Models\SectionModel $model
     * @param $oldCat
     * @return mixed
     */
    public function updateSection(\Cms\Models\SectionModel $model, $oldCat) {
        $sql = "UPDATE sections SET `title` = ?, `body` = ?, `short_desc` = ? WHERE `id` = ?";
        $updatedSection = $this->db->prepare($sql)->execute([
            $model->getTitle(),
            $model->getBody(),
            $model->getDescription(),
            $model->getId()
        ])->getAffectedRows();
        $updatedSecCats = $this->updateSectionCategory($oldCat, $model->getCategoryKey());

        return $updatedSection + $updatedSecCats;
    }

    /**
     * @param \Cms\Models\SectionModel $section
     * @return mixed
     */
    public function updateSectionVisibility(\Cms\Models\SectionModel $section) {
        $sql = "UPDATE sections SET `visibility` = ? WHERE `id` = ?";
        return $this->db->prepare($sql)->execute([$section->getVisibility(), $section->getId()])->getAffectedRows();
    }

    /**
     * @param $oldCat
     * @param $newCat
     * @return mixed
     */
    private function updateSectionCategory($oldCat, $newCat) {
        $sql = "UPDATE sections SET `category_key` = ? WHERE `category_key` = ?";
        return $this->db->prepare($sql)->execute([$newCat, $oldCat])->getAffectedRows();
    }

    public function deleteSection(\Cms\Models\SectionModel $section) {
        $sql = "DELETE FROM sections WHERE `key` = ?";
        return $this->db->prepare($sql)->execute([$section->getKey()])->getAffectedRows();
    }

    /**
     * @return SectionRepository
     */
    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new \Cms\Repositories\SectionRepository();
        }
        return self::$instance;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getSectionByKeyAndLanguage($key) {
        $sql = "SELECT * FROM sections WHERE `key` = ? AND `language_key` = ? AND visibility = '1'";
        $result = $this->db->prepare($sql)->execute([$key, \Cms\App::getInstance()->getAppLanguage()['key']])->fetchRowObj();
        return new \Cms\Models\SectionModel(
            $result->id,
            $result->key,
            $result->title,
            $result->body,
            $result->short_desc,
            $result->language_key,
            $result->category_key,
            $result->visibility
        );
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getSectionsByKey($key) {
        $sql = "SELECT * FROM sections WHERE `key` = ?";
        return $this->db->prepare($sql)->execute([$key])->fetchAllAssoc();
    }

    /**
     * @param \Cms\Models\SectionModel $section
     * @return mixed
     */
    public function getSectionResources(\Cms\Models\SectionModel $section) {
        return \Cms\Models\ResourceModel::getResourcesBySection($section);
    }
}