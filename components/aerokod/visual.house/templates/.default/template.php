<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var $arResult array */
?>


<div class="b-visual-floor" data-url="<?=SITE_DIR?>ajax/visualFloor.php">
    <div class="container">
        <?if($arResult['TITLE']):?>
        <div class="b-visual-floor__title"><?=$arResult['TITLE']?>
        </div>
        <?endif;?>
        <div class="b-visual-floor__image-wrapper">
            <div class="b-visual-floor__title-wrapper">

                <div class="b-visual-floor__back" data-iblock="<?=$arResult['IBLOCK']?>" data-type="<?=$arResult['TYPE']?>" data-apartments="<?=$arResult['APARTMENTS_ID']?>" data-project="<?=$arResult['PROJECT_ID']?>" data-url="<?=SITE_DIR?>ajax/visualProject.php">
                    <svg class="icon__arr-back" width="24px" height="7px">
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/front/build/svg-symbols.svg#arr-back"></use>
                    </svg>

                </div>

                <div class="b-visual-floor__back-title">
                    <?=$arResult['NAME']?>
                </div>
            </div>
            <div class="b-visual-floor__image-scroll">
                <div class="b-visual-floor__img b-visual-floor__img_opacity">
                    <div class="b-visual-floor__swipe-hand">
                        <svg class="icon__swipe-hand" width="512px" height="512px">
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/front/build/svg-symbols.svg#swipe-hand"></use>
                        </svg>

                    </div>
                    <div class="b-visual-floor__img"><img src="<?=$arResult['IMG']?>" width="<?=$arResult['WIDTH']?>" height="<?=$arResult['HEIGHT']?>"/>
                        <svg class="b-visual-floor__svg" viewBox="0 0 <?=$arResult['WIDTH']?> <?=$arResult['HEIGHT']?>">
                            <?foreach ($arResult['ITEMS'] as $arItem):?>
                                <a class="b-visual-floor__link" data-iblock="<?=$arResult['IBLOCK']?>" data-type="<?=$arResult['TYPE']?>" data-apartments="<?=$arResult['APARTMENTS_ID']?>" data-project="<?=$arResult['PROJECT_ID']?>" data-house="<?=$arResult['HOUSE_ID']?>" data-floor="<?=$arItem['ID']?>" href="#">
                                    <path class="b-visual-floor__contour" d="<?=$arItem['POINTS']?>" data-apartments='<?=$arItem['ITEMS']?>' data-id="<?=$arItem['ID']?>" data-deadline="30.01.2024" data-apartCount="<?=$arItem['COUNT_ITEMS']?>" data-floor="<?=$arItem['FLOOR']?>">
                                    </path>
                                </a>
                            <?endforeach;?>
                        </svg>
                        <div class="b-visual-floor__scroll-x">
                            <div class="b-visual-floor__scroll-element b-visual-floor__scroll-element_outer">
                            </div>
                        </div>
                        <div class="b-visual-floor__add">
                            <div class="b-visual-floor__add-title">
                            </div>
                            <div class="b-visual-floor__add-items">
                            </div>
                        </div>
                        <div class="b-visual-floor__loader"><img src="<?=SITE_TEMPLATE_PATH?>/front/build/static/img/general/loading.svg"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="visual-floor" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content modal-content_beige">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <svg class="icon__close" width="24px" height="24px">
                        <use xlink:href="svg-symbols.svg#close"></use>
                    </svg>

                </button>
                <div class="b-visual-floor__add-modal">
                </div>
            </div>
        </div>
    </div>

</div>
