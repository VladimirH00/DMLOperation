<?php
namespace VladimirH00\SqlDml;

interface SqlOffsetableInterface
{
    /**
     * @params int $offset
     * @return object $this
     */
    public function offset($offset);
}