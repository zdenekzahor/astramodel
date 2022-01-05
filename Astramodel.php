#!/usr/bin/env php
<?php
declare(strict_types=1);

use Symfony\Component\Console\Application;
use ZdenekZahor\Astramodel\Cli\Command\ProductCommand;

require_once __DIR__ . '/vendor/autoload.php';

$application = new Application();
$application->setName('🏎 PHP connnector for Astramodel products');
$application->setVersion('1.0.0');

$productCommand = new ProductCommand();
$application->add($productCommand);
$application->setDefaultCommand($productCommand->getName());

$application->run();
