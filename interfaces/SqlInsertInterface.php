<?php

namespace VladimirH00\DMLOperation\interfaces;
/**
 * Интерфейс для формирования Insert запросов
 * Interface SqlInsertInterface
 * @package VladimirH00\SqlDml
 */
interface SqlInsertInterface
{
    /**
     * @params array|string $columns
     * @return object $this
     */
    public function insert($columns, $table);

    /**
     * @return string
     */
    public function getRaw();

}