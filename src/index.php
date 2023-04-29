<?php

use Street\App\File\CsvFileIterator;
use Street\App\Normalizers\CsVNormalizer;
use Street\App\Normalizers\UserNormalizer;

require __DIR__ .  '/../vendor/autoload.php';


$csv_file_iterator = new CsvFileIterator(__DIR__ .'/take-home-task-data.csv');

$csv_normalizer = new CsVNormalizer();
$csv_file_iterator->addDataNormalizer($csv_normalizer);
// get properly structured data for further processing (get uniform data)
$csv_normalizer->normalize();

$user_normalizer = new UserNormalizer();

foreach ($csv_normalizer->getData() as $row){
    $user_normalizer->addData($row);
}

// uniform data will be normalized to User Model
// and will be ready to store in database
$user_normalizer->normalize();

$result = $user_normalizer->getData();

print_r($result);

