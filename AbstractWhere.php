<?php


namespace VladimirH00\DMLOperation;


require_once "./interfaces/SqlWhereInterface.php";

use VladimirH00\DMLOperation\interfaces\SqlWhereInterface as SqlWhereInterface;

abstract class AbstractWhere implements SqlWhereInterface
{
    /**
     * @var string - содержит  строку ограничений по выборке данных
     */
    protected $where;

    /**
     * @param $condition
     * @return string
     */
    public function where($condition)
    {
        $condition[0] = strtoupper($condition[0]);
        $index = 0;
        $len = count($condition[2]);
        $str = "";
        if ($condition[0] == "IN" || $condition[0] == "NOT IN") {
            $str .= "`{$condition[1][0]}`.`{$condition[1][1]}` {$condition[0]} ( ";
            foreach ($condition[2] as $value) {
                $str .= "{$value}" . (++$index == $len ? "" : ",");
            }
            $str .= ")";
        } else {
            $str = "`{$condition[1][0]}`.`{$condition[1][1]}` {$condition[0]} {$condition[2]}";
        }
        return $str;
    }

    /**
     * @param array
     * @return object
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
     * @param array
     * @return object
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