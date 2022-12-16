<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var $arResult array */
?>


<div class="b-visual-apart">
    <div class="container">
        <div class="b-visual-apart__title-wrapper">
            <div class="b-visual-apart__back" data-url="<?=SITE_DIR?>ajax/visualHouse.php" data-iblock="<?=$arResult['IBLOCK']?>" data-type="<?=$arResult['TYPE']?>" data-apartments="<?=$arResult['APARTMENTS_ID']?>" data-project="<?=$arResult['PROJECT_ID']?>"
                 data-house="<?=$arResult['HOUSE_ID']?>">
                <svg class="icon__arr-back" width="24px" height="7px">
                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/front/build/svg-symbols.svg#arr-back"></use>
                </svg>
            </div>
            <div class="b-visual-apart__title"><?=$arResult['FLOOR_NAME']?>
            </div>
        </div>
        <div class="b-visual-apart__info" data-year="<?=$arResult['YEAR']?>" data-quarter="<?=$arResult['QUARTER']?>" data-frame="<?=$arResult['FLOOR']?>" data-count="<?=count($arResult['ITEMS'])?>" data-number="<?=$arResult['HOUSE_NAME']?>">
        </div>
        <div class="b-visual-apart__floor-cont b-visual-apart__floor-cont_mobile">
            <div class="b-visual-apart__floor-slider">
                <!-- --slides-length - количество этажей. Но, если их больше 5 оставляем 5.-->
                <div class="b-visual-apart__swiper-container-mobile" style="--slides-length:5">
                    <div class="swiper-wrapper">
                        <?foreach ($arResult['FLOORS'] as $key => $floor):?>
                        <!--у текущего этажа data-current атрибут-->
                        <div class="b-visual-apart__swiper-slide swiper-slide" <?if($key == $arResult['FLOOR']):?> data-current<?endif;?>><a class="b-visual-apart__floor-item" href="#"><span class="b-visual-apart__floor-num"><?=$key?></span><span class="b-visual-apart__floor-label">этаж</span></a>
                        </div>
                        <?endforeach;?>

                    </div>
                </div>
            </div>
        </div>
        <div class="b-visual-apart__row row">
            <div class="col-xl-1">
                <div class="b-visual-apart__floor-cont">
                    <div class="swiper-button-prev">
                        <svg class="icon__arrow" width="22px" height="8px">
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/front/build/svg-symbols.svg#arrow"></use>
                        </svg>

                    </div>
                    <div class="b-visual-apart__floor-slider" data-url="<?=SITE_DIR?>ajax/visualFloor.php">
                        <!-- --slides-length - количество этажей. Но, если их больше 5 оставляем 5.-->
                        <div class="swiper-container" style="--slides-length:5">
                            <div class="swiper-wrapper">
                                <?foreach ($arResult['FLOORS'] as $key => $floor):?>
                                <!--у текущего этажа data-current атрибут-->
                                <div class="b-visual-apart__swiper-slide swiper-slide"<?if($key == $arResult['FLOOR']):?> data-current<?endif;?>>
                                    <a class="b-visual-apart__floor-item" data-iblock="<?=$arResult['IBLOCK']?>" data-type="<?=$arResult['TYPE']?>" data-apartments="<?=$arResult['APARTMENTS_ID']?>" data-project="<?=$arResult['PROJECT_ID']?>"
                                       data-house="<?=$arResult['HOUSE_ID']?>" data-floor="<?=$floor?>" href="#"><span class="b-visual-apart__floor-num"><?=$key?></span><span class="b-visual-apart__floor-label">этаж</span></a>
                                </div>
                                <?endforeach;?>

                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-next">
                        <svg class="icon__arrow" width="22px" height="8px">
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/front/build/svg-symbols.svg#arrow"></use>
                        </svg>

                    </div>
                </div>
            </div>
            <div class="b-visual-apart__col-img col-md-12 col-xl-7">
                <div class="b-visual-apart__image-wrapper">
                    <div class="b-visual-apart__image-scroll">
                        <div class="b-visual-apart__img b-visual-apart__img_opacity">
                            <div class="b-visual-apart__swipe-hand">
                                <svg class="icon__swipe-hand" width="512px" height="512px">
                                    <use xlink:href="svg-symbols.svg#swipe-hand"></use>
                                </svg>

                            </div>
                            <div class="b-visual-apart__img">
                                <img src="<?=$arResult['IMG']?>" width="<?=$arResult['WIDTH']?>" height="<?=$arResult['HEIGHT']?>"/>
                                <svg class="b-visual-apart__svg" viewBox="0 0 <?=$arResult['WIDTH']?> <?=$arResult['HEIGHT']?>">
                                    <?foreach ($arResult['ITEMS'] as $arItem):?>
                                    <a class="b-visual-apart__link b-visual-apart__link_in-sale" target="_blank" href="<?=$arItem['URL']?>">
                                        <path class="b-visual-apart__contour-bg" d="<?=$arItem['POINT']?>" style="--color-hover: #3880C4" data-id="<?=$arItem['ID']?>" data-status="in-sale" data-area="<?=$arItem['SQUARE']?>" data-rooms="<?=$arItem['ROOM']?>" data-price="<?=$arItem['PRICE']?>" data-floor="<?=$arResult['FLOOR']?>" data-quarter="<?=$arResult['QUARTER']?>" data-year="<?=$arResult['YEAR']?>" data-number="<?=$arItem['NUMBER']?>">
                                        </path>
                                    </a>
                                    <?endforeach;?>
                                    <?foreach ($arResult['SOLD_ITEMS'] as $key => $arItem):?>
                                        <a class="b-visual-apart__link b-visual-apart__link_sold" href="#">
                                            <path class="b-visual-apart__contour-bg" d="<?=$arItem?>" style="--color-hover: #FFFFFF" data-id="<?=$key?>" data-status="sold" data-area="22,9" data-rooms="3" data-price="12290000" data-floor="5" data-quarter="1" data-year="2023" data-number="143">
                                            </path>
                                        </a>
                                    <?endforeach;?>
                                </svg>
                                <div class="b-visual-apart__markers">
                                </div>
                                <div class="b-visual-apart__add">
                                    <div class="b-visual-apart__add-title">
                                    </div>
                                    <div class="b-visual-apart__add-items">
                                    </div>
                                </div>
                                <div class="b-visual-apart__desc b-visual-apart__desc_mobile">
                                    <div class="b-visual-apart__desc-top">
                                        <div class="b-visual-apart__desc-title">
                                        </div>
                                        <div class="b-visual-apart__desc-fav">
                                        </div>
                                    </div>
                                    <div class="b-visual-apart__desc-list">
                                        <div class="b-visual-apart__desc-item">
                                            <div class="b-visual-apart__desc-area">
                                            </div>
                                        </div>
                                        <div class="b-visual-apart__desc-item">
                                            <div class="b-visual-apart__new-price">
                                            </div>
                                        </div>
                                        <div class="b-visual-apart__desc-item">
                                            <div class="b-visual-apart__desc-deadline">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="b-visual-apart__loader"><img src="<?=SITE_TEMPLATE_PATH?>/front/build/static/img/general/loading.svg"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="b-visual-apart__aside" data-url="<?=SITE_DIR?>ajax/visualHouse.php">
                    <div class="b-visual-apart__img-small"><img src="<?=$arResult['MIN_PLAN']?>" width="350" height="350"/>
                        <svg class="b-visual-apart__svg" viewBox="0 0 350 350">
                            <?foreach ($arResult['HOUSE_LIST'] as $arItem):?>
                                <a class="b-visual-apart__link-small" target="_blank" data-iblock="<?=$arResult['IBLOCK']?>" data-type="<?=$arResult['TYPE']?>" data-apartments="<?=$arResult['APARTMENTS_ID']?>" data-project="<?=$arResult['PROJECT_ID']?>" data-house="<?=$arItem['ID']?>"  href="#">
                                    <path class="b-visual-apart__contour-bg" d="<?=$arItem['POINTS']?>" data-img="<?=$arItem['IMG']?>" data-hidden="<?=($arItem['HIDDEN']) ? 'true' : 'false'?>" data-current="<?=($arItem['ID'] == $arResult['HOUSE_ID']) ? 'true' : 'false'?>">
                                    </path>
                                </a>
                            <?endforeach;?>
                        </svg>
                        <div class="b-visual-apart__desc-small">
                        </div>
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
                <div class="b-visual-apart__modal-desc">
                    <div class="b-visual-apart__desc">
                        <div class="b-visual-apart__desc-top">
                            <div class="b-visual-apart__desc-title">
                            </div>
                            <div class="b-visual-apart__desc-fav">
                            </div>
                        </div>
                        <div class="b-visual-apart__desc-list">
                            <div class="b-visual-apart__desc-item">
                                <div class="b-visual-apart__desc-area">
                                </div>
                            </div>
                            <div class="b-visual-apart__desc-item">
                                <div class="b-visual-apart__new-price">
                                </div>
                            </div>
                            <div class="b-visual-apart__desc-item">
                                <div class="b-visual-apart__desc-deadline">
                                </div>
                            </div>
                        </div>
                        <div class="b-visual-apart__link-wrapper"><a class="b-visual-apart__link" href="">Показать квартиру</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
