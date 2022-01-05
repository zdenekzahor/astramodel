#!/usr/bin/env php
<?php
declare(strict_types=1);

use Symfony\Component\Console\Application;
use ZdenekZahor\Astramodel\Cli\Command\ProductCommand;
use ZdenekZahor\Astramodel\Service\ExportDownloader;
use ZdenekZahor\Astramodel\Service\ExportParser;

require_once __DIR__ . '/vendor/autoload.php';

$application = new Application();
$application->setName('🏎  PHP connnector for Astramodel products');
$application->setVersion('1.0.1');

$productCommand = new ProductCommand(
	new ExportDownloader(),
	new ExportParser(),
);
$application->add($productCommand);
$application->setDefaultCommand($productCommand->getName());

$application->run();
