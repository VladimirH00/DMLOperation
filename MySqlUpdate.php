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

class MySqlUpdate implements SqlUpdateInterface, SqlBaseInterface, SqlWhereInterface
{
    use WhereTrait;
    private $table;
    private $where;
    private $set;

    /**
     * @inheritDoc
     */
    public function from($table)
    {
        if (is_array($table)) {
            $this->table = $table[0];
        } else {
            $this->table = $table;
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
            foreach ($columns as $item => $value) {
                $this->set .= "{$item} = $value" . (++$index == $len ? "" : ",");
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