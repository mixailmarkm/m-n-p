<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentDescription = [
    'NAME' => GetMessage('T_EXCHANGE_RATE_NAME'),
    'DESCRIPTION' => GetMessage('T_EXCHANGE_RATE_DESCRIPTION'),
    'SORT' => 30,
    'CACHE_PATH' => 'Y',
    'PATH' => [
        'ID' => 'exchange_rate',
        'NAME' => GetMessage('T_EXCHANGE_RATE_GROUP'),
    ],
];
