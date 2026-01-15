<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class custom_hr_card extends CModule
{
    public $MODULE_ID = "custom.hr.card";
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $PARTNER_NAME;
    public $PARTNER_URI;

    public function __construct()
    {
        $arModuleVersion = [];
        include __DIR__ . "/version.php";

        if (isset($arModuleVersion["VERSION"])) {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }

        $this->MODULE_NAME = "Карточка HR qWell.ru";
        $this->MODULE_DESCRIPTION = "Кастомная карточка HR смарт-процесса";
        $this->PARTNER_NAME = "uldalex";
        $this->PARTNER_URI = "https://qwell24.ru";
    }

    public function DoInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
    }

    public function DoUninstall()
    {
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }
}