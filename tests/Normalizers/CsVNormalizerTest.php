<?php declare(strict_types=1);

namespace Street\Tests\Normalizers;

use PHPUnit\Framework\TestCase;
use Street\App\File\CsvFileIterator;
use Street\App\Normalizers\CsVNormalizer;

class CsVNormalizerTest extends TestCase
{
    public static function csvDataProvider(): array
    {
        $csv_file_iterator = new CsvFileIterator(__DIR__ .'./../../src/take-home-task-data.csv');
        $csv_normalizer = new CsVNormalizer();
        $csv_file_iterator->addDataNormalizer($csv_normalizer);
        return $csv_normalizer->getData();
    }

    #[PHPUnit\Framework\Attributes\Test]
    public function testSplit()
    {
        $data = CsVNormalizerTest::csvDataProvider();

    }


}
