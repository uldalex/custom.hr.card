<?php

namespace Custom\Hr\Card\Placement;

use Bitrix\Main\Page\Asset;

class SmartProcessCard
{
    public static function handle(): void
    {
        // В placement Bitrix обычно прилетает PLACEMENT_OPTIONS (json)
        $optionsRaw = $_REQUEST['PLACEMENT_OPTIONS'] ?? '';
        $options = [];

        if (is_string($optionsRaw) && $optionsRaw !== '')
        {
            $decoded = json_decode($optionsRaw, true);
            if (is_array($decoded))
            {
                $options = $decoded;
            }
        }

        // В твоем случае реально прилетает {"ID":"251"}
        $entityId = $options['ID'] ?? ($_REQUEST['ENTITY_ID'] ?? null);

        // ENTITY_TYPE_ID в этом placement не приходит
        $entityTypeId = $options['ENTITY_TYPE_ID'] ?? ($_REQUEST['ENTITY_TYPE_ID'] ?? null);

        // Подключаем JS для этапа 6 (UI -> AJAX -> Controller -> response)
       // Asset::getInstance()->addJs('/local/js/custom.hr.card/card.js');
echo "<script src='/local/js/custom.hr.card/card.js?v=".time()."'></script>";
        header('Content-Type: text/html; charset=UTF-8');
echo "<a href='/local/js/custom.hr.card/card.js'>1</a>";
        echo '<div style="padding:16px;font-family:Arial,sans-serif">';
        echo '<h2 style="margin:0 0 12px 0">Это кастомная карточка</h2>';
        echo '<div style="margin:0 0 8px 0">Placement жив </div>';
        echo '<div style="margin:0 0 4px 0"><b>ENTITY_TYPE_ID:</b> ' . htmlspecialchars((string)$entityTypeId) . '</div>';
        echo '<div style="margin:0 0 4px 0"><b>ENTITY_ID:</b> ' . htmlspecialchars((string)$entityId) . '</div>';

        // Root-узел, откуда JS стартует и берет dataset
        echo '<div id="custom-hr-card-root"'
            . ' data-entity-type-id="' . htmlspecialchars((string)$entityTypeId) . '"'
            . ' data-entity-id="' . htmlspecialchars((string)$entityId) . '"'
            . '></div>';

        echo '</div>';
    }
}