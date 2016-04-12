<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 14.2.2016 г.
 * Time: 10:59
 */

namespace Cms\Repositories;

use \Cms\Database as db;
class CategoryRepository
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
    public function getCountCategories()
    {
        $sql = "SELECT count(*) FROM categories";
        $result = $this->db->prepare($sql)
            ->execute()
            ->fetchRowNum();
        return $result[0];
    }

    /**
     * @param \Cms\Models\CategoryModel $model
     * @return mixed
     */
    public function createCategory(\Cms\Models\CategoryModel $model) {
        $sql = 'INSERT INTO categories (`key`, `value`, `language_key`, `parent_key`) VALUES(?, ?, ?, ?)';
        $result = $this->db->prepare($sql)
            ->execute([
                    $model->getKey(),
                    $model->getValue(),
                    $model->getLanguageKey(),
                    $model->getParentKey()
                ])->getAffectedRows();
        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCategoryById($id) {
        $sql = "SELECT * FROM categories WHERE id = ?";
        $result = $this->db->prepare($sql)->execute([$id])->fetchRowAssoc();
        return $result;
    }

    /**
     * @param \Cms\Models\LanguageModel $language
     * @param $categoryKey
     * @return mixed
     */
    public function getCategoryByKeyAndLanguage(\Cms\Models\LanguageModel $language, $categoryKey) {
        $sql = "SELECT * FROM categories WHERE language_key = ? AND `key` = ?";
        $result = $this->db->prepare($sql)->execute([$language->getKey(), $categoryKey])->fetchRowAssoc();
        return $result;
    }

    /**
     * @param \Cms\Models\LanguageModel $language
     * @param null $categoryFilter
     * @return mixed
     */
    public function getCategories(\Cms\Models\LanguageModel $language, $categoryFilter = null) {
        if($categoryFilter) {
            $sql = "SELECT
                cat.id as cat_id,
                cat.key as cat_key,
                cat.value as cat_val,
                lang.value as lang_val,
                parent.value as parent_val
                FROM categories cat
                LEFT JOIN languages lang
                ON (cat.language_key = lang.key)
                LEFT JOIN categories parent
                ON (cat.parent_key = parent.key)
                WHERE parent.language_key = cat.language_key
                AND lang.key = lang.parent_key
                AND cat.language_key = ?
                AND cat.parent_key = ?
                ORDER BY cat.parent_key";
            $params = [$language->getKey(), $categoryFilter];
        } else {
            $sql = "SELECT DISTINCT
                cat.id as cat_id,
                cat.key as cat_key,
                cat.value as cat_val,
                lang.value as lang_val,
                parent.value as parent_val
                FROM categories cat
                INNER JOIN languages lang
                ON (cat.language_key = lang.key)
                LEFT JOIN categories parent
                ON (parent.key = cat.parent_key OR parent.key IS NULL)
                WHERE lang.id = ?
                AND (parent.language_key = lang.key OR parent.language_key IS NULL)
                ORDER BY cat.parent_key";

            $params = [$language->getId()];
        }
        $result = $this->db->prepare($sql)->execute($params)->fetchAllAssoc();
        return $result;
    }

    /**
     * @param \Cms\Models\CategoryModel $model
     * @return mixed
     */
    public function updateCategory(\Cms\Models\CategoryModel $model) {
        $sql = "UPDATE categories SET `key` = ?, `value` = ? WHERE `id` = ?";
        $updatedCatRows = $this->db->prepare($sql)->execute([
            $model->getKey(),
            $model->getValue(),
            $model->getId()
        ])->getAffectedRows();
        $updateParentRows = $this->updateCategoryParent($model);
        return $updatedCatRows + $updateParentRows;
    }

    /**
     * @param \Cms\Models\CategoryModel $model
     * @return mixed
     */
    public function updateCategoryParent(\Cms\Models\CategoryModel $model) {
        $sql = "UPDATE categories SET `parent_key` = ? WHERE `key`= ?";
        $result = $this->db->prepare($sql)->execute([$model->getParentKey(), $model->getKey()])->getAffectedRows();
        return $result;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function deleteCategory($key) {
        $sql = "DELETE FROM categories WHERE `key` = ?";
        $result = $this->db->prepare($sql)->execute([$key])->getAffectedRows();
        return $result;
    }

    /**
     * @return CategoryRepository
     */
    public static function getInstance()
    {
        if(!self::$instance) {
            self::$instance = new CategoryRepository();
        }
        return self::$instance;
    }
}