<?php


namespace VladimirH00\DMLOperation;

require_once "./interfaces/SqlBaseInterface.php";
require_once "./interfaces/SqlSelectInterface.php";
require_once "./interfaces/SqlLimitableInterface.php";
require_once "./interfaces/SqlOffsetableInterface.php";
require_once "AbstractWhere.php";

use VladimirH00\DMLOperation\AbstractWhere as AbstractWhere;
use VladimirH00\DMLOperation\interfaces\SqlSelectInterface as SqlSelectInterface;
use VladimirH00\DMLOperation\interfaces\SqlBaseInterface as SqlBaseInterface;
use VladimirH00\DMLOperation\interfaces\SqlLimitableInterface as SqlLimitableInterface;
use VladimirH00\DMLOperation\interfaces\SqlOffsetableInterface as SqlOffsetableInterface;


use InvalidArgumentException;


/**
 * Класс для получения готового Select запроса к Mysql
 * Class MySqlSelect
 * @package VladimirH00\SqlDml
 */
class MySqlSelect extends AbstractWhere implements SqlSelectInterface, SqlBaseInterface, SqlLimitableInterface, SqlOffsetableInterface
{
    /**
     * @var string содержит поля выборки
     */
    private $select;

    /**
     * @var int - содержит количество выводимых данных
     */
    private $limit;

    /**
     * @var string - содержит название таблицы
     */
    private $from;

    /**
     * @var int - содержит сдвиг по выводымим данным
     */
    private $offset;

    /**
     * @var string - содержит параметры сордировки запроса
     */
    private $orderBy;

    /**
     * @var string - содержит параметры группировки данных запроса
     */
    private $groupBy;
    /**
     * @var string
     */
    private $join;

    /**
     * @param $columns
     * @return string
     */
    private function by($columns)
    {
        $str = "";
        $index = 0;
        $len = count($columns);
        foreach ($columns as $column) {
            $str .= "`{$column}`" . (++$index == $len ? "" : ",");
        }
        return $str;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limit($limit)
    {
        if (!is_int($limit)) {
            throw InvalidArgumentException("Not integer.");
        }
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function offset($offset)
    {
        if (!is_int($offset)) {
            throw  new InvalidArgumentException("Invalid argument.");
        }
        $this->offset = $offset;
        return $this;
    }

    /**
     * @param array $columns
     * @return $this|object
     */
    public function select($columns = "*")
    {
        if (is_array($columns)) {
            $idx = 0;
            $len = count($columns);
            foreach ($columns as $column => $value) {
                if (is_array($value)) {
                    foreach ($value as $id => $item) {
                        $this->select .= "`{$column}`.`{$id}` as `{$item}`";
                    }
                } else {
                    $this->select .= "`{$column}`.`{$value}`";
                }
                $this->select .= (++$idx == $len ? "" : ",");
            }
        } else {
            $this->select = $columns;
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function orderBy($columns)
    {
        if (!is_array($columns)) {
            throw new InvalidArgumentException("Columns is not an array.");
        }
        if (empty($columns)) {
            throw new InvalidArgumentException("The passed array cannot be empty.");
        }

        $this->orderBy = $this->by($columns);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function groupBy($columns)
    {
        if (!is_array($columns)) {
            throw new InvalidArgumentException("Columns is not an array.");
        }
        if (empty($columns)) {
            throw new InvalidArgumentException("The passed array cannot be empty.");
        }
        $this->groupBy = $this->by($columns);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function from($tables)
    {
        if (is_array($tables)) {
            foreach ($tables as $table) {
                $index = 0;
                $len = count($table);
                if (is_array($table)) {
                    foreach ($table as $item => $value) {
                        $this->from .= "`{$item}` as `{$value}`" . (++$index == $len ? "" : ",");
                    }
                } else {
                    $this->from .= "`{$table}`" . (++$index == $len ? "" : ",");
                }
            }
        } else {
            $this->from = $tables;
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRaw()
    {
        if (empty($this->select) || empty($this->from)) {
            throw new InvalidArgumentException("All the necessary data was not transmitted.");
        }
        $query = "SELECT {$this->select} FROM {$this->from}";
        if (!empty($this->join)){
            $query .= " {$this->join}";
        }
        if (!empty($this->where)) {
            $query .= " WHERE {$this->where}";
        }
        if (!empty($this->groupBy)) {
            $query .= " GROUP BY  {$this->groupBy}";
        }
        if (!empty($this->orderBy)) {
            $query .= " ORDER BY {$this->orderBy}";
        }
        if (!empty($this->limit)) {
            $query .= " LIMIT {$this->limit}";
        }
        if (!empty($this->offset)) {
            $query .= " OFFSET {$this->offset}";
        }
        return $query;
    }
    public function join($columns)
    {

        if(is_array($columns)){
            if(is_null($this->from)){
                throw new InvalidArgumentException("Property 'From' is empty.");
            }
            $this->join .= " {$columns[0]} `{$columns[1]}` ON {$this->from}.`{$columns[2]}` = `{$columns[1]}`.`{$columns[3]}`";
        }else{
            $this->join = $columns;
        }

        return $this;
    }


}