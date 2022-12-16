<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Aerokod\Components\Visual\VisualProject;

if (!CModule::IncludeModule("iblock")) {
    CModule::IncludeModule("iblock");
}
require '/var/www/bitrix/vendor/autoload.php';
include_once('/var/www/bitrix/src/Aerokod/Components/Visual/VisualProject.php');

/** @var $arParams array */
/** @var $arResult array */


//Вывод ошибок
if (!$arParams['IBLOCK_TYPE']) {
    echo '<pre>' . GetMessage("VISUAL_BLOCK_PROJECT_TYPE_IBLOCK_ERROR") . '</pre>';
    return;
}

if (!$arParams['IBLOCK_ID']) {
    echo '<pre>' . GetMessage("VISUAL_BLOCK_PROJECT_IBLOCK_ERROR") . '</pre>';
    return;
}

if (!$arParams['IBLOCK_ID_APARTMENTS']) {
    echo '<pre>' . GetMessage("VISUAL_BLOCK_PROJECT_APARTMENTS_ERROR") . '</pre>';
    return;
}

if (!$arParams['SECTION_ID'] && !$arParams['SECTION_CODE']) {
    echo '<pre>' . GetMessage("VISUAL_BLOCK_PROJECT_SECTION_ERROR") . '</pre>';
    return;
}


//Разница в массиве фильтрации
if ($arParams['SECTION_ID']) {
    $arFilterItems = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'SECTION_ID' => $arParams['SECTION_ID'], 'ACTIVE' => 'Y');
    $arFilterSection = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arParams['SECTION_ID']);
} else {
    $arFilterItems = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'SECTION_CODE' => $arParams['SECTION_CODE'], 'ACTIVE' => 'Y');
    $arFilterSection = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'CODE' => $arParams['SECTION_CODE']);
}


//Получение данных по проекту
$arSection = array();
$arGetSection = CIBlockSection::GetList(array("SORT" => "ASC"), $arFilterSection, false, array('IBLOCK_ID', 'ID', 'NAME', 'CODE', 'PICTURE', 'UF_*'));
if ($secOb = $arGetSection->GetNext()) {
    $arSection = $secOb;
}


//Объект для визуального
$result = new VisualProject(
    $arSection['UF_PROJECT_WIDTH'], //Ширина картинки
    $arSection['UF_PROJECT_HEIGHT'], //Высота картинки
    CFile::GetPath($arSection['PICTURE']) //Ссылка на картинку
);

//Вывод тайтл

if ($arParams['NAME']) {
    $result->setTitle($arParams['NAME']);
}


$arSectionInner = array();

if ($arSection['CODE']) {
    $arFilterSectionInner = array('IBLOCK_ID' => 6, 'ACTIVE' => 'Y', 'CODE' => $arSection['CODE']);
} else {
    $arFilterSectionInner = array('IBLOCK_ID' => 6, 'ACTIVE' => 'Y', 'NAME' => $arSection['NAME']);
}
$arGetSectionInner = CIBlockElement::GetList(array("SORT" => "ASC"), $arFilterSectionInner, false, false,array('IBLOCK_ID', 'ID', 'NAME', 'CODE'));
if ($secObInner = $arGetSectionInner->GetNextElement()) {
    $arFields = $secObInner->GetFields();
    $arSectionInner = $arFields['ID'];
}


//Получение данных по домам
$arItems = array();
$arGetItems = CIBlockSection::GetList(array("SORT" => "ASC"), $arFilterItems, false, array('IBLOCK_ID', 'ID', 'NAME', 'SECTION_ID', 'UF_*', 'PICTURE'));
while ($ob = $arGetItems->GetNext()) {
    $arItems[] = $ob;
}


//Получение квартир

foreach ($arItems as $key => $item) {
    if ($item['UF_ALT_NAME']) {
        $name = $item['UF_ALT_NAME'];
    } else {
        $name = $item['NAME'];
    }
    $arGetElements = CIBlockElement::GetList(
        array("SORT" => "ASC"),
        array('IBLOCK' => $arParams['IBLOCK_ID_APARTMENTS'], 'ACTIVE' => 'Y', 'PROPERTY_PROJECT' => $arSectionInner, 'PROPERTY_ENTRANCE' => $item['UF_ENTRANCE'], 'PROPERTY_HOUSE_NAME' => $name),
        false,
        false,
        array('IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_ROOMS', 'PROPERTY_PRICE', 'PROPERTY_AREA', 'PROPERTY_FLOOR')
    );
    while ($obElem = $arGetElements->GetNextElement()) {
        $arFields = $obElem->GetFields();

    }
}


$year = date('Y');
$result->setYear($year);
$result->setHouses($arItems);
$result->setResult($arParams['IBLOCK_ID'], $arParams['IBLOCK_TYPE'], $arParams['IBLOCK_ID_APARTMENTS'], $arSection['ID']);

$arResult = $result->getResult();

$this->IncludeComponentTemplate();
?>