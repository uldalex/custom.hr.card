<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\IO\File;

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

        $this->installTools();
        $this->installAdminFiles();
        
    }

    public function DoUninstall()
    {
        $this->uninstallAdminFiles();
        $this->uninstallTools();

        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    private function installTools(): void
    {
        $srcDir = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $this->MODULE_ID . '/install/tools';
        $dstDir = $_SERVER['DOCUMENT_ROOT'] . '/local/tools';

        if (!is_dir($srcDir)) {
            return;
        }

        if (!is_dir($dstDir)) {
            Directory::createDirectory($dstDir);
        }

        $files = [
            'custom_hr_card.php',
            'custom_hr_card_placement.php',
        ];

        foreach ($files as $fileName) {
            $src = $srcDir . '/' . $fileName;
            $dst = $dstDir . '/' . $fileName;

            if (is_file($src)) {
                // Перезаписываем на всякий случай (без вопросов)
                File::putFileContents($dst, File::getFileContents($src));
            }
        }
    }

    private function uninstallTools(): void
    {
        $dstDir = $_SERVER['DOCUMENT_ROOT'] . '/local/tools';

        $files = [
            $dstDir . '/custom_hr_card.php',
            $dstDir . '/custom_hr_card_placement.php',
        ];

        foreach ($files as $path) {
            if (is_file($path)) {
                @unlink($path);
            }
        }
    }
    private function installAdminFiles(): void
    {
        $srcDir = $_SERVER['DOCUMENT_ROOT']
            . '/bitrix/modules/'
            . $this->MODULE_ID
            . '/install/admin';

        $dstDir = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin';

        if (!is_dir($srcDir)) {
            return;
        }

        $files = scandir($srcDir);
        if (!$files) {
            return;
        }

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $src = $srcDir . '/' . $file;
            $dst = $dstDir . '/' . $file;

            if (is_file($src)) {
                copy($src, $dst);
            }
        }
    }

    private function uninstallAdminFiles(): void
    {
        $srcDir = $_SERVER['DOCUMENT_ROOT']
            . '/bitrix/modules/'
            . $this->MODULE_ID
            . '/install/admin';

        $dstDir = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin';

        if (!is_dir($srcDir)) {
            return;
        }

        $files = scandir($srcDir);
        if (!$files) {
            return;
        }

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $dst = $dstDir . '/' . $file;

            if (is_file($dst)) {
                unlink($dst);
            }
        }
    }
}
