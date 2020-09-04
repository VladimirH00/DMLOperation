<?php


namespace VladimirH00\SqlDml;

require_once "./interface/SqlBaseInterface.php";
require_once "./interface/SqlSelectInterface.php";
require_once "./interface/SqlWhereInterface.php";
require_once "./interface/SqlLimitableInterface.php";
require_once "./interface/SqlOffsetableInterface.php";
require_once "./trait/WhereTrait.php";

use VladimirH00\SqlDml\SqlWhereInterface as SqlWhereInterface;
use VladimirH00\SqlDml\SqlSelectInterface as SqlSelectInterface;
use VladimirH00\SqlDml\SqlBaseInterface as SqlBaseInterface;
use VladimirH00\SqlDml\SqlLimitableInterface as SqlLimitableInterface;
use VladimirH00\SqlDml\SqlOffsetableInterface as SqlOffsetableInterface;


use InvalidArgumentException;

class MySqlSelect implements SqlSelectInterface, SqlBaseInterface, SqlWhereInterface, SqlLimitableInterface, SqlOffsetableInterface
{
    use WhereTrait;
    /**
     * @var string
     */
    private $select;
    /**
     * @var int
     */
    private $limit;
    /**
     * @var string
     */
    private $from;
    /**
     * @var string
     */
    private $where;
    /**
     * @var int
     */
    private $offset;
    /**
     * @var string
     */
    private $orderBy;
    /**
     * @var string
     */
    private $groupBy;

    /**
     * @param $columns
     * @return string
     */
    private function By($columns)
    {
        $str = "";
        $index = 0;
        $len = count($columns);
        foreach ($columns as $column) {
            $str .= $column . (++$index == $len ? "" : ",");
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

    public function select($columns = array("*"))
    {
        if (is_array($columns)) {
            $idx = 0;
            $len = count($columns);
            foreach ($columns as $column) {
                if (is_array($column)) {
                    foreach ($column as $item => $value) {
                        $this->select .= "{$item} as {$value}";
                    }
                } else {
                    $this->select .= $column;
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

        $this->orderBy = $this->By($columns);
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
        $this->groupBy = $this->By($columns);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function from($table)
    {
        if (is_array($table)) {
            foreach ($table as $item => $value) {
                $this->from = "`{$item}` as `{$value}`";
            }
        } else {
            $this->from = $table;
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
        $this->where .= $this->where($condition);

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
        $this->where .= $this->where($condition);

        return $this;
    }

}