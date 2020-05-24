<?php

use Bitrix\Catalog\StoreTable;
use Bitrix\Main\EventManager;
use Bitrix\Main\Loader;
use Bitrix\Sale\Delivery\ExtraServices\Manager;
use Bitrix\Sale\Order;


EventManager::getInstance()->addEventHandler(
    'main',
    'OnBeforeEventSend',
    function ($arFields, &$arTemplate) {
        if (strpos($arTemplate, '{{SALE_ADDRES_DEPOT}}') !== false) {
            Loader::includeModule('sale');
            $order = Order::load($arFields['ORDER_ID']);
            $deliveryId = $order->getDeliveryIdList()[0];
            if (\Bitrix\Sale\Delivery\Services\Manager::getById($deliveryId)['NAME'] !== 'Самовывоз') {
                $order->getDeliveryIdList();
                $replacement = ' ';
            } else {
                $depot = Manager::getStoresFields($deliveryId)['PARAMS']['STORES']['0'];
                Loader::IncludeModule('catalog'); // подключение каталога
                $replacement = 'Адрес получения заказа: '.StoreTable::getRow(
                        [
                            'select' => ['ADDRESS'],
                            'filter' => [
                                'ID' => $depot,
                            ]
                        ]
                    )['ADDRESS']; // Адрес склада
            }
            $arTemplate = str_replace('{{SALE_ADDRES_DEPOT}}', $replacement, $arTemplate);
        }
    }
);


EventManager::getInstance()->addEventHandler(
    'sale',
    'OnSaleStatusOrder',
    function ($numberOrder, $status) {
        if ($status === 'F') {
            $order = Order::load($numberOrder);
            $userId = $order->getUserId();
            Loader::includeModule('sale');
            $user = new CUser();
            $fields = [
                'PERSONAL_STREET' => '',
                'PERSONAL_CITY' => '',
                'PERSONAL_STATE' => '',
                'PERSONAL_ZIP' => '',
                'PERSONAL_COUNTRY' => '',
                'PERSONAL_MAILBOX' => ''
            ];
            $user->Update($userId, $fields);
        }
    }
);

