<?php
define('NO_KEEP_STATISTIC', true);
define('NO_AGENT_STATISTIC', true);
define('NO_AGENT_CHECK', true);
define('NOT_CHECK_PERMISSIONS', true);

require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';

use Bitrix\Main\Loader;

Loader::includeModule('custom.hr.card');

\Custom\Hr\Card\Placement\SmartProcessCard::handle();