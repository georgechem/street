<?php

namespace Street\App\Strategy\CsvNormalizerStrategy;

use Street\App\Helper;
use Street\App\Regex\Regex;

class OnePersonRowNormalizer implements RowNormalizer
{

    private array $data;

    public function normalize():array|null
    {
        $tmp = Helper::splitBy(Regex::ONE_SPACE_OR_MORE, $this->data[0]);
        // in single row record must be at least initial & surname so length must be greater than one
        if ($tmp && Helper::isArrayLengthGreaterThan($tmp, 1)) return $this->data;
        return null;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
