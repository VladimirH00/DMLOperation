<?php


namespace VladimirH00\ConstructSqlQuery;

require_once "SqlQueryOffsetable.php";
require_once "SqlQueryLimitable.php";
require_once "SqlQuery.php";


use VladimirH00\ConstructSqlQuery\SqlQuery as SqlQuery;
use VladimirH00\ConstructSqlQuery\SqlQueryLimitable as SqlQueryLimitable;
use VladimirH00\ConstructSqlQuery\SqlQueryOffsetable as SqlQueryOffsetable;

use InvalidArgumentException;

class MySqlQuery implements SqlQuery, SqlQueryLimitable, SqlQueryOffsetable
{

    private $select;
    private $limit;
    private $from;
    private $where;
    private $offset;
    private $orderBy;
    private $groupBy;

    private function anyWhere($condition)
    {
        if (array_keys($condition) !== range(0, count($condition) - 1)) {
            $keys = array_keys($condition);
            $this->where .= "{$keys[0]} = {$condition[$keys[0]]}";
        } else {
            if (strcasecmp($condition[0], "in") == 0 || strcasecmp($condition[0], "not in") == 0) {
                $this->where .= "{$condition[1]} {$condition[0]} ( ";
                foreach ($condition[2] as $value) {
                    $this->where .= "{$value}, ";
                }
                $this->where = substr($this->where, 0, strlen($this->where) - 2) . ")";
            } else {
                $this->where .= "{$condition[1]} {$condition[0]} {$condition[2]}";
            }
        }
    }

    public function select($columns = array("*"))
    {
        if (is_array($columns)) {
            foreach ($columns as $column) {
                if (is_array($column)) {
                    foreach ($column as $item => $value) {
                        $this->select .= "{$item} as {$value}";
                    }
                } else {
                    $this->select .= "{$column}";
                }
                $this->select .= ", ";
            }
            $this->select = substr($this->select, 0, strlen($this->select) - 2);
        } else {
            $this->select = $columns;
        }
        return $this;
    }

    public function from($tableName)
    {
        if (is_array($tableName)) {
            foreach ($tableName as $item => $value) {
                $this->from = "`{$item}` as {$value}";
            }
        } else {
            $this->from = $tableName;
        }
        return $this;
    }

    public function andWhere($condition)
    {
        if (!is_array($condition)) {
            throw new InvalidArgumentException("Not array.");
        }
        if (empty($condition)) {
            throw new InvalidArgumentException("Invalid argument.");
        }
        if (!is_null($this->where)) {
            $this->where .= " AND ";
        }

        $this->anyWhere($condition);
        return $this;
    }

    public function orWhere($condition)
    {
        if (!is_array($condition)) {
            throw new InvalidArgumentException("Not array.");
        }
        if (empty($condition)) {
            throw new InvalidArgumentException("Invalid argument.");
        }
        if (!is_null($this->where)) {
            $this->where .= " OR ";
        }

        $this->anyWhere($condition);
        return $this;
    }

    private function anyBy($columns)
    {
        $str = "";
        foreach ($columns as $column) {
            if (!is_array($column)) {
                throw new InvalidArgumentException("Invalid argument.");
            }
            foreach ($column as $value) {
                $str .= " {$value}";
            }
            $str .= ",";
        }
        return substr($str, 0, strlen($str) - 1);
    }

    public function orderBy($columns)
    {
        if (!is_array($columns)) {
            throw new InvalidArgumentException("Not array.");
        }
        if (empty($columns)) {
            throw new InvalidArgumentException("Invalid argument.");
        }

        $this->orderBy = $this->anyBy($columns);
        return $this;
    }

    public function groupBy($columns)
    {
        if (!is_array($columns)) {
            throw new InvalidArgumentException("Not array.");
        }
        if (empty($columns)) {
            throw new InvalidArgumentException("Invalid argument.");
        }
        $this->groupBy = $this->anyBy($columns);
        return $this;
    }

    public function getRaw()
    {
        if (empty($this->select) || empty($this->from) || empty($this->limit)) {
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
        $query .= " LIMIT {$this->limit}";
        if (!empty($this->offset)) {
            $query .= " OFFSET {$this->offset}";
        }
        return $query;
    }

    public function limit($limit)
    {
        if (!is_int($limit)) {
            throw  new InvalidArgumentException("Invalid argument.");
        }
        $this->limit = $limit;
        return $this;
    }

    public function offset($offset)
    {
        if (!is_int($offset)) {
            throw  new InvalidArgumentException("Invalid argument.");
        }
        $this->offset = $offset;
        return $this;
    }
}