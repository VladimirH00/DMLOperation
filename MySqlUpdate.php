<?php


namespace VladimirH00\SqlDml;


require_once "./interface/SqlBaseInterface.php";
require_once "./interface/SqlUpdateInterface.php";
require_once "./interface/SqlWhereInterface.php";
require_once "./trait/WhereTrait.php";

use VladimirH00\SqlDml\SqlBaseInterface as SqlBaseInterface;
use VladimirH00\SqlDml\SqlWhereInterface as SqlWhereInterface;
use VladimirH00\SqlDml\SqlUpdateInterface as SqlUpdateInterface;
use InvalidArgumentException;

/**
 * Класс для получения готового Update запроса к Mysql
 * Class MySqlUpdate
 * @package VladimirH00\SqlDml
 */
class MySqlUpdate implements SqlUpdateInterface, SqlBaseInterface, SqlWhereInterface
{
    use WhereTrait;
    /**
     * @var string - содержит название таблицы
     */
    private $table;
    /**
     * @var string - содержит ограничения по обновлению данных
     */
    private $where;
    /**
     * @var string - содержит строку замены старых данных на новые
     */
    private $set;

    /**
     * @inheritDoc
     */
    public function from($tables)
    {
        if (is_array($tables)) {
            $index = 0;
            $len = count($tables);
            foreach ($tables as $table) {
                if (is_array($table)) {
                    foreach ($table as $item => $value) {
                        $this->table .= "`{$item}`.`{$value}`" . (++$index == $len ? "" : ",");
                    }
                } else {
                     $this->table .= "`{$table}`" . (++$index == $len ? "" : ",");
                }
            }
        } else {
            $this->table = $tables;
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRaw()
    {
        if (is_null($this->table) || is_null($this->where) || is_null($this->set)) {
            throw new InvalidArgumentException("All the necessary data was not transmitted.");
        }
        return "UPDATE {$this->table} SET {$this->set} WHERE {$this->where}";
    }

    /**
     * @inheritDoc
     */
    public function set($columns)
    {
        if (is_array($columns)) {
            $index = 0;
            $len = count($columns);
            foreach ($columns as $value) {
                $this->set .= "`{$value[0]}`.`$value[1]` = {$value[2]}" . (++$index == $len ? "" : ",");
            }
        } else {
            $this->set = $columns;
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function andWhere($condition)
    {
        if (!is_array($condition)) {
            throw new InvalidArgumentException("Condition is not an array.");
        }
        if (empty($condition)) {
            throw new InvalidArgumentException("The passed array cannot be empty.");
        }
        if (!is_null($this->where)) {
            $this->where .= " AND ";
        }
        $this->where = $this->where($condition);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function orWhere($condition)
    {
        if (!is_array($condition)) {
            throw new InvalidArgumentException("Condition is not an array.");
        }
        if (empty($condition)) {
            throw new InvalidArgumentException("The passed array cannot be empty.");
        }
        if (!is_null($this->where)) {
            $this->where .= " OR ";
        }
        $this->where = $this->where($condition);

        return $this;
    }
}