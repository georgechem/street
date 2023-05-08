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
        $invalid_count = count($this->normalizer->getInvalidData());
        if($invalid_count > 0){
            printf("\nFound %d invalid entry(ies) in CSV data\n", $invalid_count);
        }
        return $array;

    }

    // group length can be 1 or 2 as only max 2 users per row allowed
    #[Depends('testSplitInCsvNormalizer')]
    public function testProcessGroupInCsvNormazlizer(array $array)
    {
        $this->assertSame(0, count($this->normalizer->getSingular()));
        $this->assertSame(0, count($this->normalizer->getMulti()));
        foreach ($array as $group){
            $this->assertThat(
                count($group),
                $this->logicalAnd(
                    $this->greaterThanOrEqual(1) && $this->lessThanOrEqual(2)
                )
            );
            $this->normalizer->testProcessGroup($group);
        }
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
