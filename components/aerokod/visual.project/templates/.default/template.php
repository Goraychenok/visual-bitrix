<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var $arResult array */
?>

<div class="page__b-visual" id="b_visual" data-iblock="<?=$arResult['IBLOCK']?>" data-type="<?=$arResult['TYPE']?>" data-apartments="<?=$arResult['IBLOCK_APARTMENTS']?>" data-project="<?=$arResult['PROJECT_ID']?>" data-url="<?=SITE_DIR?>ajax/visualHouse.php">
    <div class="b-visual">
        <div class="container">
            <?if($arResult['NAME']):?>
                <div class="b-visual__title"><?=$arResult['NAME']?>
                </div>
            <?endif;?>
            <div class="b-visual__image-wrapper" data-url="<?=SITE_TEMPLATE_PATH?>/front/build/">
                <div class="b-visual__image-scroll">
                    <div class="b-visual__img b-visual__img_opacity">
                        <div class="b-visual__swipe-hand">
                            <svg class="icon__swipe-hand" width="512px" height="512px">
                                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/front/build/svg-symbols.svg#swipe-hand"></use>
                            </svg>
                        </div><img src="<?=$arResult['IMG']?>" style="--width: <?=$arResult['WIDTH']?>; --height: <?=$arResult['HEIGHT']?>"/>
                        <svg class="b-visual__svg" viewBox="0 0 <?=$arResult['WIDTH']?> <?=$arResult['HEIGHT']?>">
                            <?foreach ($arResult['ITEMS'] as $key => $arItem):?>
                                <a class="b-visual__link" data-house="<?=$arItem['ID']?>" href="#">
                                    <path class="b-visual__contour" d="<?=$arItem['POINTS']?>"
                                          data-house="<?=$arItem['NAME']?>"
                                          data-id="<?= $key + 1?>"
                                          data-deadlineQuarter="<?=$arItem['QUARTER']?>"
                                          data-deadlineYear="<?=$arItem['YEAR']?>"
                                          data-deadlinePercent="<?=$arItem['PERCENT']?>"
                                          data-apartCount="<?=$arItem['COUNT_APARTMENTS']?>"
                                          data-aparments='<?=$arItem['APARTMENTS']?>'
                                          data-status="<?=$arItem['STATUS']?>">
                                    </path>
                                </a>
                            <?endforeach;?>
                        </svg>
                        <div class="b-visual__add">
                            <div class="b-visual__add-title">
                            </div>
                            <div class="b-visual__add-items">
                            </div>
                        </div>
                        <div class="b-visual__markers">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="visual" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content modal-content_beige">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <svg class="icon__close" width="24px" height="24px">
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/front/build/svg-symbols.svg#close"></use>
                        </svg>

                    </button>
                    <div class="b-visual__add-modal">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
