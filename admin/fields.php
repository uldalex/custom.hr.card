<?
// Подключение Bitrix пролога для admin
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_before.php');

// Подключение нашего модуля
use Bitrix\Main\Loader;

Loader::includeModule('custom.hr.card'); //  код модуля
$APPLICATION->SetTitle("Custom HR Card Admin");

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_after.php');
?>

<h1>Custom HR Card</h1>
<p>Модуль установлен</p>

<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_admin.php');