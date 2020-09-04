<?php
namespace VladimirH00\SqlDml;

interface SqlLimitableInterface
{
    /**
     * @params int $limit
     * @return object $this
     */
    public function limit($limit);
}