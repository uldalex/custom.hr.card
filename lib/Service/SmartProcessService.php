<?php

namespace Custom\Hr\Card\Service;

use Bitrix\Main\Loader;
use Bitrix\Crm\Service\Container;
class SmartProcessService
{
    private int $typeId = 1032;

    public function getItemData($entityTypeId = null, $entityId = null): array
    {
        return [
            'ok' => true,
            'stub' => true,
            'entityTypeId' => $entityTypeId,
            'entityId' => $entityId,
            'ts' => time(),
        ];
    }


public function createItem(array $fields): int
{
    if (!Loader::includeModule('crm')) {
        throw new \RuntimeException('CRM module not loaded');
    }

    $container = Container::getInstance();
    $factory = $container->getFactory($this->typeId);

    if (!$factory) {
        throw new \RuntimeException('Factory not found');
    }

    $item = $factory->createItem();

    foreach ($fields as $field => $value) {
        $item->set($field, $value);
    }

    // ВАЖНО: создаём операцию ADD
    $operation = $factory->getAddOperation($item);

    $result = $operation->launch();

    if (!$result->isSuccess()) {
        throw new \RuntimeException(
            implode('; ', $result->getErrorMessages())
        );
    }

    return (int)$item->getId();
}
    
}