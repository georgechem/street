<?php

namespace Street\App\Strategy\CsvNormalizerStrategy;

class TwoPeopleRowNormalizer implements RowNormalizer
{

    private array $data;

    public function normalize():array
    {
        print_r($this->data);
        print_r('Two People');
        return [];
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
