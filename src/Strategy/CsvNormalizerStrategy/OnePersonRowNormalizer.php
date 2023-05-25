<?php

namespace Street\App\Strategy\CsvNormalizerStrategy;

class OnePersonRowNormalizer implements RowNormalizer
{

    private array $data;

    public function normalize():array
    {
//        print_r($this->data);
//        print_r('OnePerson');
        return [];
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
