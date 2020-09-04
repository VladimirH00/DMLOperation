<?php


namespace VladimirH00\SqlDml;

require_once "./interface/SqlBaseInterface.php";
require_once "./interface/SqlInsertInterface.php";

use VladimirH00\SqlDml\SqlBaseInterface as SqlBaseInterface;
use VladimirH00\SqlDml\SqlInsertInterface as SqlInsertInterface;

use InvalidArgumentException;

/**
 * Классдля сборки и получения Insert заброса к MySql
 * Class MySqlInsert
 * @package VladimirH00\SqlDml
 */
class MySqlInsert implements SqlBaseInterface, SqlInsertInterface
{
    /**
     * @var string - содерждит название таблицы
     */
    private $table;
    /**
     * @var string - содержит данные которые будут добавленны в БД
     */
    private $values;

    /**
     * @inheritDoc
     */
    public function from($table)
    {
        if (is_array($table)) {
            foreach ($table as $item => $value) {
                if (is_array($value)) {
                    $str = "";
                    $index = 0;
                    $len = count($value);
                    foreach ($value as $column) {
                        $str .= "`{$column}`" . (++$index == $len ? "" : ",");
                    }
                    $this->table = "`{$item}` ({$str})";
                } else {
                    $this->table = "`{$value}`";
                }
            }
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
        if (is_null($this->values) || is_null($this->table)) {
            throw InvalidArgumentException("All the necessary data was not transmitted.");
        }
        return "INSERT INTO {$this->table} VALUES {$this->values} ;";
    }

    /**
     * @inheritDoc
     */
    public function values($columns)
    {
        if (is_array($columns)) {
            $idxClm = 0;
            $lenClm = count($columns);
            foreach ($columns as $column) {
                $str = "";
                $idxVl = 0;
                $lenVl = count($column);
                foreach ($column as $value) {
                    $str .= "{$value}" . (++$idxVl == $lenVl ? "" : ",");
                }
                $this->values .= "({$str})" . (++$idxClm == $lenClm ? "" : ",");
            }
        } else {
            $this->values = $columns;
        }
        return $this;
    }
}