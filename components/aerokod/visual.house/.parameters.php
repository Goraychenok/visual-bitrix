<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule("iblock");

//Получение типов инфоблоков
$arTypesEx = CIBlockParameters::GetIBlockTypes(array("-"=>" "));

//Получение инфоблоков по типу
$arIBlocks=array();
$db_iblock = CIBlock::GetList(array("SORT"=>"ASC"), array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
    $arIBlocks[$arRes["ID"]] = "[".$arRes["ID"]."] ".$arRes["NAME"];

//Получение всех инфоблоков
$arAllIBlock=array();
$db_all_iblock = CIBlock::GetList(array("SORT"=>"ASC"));
while($arRes = $db_all_iblock->Fetch())
    $arAllIBlock[$arRes["ID"]] = "[".$arRes["ID"]."] ".$arRes["NAME"];

//Все параметры
$arComponentParameters = array(
    "GROUPS" => array(
        "VISUAL_BLOCK" => array(
            "NAME" => GetMessage("VISUAL_BLOCK_HOUSE_IBLOCK_VISUAL")
        ),
        "APARTMENT_BLOCK" => array(
            "NAME" => GetMessage("VISUAL_BLOCK_HOUSE_IBLOCK_APARTMENTS")
        )
    ),
    "PARAMETERS" => array(
        "NAME" => array(
            "PARENT" => "VISUAL_BLOCK",
            "NAME" => GetMessage("VISUAL_BLOCK_HOUSE_NAME"),
            "TYPE" => "STRING",
            'DEFAULT' => '',
        ),
        "IBLOCK_TYPE" => array(
            "PARENT" => "VISUAL_BLOCK",
            "NAME" => GetMessage('VISUAL_BLOCK_HOUSE_TYPE_IBLOCK'),
            "TYPE" => "LIST",
            "VALUES" => $arTypesEx,
            "DEFAULT" => "",
            "REFRESH" => "Y",
        ),
        "IBLOCK_ID" => array(
            "PARENT" => "VISUAL_BLOCK",
            "NAME" => GetMessage("VISUAL_BLOCK_HOUSE_IBLOCK"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlocks,
            "DEFAULT" => '',
            "REFRESH" => "Y",
        ),
        'SECTION_ID' => array(
            'PARENT' => 'VISUAL_BLOCK',
            'NAME' => GetMessage('VISUAL_BLOCK_HOUSE_SECTION_ID'),
            'TYPE' => 'STRING',
            'DEFAULT' => '={$_REQUEST["SECTION_ID"]}',
        ),
        'SECTION_HOUSE' => array(
            'PARENT' => 'VISUAL_BLOCK',
            'NAME' => GetMessage('VISUAL_BLOCK_HOUSE_SECTION_ID_HOUSE'),
            'TYPE' => 'STRING',
            'DEFAULT' => '={$_REQUEST["SECTION_ID"]}',
        ),
        "IBLOCK_ID_APARTMENTS" => array(
            "PARENT" => "APARTMENT_BLOCK",
            "NAME" => GetMessage("VISUAL_BLOCK_HOUSE_IBLOCK"),
            "TYPE" => "LIST",
            "VALUES" => $arAllIBlock,
            "DEFAULT" => '',
            "REFRESH" => "Y",
        ),
    )
)
?>