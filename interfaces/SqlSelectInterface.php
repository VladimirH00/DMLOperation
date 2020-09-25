<?php

namespace VladimirH00\DMLOperation\interfaces;


/** Интерфейс с дополнительными методами для Select запроса
 * Interface SqlSelectInterface
 * @package VladimirH00\SqlDml
 */
interface SqlSelectInterface
{
    /**
     * @params array|string $columns
     * @return object $this
     */
    public function select($columns = array("*"));

    /**
     * @params array $columns
     * @return object $this
     */
    public function orderBy($columns);

    /**
     * @params array $columns
     * @return object $this
     */
    public function groupBy($columns);

    public function leftJoin($table1, $values);
    public function innerJoin($table1, $values);
    public function rightJoin($table1, $values);

}