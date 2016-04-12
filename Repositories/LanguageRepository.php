<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 13.12.2015 г.
 * Time: 15:55
 */

namespace Cms\Repositories;
use \Cms\Database as db;


class LanguageRepository
{
    private static $instance = null;
    private $db = null;

    private function __construct()
    {
        $this->db = new db();
    }

    /**
     * @return mixed
     */
    public function getCountLanguages()
    {
        $sql = "SELECT count(*) FROM languages";
        $result = $this->db->prepare($sql)
            ->execute()
            ->fetchRowNum();
        return $result[0];
    }

    /**
     * @param \Cms\Models\LanguageModel $model
     * @param $oldKey
     * @return int
     */
    public function updateLanguage(\Cms\Models\LanguageModel $model, $oldKey) {
        //TODO Have to be in transaction!!!!!!!!!
        if($model->getKey() != $oldKey) {
            $langKeyResult = $this->updateLangKey($oldKey, $model->getKey());
        }
        $sql = "UPDATE languages SET `value` = ? WHERE `id` = ?";
        $langValResult =  $this->db->prepare($sql)->execute([$model->getValue(), $model->getId()])->getAffectedRows();
        return ($langKeyResult > 0 || $langValResult > 0 ? 1 : 0);
    }

    private function updateLangKey($oldKey, $newKey) {
        $sql = "UPDATE languages SET `key` = ? WHERE `key` = ?;
            UPDATE languages SET `parent_key` = ? WHERE `parent_key` = ?";
        $result = $this->db->prepare($sql)->execute([$newKey, $oldKey, $newKey, $oldKey])->getAffectedRows();
        return $result;
    }

    /**
     * @param \Cms\Models\LanguageModel $model
     * @return mixed
     */
    public function addLanguage(\Cms\Models\LanguageModel $model) {
        $sql = "call addLanguage(?, ?)";
        $result = $this->db->prepare($sql)->execute([$model->getKey(), $model->getValue()])->getAffectedRows();
        return $result;
    }

    /**
     * @return mixed
     */
    public function getDefaultSiteLang() {
        $sql = "SELECT * FROM languages LIMIT 0,1";
        $result = $this->db->prepare($sql)->execute([])->fetchRowAssoc();
        return $result;
    }

    /**
     * @return mixed
     */
    public function getLangKeys() {
        $sql = "SELECT DISTINCT `key` FROM languages";
        $result = $this->db->prepare($sql)->execute([])->fetchAllAssoc();
        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getLanguageById($id)
    {
        $sql = "SELECT `id`, `key`, `value` FROM languages WHERE `id` = ?";
        $result = $this->db->prepare($sql)->execute([$id])->fetchRowAssoc();
        return $result;
    }

    /**
     * @param $key
     * @param $parentKey
     * @return mixed
     */
    public function getLanguageByKeyAndParent($key, $parentKey) {
        $sql = "SELECT * FROM languages WHERE `key` = ? AND parent_key = ?";
        $result = $this->db->prepare($sql)->execute([$key, $parentKey])->fetchRowAssoc();
        return $result;
    }

    /**
     * @param \Cms\Models\LanguageModel $language
     * @return mixed
     */
    public function getAllLanguages(\Cms\Models\LanguageModel $language)
    {
        $sql = "SELECT `id`, `key`, `value`, `parent_key` FROM languages WHERE `parent_key` = ? ORDER BY `key`";
        $result = $this->db->prepare($sql)->execute([$language->getKey()])->fetchAllAssoc();
        return $result;
    }

    /**
     * @param \Cms\Models\LanguageModel $model
     * @return mixed
     */
    public function deleteLanguage(\Cms\Models\LanguageModel $model)
    {
        $sql = "DELETE FROM languages WHERE `key` = ?;
            DELETE FROM languages WHERE `parent_key` = ?;
            DELETE FROM site_vars WHERE `language_key` = ?;
            DELETE FROM categories WHERE `language_key` = ?;";
        $result = $this->db->prepare($sql)->execute([
            $model->getKey(),
            $model->getKey(),
            $model->getKey(),
            $model->getKey(),
        ])->getAffectedRows();
        return $result;
    }

    public static function getInstance()
    {
        if(self::$instance === null) {
            self::$instance = new \Cms\Repositories\LanguageRepository();
        }
        return self::$instance;
    }
}