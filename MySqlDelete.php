<?php


namespace VladimirH00\DMLOperation;


require_once "AbstractWhere.php";
require_once "./interfaces/SqlBaseInterface.php";

use VladimirH00\DMLOperation\interfaces\SqlBaseInterface as SqlBaseInterface;
use VladimirH00\DMLOperation\AbstractWhere as AbstractWhere;


use InvalidArgumentException;

/**
 * Класс для составления Delete запроса к MySql
 * Class MySqlDelete
 * @package VladimirH00\SqlDml
 */
class MySqlDelete extends AbstractWhere implements SqlBaseInterface
{


    /**
     * @var string -содержит название таблицы
     */
    private $table;

    /**
     * @inheritDoc
     */
    public function from($tables)
    {
        if (is_array($tables)) {
            $index = 0;
            $len = count($tables);
            foreach ($tables as $table) {
                $this->table .= $table . (++$index == $len ? "" : ",");
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


}