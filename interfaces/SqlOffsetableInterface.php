<?php
namespace VladimirH00\DMLOperation\interfaces;

/** Интерфейс задающий сдвиг вывода данных
 * Interface SqlOffsetableInterface
 * @package VladimirH00\SqlDml
 */
interface SqlOffsetableInterface
{
    /**
     * @params int $offset
     * @return object $this
     */
    public function offset($offset);
}