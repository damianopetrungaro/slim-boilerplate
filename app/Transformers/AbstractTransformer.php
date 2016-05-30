<?php

namespace App\Transformers;

abstract class AbstractTransformer
{
    public function collection(array $records)
    {
        return array_map([$this, 'item'], $records);
    }

    abstract public function item($record);
}
