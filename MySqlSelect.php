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
            $this->select ="";
            $idx = 0;
            $len = count($columns);
            foreach ($columns as $column => $value) {
                $this->select .= $value;
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
            $index = 0;
            $len = count($tables);
            foreach ($tables as $item => $value) {
                $this->from .= "`{$item}` as `{$value}`" . (++$index == $len ? "" : ",");
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
    public function leftJoin($table1, $values)
    {

        if(!is_array($values)) {
            throw new InvalidArgumentException("Second arguments is not array.");
        }
        if(is_array($table1)){
            foreach ($table1 as $item => $value){
                $this->join = " LEFT JOIN {$item} as {$value} ";
            }
        }else{
            $this->join = " LEFT JOIN {$table1}";
        }
        foreach ($values as $item => $value){
            $this->join .= " ON `{$item}` = {$value}`";
        }

        return $this;
    }
    public function innerJoin($table1, $values)
    {

        if(!is_array($values)) {
            throw new InvalidArgumentException("Second arguments is not array.");
        }
        if(is_array($table1)){
            foreach ($table1 as $item => $value){
                $this->join = " INNER JOIN {$item} as {$value} ";
            }
        }else{
            $this->join = " INNER JOIN {$table1}";
        }
        foreach ($values as $item => $value){
            $this->join .= " ON `{$item}` = {$value}`";
        }

        return $this;
    }
    public function rightJoin($table1, $values)
    {

        if(!is_array($values)) {
            throw new InvalidArgumentException("Second arguments is not array.");
        }
        if(is_array($table1)){
            foreach ($table1 as $item => $value){
                $this->join = " RIGHT JOIN {$item} as {$value} ";
            }
        }else{
            $this->join = " RIGHT JOIN {$table1}";
        }
        foreach ($values as $item => $value){
            $this->join .= " ON `{$item}` = {$value}`";
        }

        return $this;
    }


}