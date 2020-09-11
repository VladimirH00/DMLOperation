<?php


namespace VladimirH00\DMLOperation;

require_once "./interfaces/SqlInsertInterface.php";

use VladimirH00\DMLOperation\interfaces\SqlInsertInterface as SqlInsertInterface;

use InvalidArgumentException;


/**
 * Классдля сборки и получения Insert заброса к MySql
 * Class MySqlInsert
 * @package VladimirH00\SqlDml
 */
class MySqlInsert implements SqlInsertInterface
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
     * @param $columns
     * @param $table
     * @return object|void
     */
    public function insert($columns, $table)
    {
        if(is_array($table)){
            foreach ($table as $item => $value){
                $this->table = "`{$item}` as `{$value}`";
            }
        }else{
            $this->table = $table;
        }
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

}