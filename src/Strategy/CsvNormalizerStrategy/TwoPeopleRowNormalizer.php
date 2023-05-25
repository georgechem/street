<?php

namespace Street\App\Strategy\CsvNormalizerStrategy;

class TwoPeopleRowNormalizer implements RowNormalizer
{

    private array $data;

    public function normalize():array|null
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
