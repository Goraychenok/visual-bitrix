<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Aerokod\Components\Visual\VisualHouse;

if (!CModule::IncludeModule("iblock")) {
    CModule::IncludeModule("iblock");
}
require '/var/www/bitrix/vendor/autoload.php';
include_once('/var/www/bitrix/src/Aerokod/Components/Visual/VisualHouse.php');

/** @var $arParams array */
/** @var $arResult array */

//Вывод ошибок
if (!$arParams['IBLOCK_TYPE']) {
    echo '<pre>' . GetMessage("VISUAL_BLOCK_HOUSE_TYPE_IBLOCK_ERROR") . '</pre>';
    return;
}

if (!$arParams['IBLOCK_ID']) {
    echo '<pre>' . GetMessage("VISUAL_BLOCK_HOUSE_IBLOCK_ERROR") . '</pre>';
    return;
}

if (!$arParams['IBLOCK_ID_APARTMENTS']) {
    echo '<pre>' . GetMessage("VISUAL_BLOCK_HOUSE_APARTMENTS_ERROR") . '</pre>';
    return;
}

if (!$arParams['SECTION_ID']) {
    echo '<pre>' . GetMessage("VISUAL_BLOCK_HOUSE_SECTION_ERROR") . '</pre>';
    return;
}

if (!$arParams['SECTION_HOUSE']) {
    echo '<pre>' . GetMessage("VISUAL_BLOCK_HOUSE_SECTION_HOUSE_ERROR") . '</pre>';
    return;
}

//Фильтр проекта
$arFilterSection = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arParams['SECTION_ID']);


//Получение данных по проекту
$arSection = array();
$arGetSection = CIBlockSection::GetList(array("SORT" => "ASC"), $arFilterSection, false, array('IBLOCK_ID', 'ID', 'NAME'));
if ($secOb = $arGetSection->GetNext()) {
    $arSection = $secOb;
}



//Получение ID проекта из другого инфоблока
$arSectionInner = array();
$arFilterSectionInner = array('IBLOCK_ID' => 6, 'ACTIVE' => 'Y', 'NAME' => $arSection['NAME']);
$arGetSectionInner = CIBlockElement::GetList(array("SORT" => "ASC"), $arFilterSectionInner, false, false, array('IBLOCK_ID', 'ID', 'NAME', 'CODE'));
if ($secObInner = $arGetSectionInner->GetNextElement()) {
    $arFields = $secObInner->GetFields();
    $arSectionInner = $arFields['ID'];
}

//Фильтр дома
$arFilterHouse = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arParams['SECTION_HOUSE']);

//Получение данных по дому
$arHouse = array();
$arGetHouse = CIBlockSection::GetList(array("SORT" => "ASC"), $arFilterHouse, false, array('IBLOCK_ID', 'ID', 'NAME', 'CODE', 'PICTURE', 'UF_*'));
if ($houOb = $arGetHouse->GetNext()) {
    $arHouse = $houOb;
}


//Объект для визуального
$result = new VisualHouse(
    $arHouse['UF_PROJECT_WIDTH'], //Ширина картинки
    $arHouse['UF_PROJECT_HEIGHT'], //Высота картинки
    CFile::GetPath($arHouse['PICTURE']) //Ссылка на картинку
);

//Вывод тайтл

if ($arParams['NAME']) {
    $result->setTitle($arParams['NAME']);
}

//Получение данных по этажам
$arFilterItems = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'SECTION_ID' => $arParams['SECTION_HOUSE']);
$arItems = array();
$arGetItems = CIBlockElement::GetList(array("SORT" => "ASC"), $arFilterItems, false, false, array('IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_FLOOR', 'PROPERTY_POINTS'));
while ($ob = $arGetItems->GetNextElement()) {
    $arFields = $ob->GetFields();
    $arItems[] = $arFields;
}




//Получение квартир
foreach ($arItems as $key => $item) {
    if ($arHouse['UF_ALT_NAME']) {
        $name = $arHouse['UF_ALT_NAME'];
    } else {
        $name = $arHouse['NAME'];
    }
    $arGetElements = CIBlockElement::GetList(
        array("SORT" => "ASC"),
        array('IBLOCK' => $arParams['IBLOCK_ID_APARTMENTS'], 'ACTIVE' => 'Y', 'PROPERTY_PROJECT' => $arSectionInner, 'PROPERTY_HOUSE_NAME' => $name, 'PROPERTY_FLOOR' => $item['PROPERTY_FLOOR_VALUE'], 'PROPERTY_ENTRANCE' => $arHouse['UF_ENTRANCE']),
        false,
        false,
        array('IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_ROOMS', 'PROPERTY_PRICE', 'PROPERTY_AREA')
    );
    while ($obElem = $arGetElements->GetNextElement()) {
        $arFields = $obElem->GetFields();
        $arItems[$key]['ITEMS'][] = $arFields;
    }
}


$result->setFloors($arItems);
$result->setResult($arParams['IBLOCK_ID'],$arParams['IBLOCK_TYPE'],$arParams['IBLOCK_ID_APARTMENTS'], $arSection['ID'], $arHouse['ID'], $arHouse['NAME']);

$arResult = $result->getResult();


$this->IncludeComponentTemplate();
?>

