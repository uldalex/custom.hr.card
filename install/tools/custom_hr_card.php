<?php
define('NO_KEEP_STATISTIC', true);
define('NO_AGENT_STATISTIC', true);
define('NO_AGENT_CHECK', true);
define('NOT_CHECK_PERMISSIONS', true);

require $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php';

// Этот файл открывается через «Перейти к приложению» (application context).
// Здесь мы легально делаем placement.bind через BX24.callMethod.

$host = (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$placementHandlerUrl = $scheme . '://' . $host . '/local/tools/custom_hr_card_placement.php';

// Важно: ENTITY_TYPE_ID вашего смарт-процесса
$entityTypeId = 1032;

// Placements (по твоему placement.list)
$placementTab = 'CRM_DYNAMIC_1032_DETAIL_TAB';
$placementToolbar = 'CRM_DYNAMIC_1032_DETAIL_TOOLBAR';
?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Custom HR Card — Init</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://api.bitrix24.com/api/v1/"></script>
  <style>
    body { font-family: Arial, sans-serif; padding: 16px; }
    .row { margin: 10px 0; }
    button { padding: 10px 14px; margin-right: 8px; }
    pre { background:#f5f5f5; padding:12px; border-radius:8px; white-space:pre-wrap; }
    .hint { color:#555; }
  </style>
</head>
<body>
  <h2>Custom HR Card — Инициализация placement</h2>

  <div class="row hint">
    ВАЖНО: эта страница должна быть открыта через «Перейти к приложению» (контекст приложения).
    При прямом открытии bind может не работать.
  </div>

  <div class="row">
    <b>Handler (TAB):</b>
    <div><code><?= htmlspecialchars($placementHandlerUrl, ENT_QUOTES) ?></code></div>
  </div>

  <div class="row">
    <button id="bindTabBtn">Bind вкладку (DETAIL_TAB)</button>
    <button id="bindToolbarBtn">Bind тулбар (DETAIL_TOOLBAR)</button>
    <button id="listBtn">placement.list</button>
  </div>

  <h3>Результат</h3>
  <pre id="out">Готово. Нажми кнопку.</pre>

  <script>
    const out = document.getElementById('out');
    const bindTabBtn = document.getElementById('bindTabBtn');
    const bindToolbarBtn = document.getElementById('bindToolbarBtn');
    const listBtn = document.getElementById('listBtn');

    function safeStringify(obj) {
      const seen = new WeakSet();
      return JSON.stringify(obj, function (key, value) {
        if (typeof value === 'object' && value !== null) {
          if (seen.has(value)) return '[Circular]';
          seen.add(value);
        }
        return value;
      }, 2);
    }

    function log(any) {
      try {
        out.textContent = (typeof any === 'string') ? any : safeStringify(any);
      } catch (e) {
        out.textContent = 'LOG_ERROR: ' + (e && e.message ? e.message : String(e));
      }
    }

    function setDisabled(disabled) {
      bindTabBtn.disabled = disabled;
      bindToolbarBtn.disabled = disabled;
      listBtn.disabled = disabled;
    }

    setDisabled(true);
    log('Инициализация BX24...');

    BX24.init(function () {
      setDisabled(false);
      log('BX24.init OK. Можно выполнять bind.');
    });

    function doBind(placementCode) {
      setDisabled(true);
      log('Выполняю placement.bind: ' + placementCode + ' ...');

      BX24.callMethod(
        'placement.bind',
        {
          PLACEMENT: placementCode,
          HANDLER: '<?= htmlspecialchars($placementHandlerUrl, ENT_QUOTES) ?>',
          TITLE: 'Custom HR Card'
          // OPTIONS пока не используем
        },
        function (res) {
          setDisabled(false);

          if (res.error()) {
            log({
              ok: false,
              error: String(res.error()),
              error_description: String(res.error_description ? res.error_description() : ''),
              raw: res.answer ? res.answer : null
            });
            return;
          }

          log({ ok: true, placement: placementCode, result: res.data() });
        }
      );
    }

    bindTabBtn.addEventListener('click', function () {
      doBind('<?= htmlspecialchars($placementTab, ENT_QUOTES) ?>');
    });

    bindToolbarBtn.addEventListener('click', function () {
      doBind('<?= htmlspecialchars($placementToolbar, ENT_QUOTES) ?>');
    });

    listBtn.addEventListener('click', function () {
      setDisabled(true);
      log('Запрашиваю placement.list...');

      BX24.callMethod('placement.list', {}, function (res) {
        setDisabled(false);

        if (res.error()) {
          log({
            ok: false,
            error: String(res.error()),
            error_description: String(res.error_description ? res.error_description() : ''),
            raw: res.answer ? res.answer : null
          });
          return;
        }

        log({ ok: true, count: res.data() ? res.data().length : null, placements: res.data() });
      });
    });
  </script>
</body>
</html>