<?php

namespace VladimirH00\DMLOperation\interfaces;

/**
 * Интерфейс с общими методами запросов к SQL
 * Interface SqlBaseInterface
 * @package VladimirH00\SqlDml
 */

interface SqlBaseInterface
{
    /**
     * @params array|string $table - строка или массив содержащий название таблицы SQL
     * @return $this
     */
    public function from($table);
    /**
     * получение строки сформированного запроса
     * @return string
     */
    public function getRaw();
}