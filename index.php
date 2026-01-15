<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arClasses = [
    "custom_hr_card" => "install/index.php",
];

\Bitrix\Main\Loader::registerAutoLoadClasses(
    "custom.hr.card",
    $arClasses
);