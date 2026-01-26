<?
require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_before.php';

use Bitrix\Main\Loader;
use Custom\Hr\Card\Controller\CardController;

if (!Loader::includeModule('custom.hr.card')) {
    echo 'Module not loaded';
    return;
}

echo CardController::ping();