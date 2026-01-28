<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

use Bitrix\Main\Loader;
use Custom\Hr\Card\Placement\SmartProcessCard;

Loader::includeModule('custom.hr.card');

SmartProcessCard::handle();