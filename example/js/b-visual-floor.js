export default function () {
    let context = 'b-visual-floor'

    if ($(`.${context}`).length == 0) {
        return
    }

    const priceFormatter = (v) => {
        //добавляет пробелы в цену
        v = Math.round(v);
        v = v + "";
        v = v
            .split("")
            .reverse()
            .map((item, i) => (i % 3 == 0 ? item + " " : item));
        v = v.reverse().join("");
        return v;
    };

    const decLabel = (n, titles) => {
        const cases = [2, 0, 1, 1, 1, 2];
        const label = titles[(n % 100 > 4 && n % 100 < 20) ? 2 : cases[(n % 10 < 5) ? n % 10 : 5]]
        return `${label}`
    }

    $('.b-visual-floor__add').hide()

    $(`.${context}__img`).on('mousemove', function(e) {
        $(this)[0].style.setProperty('--left', (e.offsetX))
        $(this)[0].style.setProperty('--top', (e.offsetY))
    })

    $(`.${context}__contour`).on('mouseenter', function (e) {

        const floor = $(this).attr("data-floor");
        const deadline = $(this).attr("data-deadline");
        const apartCount = $(this).attr("data-apartCount");
        let apartments = [];
        let apartmentsItems = ``;

        if ($(this).attr("data-apartments")) {
            apartments = JSON.parse($(this).attr("data-apartments"));
            apartmentsItems = getApartments(apartments);
        }

        if ($(window).height() / 2 < e.offsetY) {
            $('.b-visual-floor__add').addClass('b-visual-floor__add-top')
        } else {
            $('.b-visual-floor__add').removeClass('b-visual-floor__add-top')
        }
        if ($(window).width() / 2 < e.offsetX) {
            $('.b-visual-floor__add').addClass('b-visual-floor__add-right')
        } else {
            $('.b-visual-floor__add').removeClass('b-visual-floor__add-right')
        }

        let html = ''

        html += `
            <div class="b-visual-floor__add-item">
                <div class="b-visual-floor__add-item-top">
                    <div class="b-visual-floor__add-title">${floor} этаж</div>
                    <div class="b-visual-floor__deadline">
                        <div class="b-visual-floor__deadline-wrapper">
                            <div class="b-visual-floor__deadline-text">
                                 Заселение до ${deadline}
                            </div>
                        </div>
                    </div>
                    <div class="b-visual-floor__count">
                       ${apartCount} ${decLabel(apartCount, ['квартира', 'квартиры', 'квартир'])}
                    </div>
                </div>
                <div class="b-visual-floor__add-item-bottom">
                    <div class="b-visual-floor__row">
                        ${apartmentsItems}
                    </div>
                </div>
            </div>
        `

        $('.b-visual-floor__add-items').html(html)
        $('.b-visual-floor__add').show()

        if ($(window).width() <= 992) {
            const floor = $(this).attr("data-floor");
            const deadline = $(this).attr("data-deadline");
            const apartCount = $(this).attr("data-apartCount");
            let apartments = [];
            let apartmentsItems = ``;

            if ($(this).attr("data-apartments")) {
                apartments = JSON.parse($(this).attr("data-apartments"));
                apartmentsItems = getApartments(apartments);
            }

            let html = ''

            html += `
            <div class="b-visual-floor__add-item">
                <div class="b-visual-floor__add-item-top">
                    <div class="b-visual-floor__add-title">${floor} этаж</div>
                    <div class="b-visual-floor__deadline">
                        <div class="b-visual-floor__deadline-wrapper">
                            <div class="b-visual-floor__deadline-text">
                                 Заселение до ${deadline}
                            </div>
                        </div>
                    </div>
                    <div class="b-visual-floor__count">
                       ${apartCount} ${decLabel(apartCount, ['квартира', 'квартиры', 'квартир'])}
                    </div>
                </div>
                <div class="b-visual-floor__add-item-bottom">
                    <div class="b-visual-floor__row">
                        ${apartmentsItems}
                    </div>
                </div>
                <div class="b-visual-floor__btn-wrapper">
                    <a href="#" class="b-visual__btn">
                         Выбрать этаж
                    </a>
                </div>
            </div>
        `

            $("#visual-floor .b-visual-floor__add-modal").html(html)
            $("#visual-floor").modal("show");
            return false;
        }
    })



    $(`.${context}__contour`).on('mouseleave', function (e) {
        $('.b-visual-floor__add').hide()
    })

    $(`.b-visual-floor__image-scroll`).on("scroll", function () {
        $(`.b-visual-floor__img`).removeClass("b-visual-floor__img_opacity");
        $(`.b-visual-floor__swipe-hand`).hide();
    });



    function getApartments(apartments) {
        let apartmentsItem = ``;

        apartments.forEach((n) => {
            if(n.rooms == 0) {
                apartmentsItem += `
        <div class="b-visual-floor__row-item">
            <div class="b-visual-floor__row-aparts">
                Студия от ${n.quarter} м²
            </div>
            <div class="b-visual-floor__row-price">
                от ${priceFormatter(n.price)} ₽
            </div>
        </div>
        `
            } else {
                apartmentsItem += `
        <div class="b-visual-floor__row-item">
            <div class="b-visual-floor__row-aparts">
                ${n.rooms} - ая квартира от ${n.quarter} м²
            </div>
            <div class="b-visual-floor__row-price">
                от ${priceFormatter(n.price)} ₽
            </div>
        </div>
        `
            }
        })
        return apartmentsItem;
    }

    window.bVisualHouseBitrix = function () {
        $('.b-visual-floor__link').on('click', function () {
            event.preventDefault();
            const parentBlock = $(this).closest('.b-visual-floor');
            const url = $(parentBlock).attr('data-url');
            const iBlock = $(this).attr('data-iblock');
            const type = $(this).attr('data-type');
            const apartmentsId = $(this).attr('data-apartments');
            const projectId = $(this).attr('data-project');
            const houseId = $(this).attr('data-house');
            const floor = $(this).attr('data-floor');
            const loader = $('.b-visual-floor__loader');
            $(loader).addClass('b-visual-floor__loader_visible');
            $( "#b_visual" ).load( url,
                {
                    'IBLOCK': iBlock,
                    'TYPE': type,
                    'APARTMENTS_ID': apartmentsId,
                    'PROJECT_ID': projectId,
                    'HOUSE_ID': houseId,
                    'FLOOR_ID': floor
                },
                function () {
                    bVisualApart()
                    bVisualFloorBitrix()
                    $(loader).removeClass('b-visual-floor__loader_visible');
                }
            );
        })
        $('.b-visual-floor__back').on('click', function() {
            const url = $(this).attr('data-url');
            const iBlock = $(this).attr('data-iblock');
            const type = $(this).attr('data-type');
            const apartmentsId = $(this).attr('data-apartments');
            const projectId = $(this).attr('data-project');
            const loader = $('.b-visual-floor__loader');
            $(loader).addClass('b-visual-floor__loader_visible');
            $( "#b_visual" ).load( url,
                {
                    'IBLOCK': iBlock,
                    'TYPE': type,
                    'APARTMENTS_ID': apartmentsId,
                    'PROJECT_ID': projectId,
                },
                function () {
                    bVisualBitrix();
                    $(loader).removeClass('b-visual-floor__loader_visible');
                }
            );
        })
    }
}
