<?php

namespace VladimirH00\SqlDml;
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
}