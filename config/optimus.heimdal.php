<?php

use Symfony\Component\HttpKernel\Exception as SymfonyException;
use Optimus\Heimdal\Formatters;

return [
    'add_cors_headers' => FALSE,

    // Has to be in prioritized order, e.g. highest priority first.
    'formatters' => [
        SymfonyException\UnprocessableEntityHttpException::class => Formatters\UnprocessableEntityHttpExceptionFormatter::class,
        SymfonyException\HttpException::class => Z1lab\JsonApi\Formatters\HttpExceptionFormatter::class,
        Exception::class => Z1lab\JsonApi\Formatters\ExceptionFormatter::class,
    ],

    'response_factory' => \Optimus\Heimdal\ResponseFactory::class,

    'reporters' => [
        /*'sentry' => [
            'class'  => \Optimus\Heimdal\Reporters\SentryReporter::class,
            'config' => [
                'dsn' => '',
                // For extra options see https://docs.sentry.io/clients/php/config/
                // php version and environment are automatically added.
                'sentry_options' => []
            ]
        ]*/
    ],

    'server_error_production' => 'An error occurred.'
];
