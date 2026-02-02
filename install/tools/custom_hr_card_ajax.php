<?php

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

use Bitrix\Main\Loader;

header('Content-Type: application/json; charset=UTF-8');

if (!Loader::includeModule('custom.hr.card'))
{
    echo json_encode([
        'status' => 'error',
        'errors' => [['message' => 'module_not_loaded']],
    ]);
    exit;
}

$action = $_POST['action'] ?? null;

try
{
    $controller = new \Custom\Hr\Card\Controller\CardController();

    if ($action === 'create')
    {
        $data = $controller->createItemTestAction();
    }
    else
    {
        throw new \RuntimeException('Unknown action');
    }

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
        'errors' => [['message' => $e->getMessage()]],
    ]);
}