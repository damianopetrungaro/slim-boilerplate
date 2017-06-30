<?php

declare(strict_types=1);

namespace App\Transformers;

abstract class AbstractTransformer
{
    public function collection(array $records): array
    {
        return array_map([$this, 'item'], $records);
    }

    abstract public function item($record): array;
}
