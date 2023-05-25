<?php

namespace Street\App\Strategy\CsvNormalizerStrategy;

interface RowNormalizer
{
    public function setData(array $data);
    public function normalize():array;
}
