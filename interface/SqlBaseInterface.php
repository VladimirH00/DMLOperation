<?php

namespace VladimirH00\SqlDml;
interface SqlBaseInterface
{
    /**
     * @params array|string $table
     * @return object $this
     */
    public function from($table);
    /**
     * @return string
     */
    public function getRaw();
}