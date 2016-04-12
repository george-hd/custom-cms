<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 13.12.2015 г.
 * Time: 13:13
 */

namespace Cms\Repositories;
use \Cms\Database as db;
use \Cms\Models\LangVarModel;

class SiteVarRepository
{
    /**
     * @var \Cms\Repositories\SiteVarRepository
     */
    private static $instance = null;
    /**
     * @var \Cms\Database
     */
    private $db = null;


    /**
     * SiteVarRepository constructor.
     */
    private function __construct()
    {
        $this->db = new db();
    }

    /**
     * @param \Cms\Models\SiteVarModel $model
     * @return mixed
     */
    public function createSiteVar(\Cms\Models\SiteVarModel $model)
    {
        $sql = "CALL addSiteVar(?, ?, ?)";
        $result = $this->db->prepare($sql)
            ->execute([
                $model->getKey(),
                $model->getValue(),
                $model->getCategoryKey()
            ]);
        return $result->getAffectedRows();
    }

    public function getsv($key, $language) {
        $sql = "SELECT `value` FROM site_vars WHERE `key` = ? AND language_key = ?";
        $result =  $this->db->prepare($sql)->execute([$key, $language['key']])->fetchRowAssoc();
        return $result;
    }

    /**
     * @param \Cms\Models\LanguageModel $language
     * @param null $categoryFilter
     * @return mixed
     */
    public function getAllSiteVars(\Cms\Models\LanguageModel $language, $categoryFilter = null) {
        if($categoryFilter) {
            $sql = "SELECT
                sv.id as `id`,
                sv.key as `key`,
                sv.value as `value`,
                lang.value as language_key,
                cat.value as category_key
                FROM site_vars sv
                LEFT JOIN languages lang
                ON (sv.language_key = lang.key)
                LEFT JOIN categories cat
                ON (sv.category_key = cat.key)
                WHERE lang.key = lang.parent_key
                AND cat.language_key = lang.key
                AND sv.language_key = lang.key
                AND lang.key = ?
                AND sv.category_key = ?";
            $params = [$language->getKey(), $categoryFilter];
        } else {
            $sql = "SELECT
                sv.id as `id`,
                sv.key as `key`,
                sv.value as `value`,
                lang.value as language_key,
                cat.value as category_key
                FROM site_vars sv
                LEFT JOIN languages lang
                ON (sv.language_key = lang.key)
                LEFT JOIN categories cat
                ON (sv.category_key = cat.key)
                WHERE lang.key = lang.parent_key
                AND cat.language_key = lang.key
                AND sv.language_key = lang.key
                AND lang.key = ?";
            $params = [$language->getKey()];
        }
        $result = $this->db->prepare($sql)->execute($params)->fetchAllAssoc();
        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getSiteVarById($id) {
        $sql = "SELECT * FROM site_vars WHERE id = ?";
        return $this->db->prepare($sql)->execute([$id])->fetchRowAssoc();
    }

    /**
     * @param \Cms\Models\SiteVarModel $model
     * @return mixed
     */
    public function updateSiteVar(\Cms\Models\SiteVarModel $model) {
        $sql = "UPDATE site_vars SET `value` = ? WHERE `id` = ?";
        $result = $this->db->prepare($sql)->execute([$model->getValue(), $model->getId()])->getAffectedRows();
        return $result;
    }

    /**
     * @param \Cms\Models\SiteVarModel $model
     * @return mixed
     */
    public function updateSiteVarCategory(\Cms\Models\SiteVarModel $model) {
        $sql = "UPDATE site_vars SET category_key = ? WHERE `key` = ?";
        $result = $this->db->prepare($sql)->execute([$model->getCategoryKey(), $model->getKey()])->getAffectedRows();
        return $result;
    }

    /**
     * @param \Cms\Models\SiteVarModel $model
     * @return mixed
     */
    public function deleteSiteVar(\Cms\Models\SiteVarModel $model) {
        $sql = "DELETE FROM site_vars WHERE `key` = ?";
        return $this->db->prepare($sql)->execute([$model->getKey()])->getAffectedRows();
    }

    /**
     * @return \Cms\Repositories\SiteVarRepository
     */
    public static function getInstance()
    {
        if(!self::$instance) {
            self::$instance = new SiteVarRepository();
        }
        return self::$instance;
    }
}