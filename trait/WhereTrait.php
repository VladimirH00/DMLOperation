<?php


namespace VladimirH00\SqlDml;


trait WhereTrait
{
    /**
     * @param array $condition
     * @return string
     */
    public function where($condition)
    {
        $condition[0] = strtoupper($condition[0]);
        $index = 0;
        $len = count($condition[2]);
        $str = "";
        if ($condition[0] == "IN" || $condition[0] == "NOT IN") {
            $str .= "{$condition[1]} {$condition[0]} ( ";
            foreach ($condition[2] as $value) {
                $str .= "{$value}" . (++$index == $len ? "" : ",");
            }
            $str .= ")";
        } else {
            $str = "{$condition[1]} {$condition[0]} {$condition[2]}";
        }
        return $str;
    }
}