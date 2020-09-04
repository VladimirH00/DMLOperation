<?php

namespace VladimirH00\SqlDml;

/** Интерфейс с дополнительным методом для Update запроса
 * Interface SqlUpdateInterface
 * @package VladimirH00\SqlDml
 */
interface SqlUpdateInterface
{
    /**
     * @params array|string $columns
     * @return object $this
     */
    public function set($columns);
}