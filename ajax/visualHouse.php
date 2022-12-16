<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
if (!CModule::IncludeModule("iblock")) {
    CModule::IncludeModule("iblock");
}
?>
<?$APPLICATION->IncludeComponent(
    "aerokod:visual.house",
    ".default",
    Array(
        "IBLOCK_ID" => $_POST['IBLOCK'],
        "IBLOCK_ID_APARTMENTS" => $_POST['APARTMENTS_ID'],
        "IBLOCK_TYPE" => $_POST['TYPE'],
        "NAME" => "Выберите этаж",
        "SECTION_HOUSE" => $_POST['HOUSE_ID'],
        "SECTION_ID" => $_POST['PROJECT_ID']
    )
);?>
