#!/usr/bin/env php
<?php

if (!file_exists(__DIR__.'/vendor/autoload.php')) {
    passthru('composer update');
}
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\Writers\WriterInterface;
use App\Processors\ProcessorInterface;
use \App\Exception\BadWriterClassException;
use App\Exception\BadProcessorClassException;

$app_name = basename(__FILE__);
$app = new Application($app_name, '1.0.0');
$app->register($app_name)
    ->addArgument('filename', InputArgument::REQUIRED, 'Input CSV')
    ->setCode(function(InputInterface $input, OutputInterface $output) {
        $filename = $input->getArgument('filename');
        $config = require(__DIR__ . DIRECTORY_SEPARATOR . 'config.php');

        $writer_instance = new $config['container']['writer']();
        if (!($writer_instance instanceof WriterInterface)) {
            throw new BadWriterClassException($config['container']['writer']);
        }

        $processor_instance = new $config['container']['processor']();
        if (!($processor_instance instanceof ProcessorInterface)) {
            throw new BadProcessorClassException($config['container']['processor']);
        }

        $processor_instance->setConfig($config['rules'])
                            ->setCurrenciesData($config['currencies'])
                            ->setWriter($writer_instance)
                            ->execute($filename);
    })
    ->getApplication()
    ->setDefaultCommand($app_name, true)
    ->run();