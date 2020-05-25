<?php

use Bitrix\Main\Web\HttpClient;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CUser $USER */

/** @global CMain $APPLICATION */
class ExchangeRateComponent extends CBitrixComponent
{

    public function __construct($component = null)
    {
        parent::__construct($component);
    }


    /**
     * @return mixed|void
     * @throws Exception
     *
     */
    public function executeComponent()
    {
        if ($this->StartResultCache(false, false, false)) {
            try {
                $httpClient = new HttpClient();
                $strQueryText = $httpClient->get($this->arParams['URL_CENTRAL_BANK_RATES']);
                $xmlCurrency = simplexml_load_string($strQueryText);
                if (empty($xmlCurrency)) {
                    throw new Exception('ЦБ недоступен');
                }
                $currency = array_filter(
                    ((array)$xmlCurrency->children())['Valute'],
                    function ($element) {
                        return trim($element['ID']) === $this->arParams['CURRENCY'];
                    }
                );
                if (empty($currency)) {
                    throw new Exception('ЦБ недоступен');
                }
                $value = current($currency);
                $this->arResult['data'] = [
                    'NumCode' => trim($value->NumCode),
                    'CharCode' => trim($value->CharCode),
                    'Nominal' => trim($value->Nominal),
                    'Name' => trim($value->Name),
                    'Value' => trim($value->Value)
                ];
            } catch (Exception $e) {
                $this->arResult['error'] = 'Ошибка при определении обменного курса';
                $this->AbortResultCache();
            }
            $this->EndResultCache();
        }
        $this->includeComponentTemplate();
        return $this->arResult;
    }
}

