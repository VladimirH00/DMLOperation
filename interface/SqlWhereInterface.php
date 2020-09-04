<?php

namespace VladimirH00\SqlDml;
interface SqlWhereInterface
{
    /**
     * @param $condition
     * @return mixed
     */
    public function andWhere($condition);
    /**
     * @param array $condition
     * @return object $this
     */
    public function orWhere( $condition);
}