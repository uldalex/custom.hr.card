# Архитектура и правила проекта custom.hr.card

Этот документ фиксирует **каноническую структуру** и **правила разработки** модуля. Он действует для всего проекта и всех будущих изменений. 

```

## Репозиторий проекта
GitHub: https://gitlab.qwell.lo/web/custom.hr.card

```

## Каноническая структура каталогов

```
custom.hr.card/
├── index.php                    # Entry модуля (autoload, без бизнес-логики)
├── .settings.php                # D7 controllers config (namespace для Engine controllers)
├── install/
│   ├── index.php                # Install/Uninstall модуля
│   ├── version.php              # Версия модуля
│   ├── tools/                   # Публичные entrypoints модуля (копируются в /local/tools)
│   │   ├── custom_hr_card.php               # Handler приложения (bind / служебные действия)
│   │   ├── custom_hr_card_placement.php     # Placement handler вкладки (контент iframe)
│   │   └── custom_hr_card_ajax.php          # AJAX proxy: UI → Controller → Service
│   ├── admin/                   # Прокси-файлы (копируются в /bitrix/admin)
│   │   ├── custom_hr_card_fields.php
│   │   └── custom_hr_card_status.php
│   └── assets/                  # Статические ассеты (копируются в /local/js|css)
│       ├── js/card.js            # → /local/js/custom.hr.card/card.js
│       └── css/card.css          # → /local/css/custom.hr.card/card.css
│
├── admin/                       # Реальные страницы админки модуля
│   └── fields.php               # Admin UI (минимум логики) (прокси в /bitrix/admin)
|   └── status.php               # страница диагностики (прокси в /bitrix/admin)
│
├── lib/
│   ├── Controller/
│   │   └── CardController.php    # Тонкий контроллер: входные точки, без бизнес-логики
│   ├── Service/
│   │   ├── SmartProcessService.php
│   │   ├── DiskService.php
│   │   └── CandidateFactory.php
│   ├── Placement/
│   │   └── SmartProcessCard.php  # Рендер вкладки placement (iframe) + подключение ассетов
│   └── Config/
│       └── FieldMap.php          # Маппинг полей (ID не в JS)
│
└── lang/ru/*.php                 # Локализация
```

---

## Изменения в архитектуре
### ADR-001. Почему используем /local/tools/custom_hr_card_ajax.php, а не BX.ajax.runAction

Изначально планировалось работать с backend через стандартный D7-механизм BX.ajax.runAction.
На практике выяснилось, что в контексте вкладки (placement), которая рендерится внутри iframe, этот путь нестабилен: объект BX может быть недоступен, а роутинг D7-контроллеров (.settings.php) не всегда корректно резолвится.

Чтобы не строить архитектуру на предположениях и не завязываться на особенности окружения iframe, было принято решение ввести отдельную публичную AJAX-точку входа в /local/tools/custom_hr_card_ajax.php.

Этот файл выполняет роль тонкого proxy:

принимает AJAX-запросы от UI;

подключает модуль;

передаёт управление в CardController, далее в соответствующие сервисы.

Бизнес-логики в proxy нет.

## Этапы развития

1. Скелет
2. Пустая структура lib/
3. Autoload одного класса
4. Пустой admin-интерфейс
5. Placement без логики, только подкподключение к катрточке процесса 1032
6. Подключение сервисов
7. Клиентская логика



