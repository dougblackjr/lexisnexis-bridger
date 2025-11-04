<?php
require __DIR__ . '/../vendor/autoload.php';

use Tns\BridgerInsight\BridgerInsight;
use Tns\BridgerInsight\Dto\ScreeningRequest;

$bi = BridgerInsight::fromEnv();

$req = (new ScreeningRequest())
    ->person()
    ->name('Jane', 'Doe')
    ->dob('1985-02-10')
    ->address('1 Main St', 'Boston', 'MA', '02108', 'US')
;

$response = $bi->screening()->searchPerson($req);
var_dump($response);
