<?php

use Aerokod\Components\Visual\VisualFloor;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


if (!CModule::IncludeModule("iblock")) {
    CModule::IncludeModule("iblock");
}
require '/var/www/bitrix/vendor/autoload.php';
include_once('/var/www/bitrix/src/Aerokod/Components/Visual/VisualFloor.php');

/** @var $arParams array */
/** @var $arResult array */

//Вывод ошибок
if (!$arParams['IBLOCK_TYPE']) {
    echo '<pre>' . GetMessage("VISUAL_BLOCK_FLOOR_TYPE_IBLOCK_ERROR") . '</pre>';
    return;
}

if (!$arParams['IBLOCK_ID']) {
    echo '<pre>' . GetMessage("VISUAL_BLOCK_FLOOR_IBLOCK_ERROR") . '</pre>';
    return;
}

if (!$arParams['IBLOCK_ID_APARTMENTS']) {
    echo '<pre>' . GetMessage("VISUAL_BLOCK_FLOOR_APARTMENTS_ERROR") . '</pre>';
    return;
}

if (!$arParams['SECTION_ID']) {
    echo '<pre>' . GetMessage("VISUAL_BLOCK_FLOOR_SECTION_ERROR") . '</pre>';
    return;
}

if (!$arParams['SECTION_HOUSE']) {
    echo '<pre>' . GetMessage("VISUAL_BLOCK_FLOOR_SECTION_HOUSE_ERROR") . '</pre>';
    return;
}
if (!$arParams['FLOOR_ID']) {
    echo '<pre>' . GetMessage("VISUAL_BLOCK_FLOOR_SECTION_FLOOR_ERROR") . '</pre>';
    return;
}

//Фильтр проекта
$arFilterSection = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ID' => $arParams['SECTION_ID']);

//Получение данных по проекту
$arSection = array();
$arGetSection = CIBlockSection::GetList(array("SORT" => "ASC"), $arFilterSection, false, array('IBLOCK_ID', 'ID', 'NAME', 'UF_*'));
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

//Вывод тайтл

if ($arParams['NAME']) {
    //$result->setTitle($arParams['NAME']);
}

//Получение данных по этажу'
$arFilterItems = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'SECTION_ID' => $arParams['SECTION_HOUSE'], 'ID' => $arParams['FLOOR_ID']);
$arItem = array();
$arGetItems = CIBlockElement::GetList(array("SORT" => "ASC"), $arFilterItems, false, false, array('IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_FLOOR', 'PREVIEW_PICTURE', 'PROPERTY_WIDTH', 'PROPERTY_HEIGHT', 'PROPERTY_PLAN'));
if ($ob = $arGetItems->GetNextElement()) {
    $arFields = $ob->GetFields();
    $arItem = $arFields;
    $VALUES = array();
    $points = CIBlockElement::GetProperty($arParams['IBLOCK_ID'], $arParams['FLOOR_ID'],"sort", "asc", array("CODE" => "POINTS_IN_FLOOR"));
    while ($ob = $points->GetNext())
    {
        $VALUES[] = $ob['VALUE'];
    }
    $arItem['POINTS_IN_FLOOR'] = $VALUES;
}


//Объект для визуального
$result = new VisualFloor(
    CFile::GetPath($arItem['PROPERTY_PLAN_VALUE']), //Ссылка на картинку
    $arItem['PROPERTY_WIDTH_VALUE'], //Ширина картинки
    $arItem['PROPERTY_HEIGHT_VALUE'], //Высота картинки
    $arParams['IBLOCK_ID'], //ID инфоблока
    $arParams['IBLOCK_TYPE'], //Тип инфоблока
    $arParams['SECTION_ID'], //ID проекта
    $arParams['SECTION_HOUSE'], //ID дома
    $arParams['IBLOCK_ID_APARTMENTS'], //ID инфоблока с квартирами
    $arHouse['NAME'], // Название дома
    $arItem['NAME']  //Название этажа
);

//Получение квартир
if ($arHouse['UF_ALT_NAME']) {
    $name = $arHouse['UF_ALT_NAME'];
} else {
    $name = $arHouse['NAME'];
}
$arGetElements = CIBlockElement::GetList(
    array("SORT" => "ASC"),
    array('IBLOCK' => $arParams['IBLOCK_ID_APARTMENTS'], 'PROPERTY_PROJECT' => $arSectionInner, 'PROPERTY_HOUSE_NAME' => $name, 'PROPERTY_FLOOR' => $arItem['PROPERTY_FLOOR_VALUE'], 'PROPERTY_ENTRANCE' => $arHouse['UF_ENTRANCE']),
    false,
    false,
    array('IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_ROOMS', 'PROPERTY_PRICE', 'PROPERTY_AREA', '', 'ACTIVE', 'PROPERTY_RISER', 'PROPERTY_FINISH', 'PROPERTY_NUMBER', 'DETAIL_PAGE_URL')
);
while ($obElem = $arGetElements->GetNextElement()) {
    $arFields = $obElem->GetFields();
    $arItem['ITEMS'][] = $arFields;
}


$result->setQuarter($arHouse['UF_QUARTER']); //Квартал сдачи
$result->setYear($arHouse['UF_YEAR']); // Год сдачи
$result->setFloor($arItem['PROPERTY_FLOOR_VALUE']); //Текущий этаж
$result->setPoints($arItem['POINTS_IN_FLOOR']); //Поинты
$result->setItems($arItem['ITEMS']); //Квартиры

//Получение всех этажей дома
$arFilterFloors = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'SECTION_ID' => $arParams['SECTION_HOUSE']);
$arFloors = array();
$arGetFloors = CIBlockElement::GetList(array("NAME" => "ASC"), $arFilterFloors, false, false, array('IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_FLOOR'));
while ($ob = $arGetFloors->GetNextElement()) {
    $arFields = $ob->GetFields();

    //Проверка есть ли квартиры на этаже
    $arApartmentInFloor = array();
    $arApartmentInFloorCheck = CIBlockElement::GetList(
        array("SORT" => "ASC"),
        array('IBLOCK' => $arParams['IBLOCK_ID_APARTMENTS'], 'PROPERTY_PROJECT' => $arSectionInner, 'PROPERTY_HOUSE_NAME' => $name, 'PROPERTY_FLOOR' => $arFields['PROPERTY_FLOOR_VALUE'], 'ACTIVE' => 'Y'),
        false,
        false,
        array('IBLOCK_ID', 'ID', 'NAME')
    );
    while ($obElemInFloor = $arApartmentInFloorCheck->GetNextElement()) {
        $arFieldsInFloor = $obElemInFloor->GetFields();
        $arApartmentInFloor[] = $arFieldsInFloor;
    }
    if ($arApartmentInFloor) {
        $arFloors[] = $arFields;
    }

}

$result->setFloors($arFloors); //Все этажи дома

//Получение всех домов проекта
$arFilterHouseList = array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'SECTION_ID' => $arSection['ID']);
$arHouseList = array();
$arGetHouseList = CIBlockSection::GetList(array("SORT" => "ASC"), $arFilterHouseList, false, array('IBLOCK_ID', 'ID', 'NAME', 'UF_*', 'PICTURE'));
$key = 0;
while ($secObList = $arGetHouseList->GetNext()) {
    $arHouseList[] = $secObList;
    $arHouseList[$key]['PICTURE_URL'] = CFile::GetPath($secObList['PICTURE']);
    $key++;
}

//Проверка на наличие квартир у дома
foreach ($arHouseList as $key => $houseItem) {
    if ($houseItem['UF_ALT_NAME']) {
        $name = $houseItem['UF_ALT_NAME'];
    } else {
        $name = $houseItem['NAME'];
    }
    $arGetElements = CIBlockElement::GetList(
        array("SORT" => "ASC"),
        array('IBLOCK' => $arParams['IBLOCK_ID_APARTMENTS'], 'ACTIVE' => 'Y', 'PROPERTY_PROJECT' => $arSectionInner, 'PROPERTY_ENTRANCE' => $houseItem['UF_ENTRANCE'], 'PROPERTY_HOUSE_NAME' => $name),
        false,
        false,
        array('IBLOCK_ID', 'ID', 'NAME')
    );
    while ($obElem = $arGetElements->GetNextElement()) {
        $arFields = $obElem->GetFields();
        $arHouseList[$key]['ITEMS'][] = $arFields;
    }
}



$result->setHouseList($arHouseList); //Все дома проекта
$result->setMinPlan(CFile::GetPath($arSection['UF_SMALL_PLAN'])); //Маленький план

$result->setResult();
$arResult = $result->getResult();


$this->IncludeComponentTemplate();

?>

