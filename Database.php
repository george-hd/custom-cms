<?php

/**
 * Created by bro555555.
 * User: George
 * Date: 18.11.2015 г.
 * Time: 20:21
 */

namespace Cms;


class Database
{
    protected $connection = null;
    private $stmt = null;
    private $params = array();
    private $sql = '';

    public function __construct($connection = 'default')
    {
        $this->connection = \Cms\App::getInstance()->getDbConnection($connection);
        $this->connection->exec("SET NAMES utf8");
    }

    public function prepare($sql, $params = array(), $pdoOptions = array())
    {
        $this->stmt = $this->connection->prepare($sql, $pdoOptions);
        $this->params = $params;
        $this->sql = $sql;
        return $this;
    }

    public function execute($params = array())
    {
        if ($params) {
            $this->params = $params;
        }
        $this->stmt->execute($this->params);
        return $this;
    }

    public function fetchAllAssoc() {
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function fetchRowAssoc() {
        return $this->stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function fetchAllNum() {
        return $this->stmt->fetchAll(\PDO::FETCH_NUM);
    }

    public function fetchRowNum() {
        return $this->stmt->fetch(\PDO::FETCH_NUM);
    }

    public function fetchAllObj() {
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function fetchRowObj() {
        return $this->stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function fetchAllColumn($column) {
        return $this->stmt->fetchAll(\PDO::FETCH_COLUMN, $column);
    }

    public function fetchRowColumn($column) {
        return $this->stmt->fetch(\PDO::FETCH_BOUND, $column);
    }

    public function fetchAllClass($class) {
        return $this->stmt->fetchAll(\PDO::FETCH_CLASS, $class);
    }

    public function fetchRowClass($class) {
        return $this->stmt->fetch(\PDO::FETCH_BOUND, $class);
    }

    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }

    public function getAffectedRows() {
        return $this->stmt->rowCount();
    }

    public function getSTMT() {
        return $this->stmt;
    }

    public function fetchObject($class = null)
    {
        return $this->stmt->fetchObject($class);
    }
}