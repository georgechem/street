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

    public function testProcessGroup(array $data):void
    {
        $this->processGroup($data);

    }

    public function getSingular(): array
    {
        return $this->singular;
    }

    public function getMulti(): array
    {
        return $this->multi;
    }

}
