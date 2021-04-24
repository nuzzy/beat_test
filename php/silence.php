<?php

include './libs/autoload.php';

use App\Application\Application;
use App\Application\ApplicationException;
use App\GeneralErrors;
use App\Infrastructure\Arguments;
use App\Infrastructure\InfrastructureException;

$app = new Application();

try {
    $args = new Arguments($argv);
    $app->run($args);
} catch (ApplicationException | InfrastructureException $e) {

    print($e->getMessage());
    exit($e->getCode());
} catch (Exception $e) {

    print($e->getMessage());
    exit(GeneralErrors::ERROR_CODE_UNKNOWN_ERROR);
}

