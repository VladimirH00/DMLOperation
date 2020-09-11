<?php


namespace VladimirH00\DMLOperation\interfaces;


interface SqlWhereInterface
{
    public function where($condition);
    public function andWhere($condition);
    public function orWhere($condition);
}