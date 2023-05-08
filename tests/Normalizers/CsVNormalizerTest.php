<?php declare(strict_types=1);

namespace Street\Tests\Normalizers;

use PHPUnit\Framework\TestCase;
use Street\App\File\CsvFileIterator;
use Street\App\Helper;
use Street\App\Normalizers\CsVNormalizer;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;
use Street\App\Regex\Regex;

class CsVNormalizerTest extends TestCase
{
    protected array $data;

    protected CsVNormalizer $normalizer;
    public static function csvDataProvider(): array
    {
        $csv_file_iterator = new CsvFileIterator(__DIR__ .'./../../src/take-home-task-data.csv');
        $csv_normalizer = new CsVNormalizer();
        $csv_file_iterator->addDataNormalizer($csv_normalizer);
        return $csv_normalizer->getData();
    }

    protected function setUp():void
    {
        $this->data = CsVNormalizerTest::csvDataProvider();
        $this->normalizer = new SubCsVNormalizer();
        $this->normalizer->setData($this->data);
    }

    // Row currently can be split into group with one or max two users
    public function testSplitInCsvNormalizer():array
    {
        $array = $this->normalizer->testSplit();
        foreach ($array as $row){
            $this->assertThat(
                count($row),
                $this->logicalAnd($this->greaterThanOrEqual(1) && $this->lessThanOrEqual(2))
            , 'Row contains less than 1 or more than 2 users');
        }
        return $array;

    }

    // space as a separator should result in array with minimum length of 2 and max length of  3
    #[Depends('testSplitInCsvNormalizer')]
    public function testProcessInCsvNormalizer(array $array)
    {
        $data = $this->normalizer->testProcess($array);
        foreach ($data as $row){
            $result = Helper::splitBy(Regex::ONE_SPACE_OR_MORE, $row);
            $this->assertThat(
                count($result),
                $this->logicalAnd($this->greaterThanOrEqual(2) && $this->lessThanOrEqual(3))
            );
        }

    }



}
