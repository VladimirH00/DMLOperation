<?php

namespace VladimirH00\ConstructSqlQuery;

interface SqlQuery
{
    public function select($columns = array("*"));

    public function from($tableName);

    public function andWhere($condition);

    public function orWhere($condition);

    public function orderBy($columns);

    public function groupBy($columns);

    public function getRaw();
}