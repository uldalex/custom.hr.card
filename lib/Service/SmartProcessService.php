<?php

namespace Custom\Hr\Card\Service;

class SmartProcessService
{
    public function getItemData($entityTypeId = null, $entityId = null): array
    {
        if ($entityTypeId === 'null' || $entityTypeId === '') { $entityTypeId = null; }
        if ($entityId === 'null' || $entityId === '') { $entityId = null; }

        return [
            'ok' => true,
            'stub' => true,
            'entityTypeId' => $entityTypeId,
            'entityId' => $entityId,
            'ts' => time(),
        ];
    }
}