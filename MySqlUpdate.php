<?php


namespace VladimirH00\DMLOperation;


require_once "./interfaces/SqlBaseInterface.php";
require_once "./interfaces/SqlUpdateInterface.php";
require_once "AbstractWhere.php";


use VladimirH00\DMLOperation\interfaces\SqlBaseInterface as SqlBaseInterface;
use VladimirH00\DMLOperation\AbstractWhere as AbstractWhere;
use VladimirH00\DMLOperation\interfaces\SqlUpdateInterface as SqlUpdateInterface;
use InvalidArgumentException;

/**
 * Класс для получения готового Update запроса к Mysql
 * Class MySqlUpdate
 * @package VladimirH00\SqlDml
 */
class MySqlUpdate extends AbstractWhere implements SqlUpdateInterface, SqlBaseInterface
{

    /**
     * @var string - содержит название таблицы
     */
    private $table;

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

}