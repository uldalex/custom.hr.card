<?php

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

use Bitrix\Main\Loader;

header('Content-Type: application/json; charset=UTF-8');

if (!Loader::includeModule('custom.hr.card'))
{
    echo json_encode([
        'status' => 'error',
        'data' => null,
        'errors' => [
            ['message' => 'module_not_loaded']
        ],
    ]);
    exit;
}

$entityTypeId = $_POST['entityTypeId'] ?? null;
$entityId = $_POST['entityId'] ?? null;

try
{
    $controller = new \Custom\Hr\Card\Controller\CardController();
    $data = $controller->getItemDataAction($entityTypeId, $entityId);

    echo json_encode([
        'status' => 'success',
        'data' => $data,
        'errors' => [],
    ]);
}
catch (\Throwable $e)
{
    echo json_encode([
        'status' => 'error',
        'data' => null,
        'errors' => [
            ['message' => $e->getMessage()]
        ],
    ]);
}