<?php


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

$docRoot = $_SERVER['DOCUMENT_ROOT'];
$host = (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

$appPath = $docRoot . '/local/tools/custom_hr_card.php';
$placementPath = $docRoot . '/local/tools/custom_hr_card_placement.php';

$appUrl = $scheme . '://' . $host . '/local/tools/custom_hr_card.php';
$placementUrl = $scheme . '://' . $host . '/local/tools/custom_hr_card_placement.php';

function yn($v) { return $v ? 'Есть' : 'Нет'; }

echo '<h2>Кастомная карточка HR - Статус</h2>';

echo '<h3>A. Эндпойнты в /local/tools</h3>';
echo '<ul>';
echo '<li><b>/local/tools/custom_hr_card.php</b>: exists = <b>' . yn(is_file($appPath)) . '</b></li>';
echo '<li><b>/local/tools/custom_hr_card_placement.php</b>: exists = <b>' . yn(is_file($placementPath)) . '</b></li>';
echo '</ul>';

echo '<h3>B. Ссылки:</h3>';
echo '<ul>';
echo '<li><a href="'.htmlspecialchars($appUrl).'" target="_blank">Открыть handler приложения</a> (bind выполнять через «Перейти к приложению»)</li>';
echo '<li><a href="'.htmlspecialchars($placementUrl).'" target="_blank">Открыть placement handler</a></li>';
echo '</ul>';

echo '<h3>C. Шаги инсталяции:</h3>';
echo '<ol>';
echo '<li>Установить модуль (entrypoints появятся в /local/tools)</li>';
echo '<li>Создать локальное приложение: handler = <code>/local/tools/custom_hr_card.php</code></li>';
echo '<li>Открыть приложение через «Перейти к приложению» и выполнить bind вкладки</li>';
echo '<li>Проверить карточку смарт-процесса 1032</li>';
echo '</ol>';

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");