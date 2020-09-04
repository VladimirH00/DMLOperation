<?php


namespace VladimirH00\SqlDml;

require_once "./trait/WhereTrait.php";
require_once "./interface/SqlWhereInterface.php";
require_once "./interface/SqlBaseInterface.php";

use VladimirH00\SqlDml\SqlBaseInterface as SqlBaseInterface;
use VladimirH00\SqlDml\SqlWhereInterface as SqlWhereInterface;


use InvalidArgumentException;

/**
 * Класс для составления Delete запроса к MySql
 * Class MySqlDelete
 * @package VladimirH00\SqlDml
 */

class MySqlDelete implements SqlBaseInterface, SqlWhereInterface
{

    use WhereTrait;
    /**
     * @var string -содержит название таблицы
     */
    private $table;
    /**
     * @var string - содержит определенные параметры для удаления данных
     */
    private $where;

    /**
     * @inheritDoc
     */
    public function from($table)
    {
        if (is_array($table)) {
            $this->table = "`{$table[0]}`";
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
        if (is_null($this->table)) {
            throw new InvalidArgumentException("All the necessary data was not transmitted.");
        }
        $str = "DELETE FROM {$this->table}";
        if (is_null($this->where)) {
            return $str;
        } else {
            return "{$str} WHERE {$this->where}";
        }
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