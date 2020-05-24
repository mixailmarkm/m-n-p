<?php

use Bitrix\Main\Web\HttpClient;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$httpClient = new HttpClient();
$strQueryText = $httpClient->get('http://www.cbr.ru/scripts/XML_val.asp?d=0');
$xmlCode = simplexml_load_string($strQueryText);
$arrCode = [];
foreach ($xmlCode->children() as $child) {
    $arrCode[trim($child->attributes())] = trim($child->Name);
}

$arComponentParameters = [
    'PARAMETERS' => [
        'URL_CENTRAL_BANK_RATES' => [
            'PARENT' => 'ADDITIONAL_SETTINGS',
            'DEFAULT' => 'http://www.cbr.ru/scripts/XML_daily.asp',
            'NAME' => GetMessage('URL_CENTRAL_BANK_RATES'),
            'TYPE' => 'STRING'
        ],
        'CACHE_TIME' => ['DEFAULT' => 84000],
        'CURRENCY' => [
            'PARENT' => 'ADDITIONAL_SETTINGS',
            'NAME' => GetMessage('CURRENCY'),
            'TYPE' => 'LIST',
            'ADDITIONAL_VALUES' => 'N',
            'MULTIPLE' => 'N',
            'VALUES' => $arrCode,
            'REFRESH' => 'Y'
        ],
    ],
];



