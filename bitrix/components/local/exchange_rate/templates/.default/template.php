<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);

if (!$arResult['error']) { ?>
    <div class="currency_success">
        Текущий курс расчетов составляет <?= $arResult['data']['Value'] ?> рублей
        за <?= $arResult['data']['Nominal'] ?> <?= $arResult['data']['Name'] ?>
        (<?= $arResult['data']['CharCode'] ?>).
        Код валюты <?= $arResult['data']['NumCode'] ?>
    </div>
<?php } else { ?>
    <div class="currency_error">
        Ошибка при получении текущего курса
    </div>
    <?php
}
