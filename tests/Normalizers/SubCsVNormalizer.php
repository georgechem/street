<?php

namespace Street\Tests\Normalizers;

use Street\App\Normalizers\CsVNormalizer;

class SubCsVNormalizer extends CsVNormalizer
{
    public function testSplit(): array
    {
        return $this->split();
    }

    public function testProcess(array $data): array
    {
        return $this->process($data);
    }
}
