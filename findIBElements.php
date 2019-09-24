<?php

define("NO_KEEP_STATISTIC", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

require_once 'local/php_interface/classes/AutoLoader.php';

\spl_autoload_register('\Asperansa\AutoLoader::autoLoad');

/**
 * Пример использования менеджера по работе с инфоблоками
 */

use Asperansa\Data\Bitrix\IBlockElementManager;

$manager = IBlockElementManager::getInstance();

// Studios dictionary
$studios = [];

$dbItems = $manager->getRepository()->rawFindBy(
    [
        'IBLOCK_ID'            => 1,
        'ACTIVE'               => 'Y',
        '!PROPERTY_STUDIO_ID' => false,
    ],
    [
        'id' => 'asc',
    ],
    [
        'ID',
        'NAME',
        'PROPERTY_STUDIO_ID',
    ]
);

while ($arItem = $dbItems->Fetch()) {
    $studios[$arItem['PROPERTY_STUDIO_ID_VALUE']] = [
        'id'   => $arItem['ID'],
        'name' => $arItem['NAME'],
    ];
}