<?php

namespace Street\App\Normalizers;

abstract class BaseNormalizer
{
    protected array $data = [];
    abstract function normalize();

    public function addData(string $data): void
    {
        $this->data[] = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }

}
