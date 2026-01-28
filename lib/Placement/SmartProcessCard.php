<?
namespace Custom\Hr\Card\Placement;

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

        $entityId = $options['ENTITY_ID'] ?? ($_REQUEST['ENTITY_ID'] ?? null);
        $entityTypeId = $options['ENTITY_TYPE_ID'] ?? ($_REQUEST['ENTITY_TYPE_ID'] ?? null);

        header('Content-Type: text/html; charset=UTF-8');

        echo '<div style="padding:16px;font-family:Arial,sans-serif">';
        echo '<h2 style="margin:0 0 12px 0">Это кастомная карточка</h2>';
        echo '<div style="margin:0 0 8px 0">Placement жив ✅</div>';
        echo '<div style="margin:0 0 4px 0"><b>ENTITY_TYPE_ID:</b> ' . htmlspecialchars((string)$entityTypeId) . '</div>';
        echo '<div style="margin:0 0 4px 0"><b>ENTITY_ID:</b> ' . htmlspecialchars((string)$entityId) . '</div>';
        echo '</div>';
    }
}