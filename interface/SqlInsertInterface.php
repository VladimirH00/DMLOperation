<?php

namespace VladimirH00\SqlDml;
interface SqlInsertInterface
{
    /**
     * @params array|string $columns
     * @return object $this
     */
    public function values($columns);
}