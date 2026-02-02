<?php

namespace Custom\Hr\Card\Controller;

use Bitrix\Main\Engine\Controller;
use Custom\Hr\Card\Service\SmartProcessService;

class CardController extends Controller
{
    public function getItemDataAction($entityTypeId = null, $entityId = null): array
    {
        $service = new SmartProcessService();
        return $service->getItemData($entityTypeId, $entityId);
    }

    public function configureActions(): array
    {
        return [
            'getItemData' => [
                'prefilters' => [],
            ],
        ];
    }
}