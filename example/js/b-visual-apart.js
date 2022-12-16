export default function () {
    let context = "b-visual-apart";

    if ($(`.${context}`).length == 0) {
        return;
    }

    let swiperMobile = new Swiper(`.b-visual-apart__floor-cont_mobile .b-visual-apart__swiper-container-mobile`, {
        direction: "horizontal",
        slidesPerView: 5,
        spaceBetween: 10,
        initialSlide: $('.b-visual-apart__floor-cont_mobile').find("[data-current]").index() - 2,
    });
    let swiper = new Swiper(`.${context} .swiper-container`, {
        direction: "vertical",
        slidesPerView: 5,
        spaceBetween: 10,
        initialSlide: $(`.${context}`).find("[data-current]").index() - 2,

        navigation: {
            nextEl: $(`.${context}`).find(".swiper-button-next"),
            prevEl: $(`.${context}`).find(".swiper-button-prev"),
        },
    });



    $(`.${context}__img`).on('mousemove', function(e) {
        $(this)[0].style.setProperty('--left', (e.offsetX))
        $(this)[0].style.setProperty('--top', (e.offsetY))
    })

    $(`.${context}__img-small`).on('mousemove', function(e) {
        $(this)[0].style.setProperty('--left', (e.offsetX))
        $(this)[0].style.setProperty('--top', (e.offsetY))
    })




    $(`.${context}__contour`).on("mouseenter", function (e) {
        const name = $(this).attr("data-name");
        const items = JSON.parse($(this).attr("data-items") || "");

        $(".b-visual-apart__add-title").text(name);
        let html = "";
        items.forEach((n) => {
            html += `
<div class="b-visual-apart__add-item">${n.name}:<span>${n.val}</span>
                                                                 </div>
            `;
        });
        $(".b-visual-apart__add-items").html(html);
        $(".b-visual-apart__add").show();
    });

    $(`.${context}__contour`).on("mouseleave", function (e) {
        $(".b-visual-apart__add").hide();
    });

    onMobile();
    $(`.${context}__markers`).html("");
    $(`.${context}__link_in-sale, .${context}__link_bron, .${context}__link_sold`).each(function (
        i,
        e
    ) {
        const $path = $(this).find("path");
        const parentRect = $(`.${context}__img`)[0].getBoundingClientRect();
        const rect = $path[0].getBoundingClientRect();

        const left = rect.left - parentRect.left;
        const top = rect.top - parentRect.top;
        const width = rect.width;
        const height = rect.height;

        const rooms = $path.attr("data-rooms");
        const status = $path.attr("data-status");
        const id = $path.attr("data-id");



        if(status === 'in-sale') {
            if(rooms == 0) {
                $(`.${context}__markers`).append(`
            <div data-id="${id}" class="${context}__marker ${context}__marker_${status}" style="left: ${left}px;top: ${top}px;width: ${width}px;height: ${height}px;">
                <div class="${context}__marker-content">
                    <div class="${context}__marker-rooms">Студия</div>
                </div>
            </div>
        `);
            } else {
                $(`.${context}__markers`).append(`
            <div data-id="${id}" class="${context}__marker ${context}__marker_${status}" style="left: ${left}px;top: ${top}px;width: ${width}px;height: ${height}px;">
                <div class="${context}__marker-content">
                    <div class="${context}__marker-rooms">${rooms}К</div>
                </div>
            </div>
        `);
            }
        }

        if(status === 'bron') {
            $(`.${context}__markers`).append(`
            <div data-id="${id}" class="${context}__marker ${context}__marker_${status}" style="left: ${left}px;top: ${top}px;width: ${width}px;height: ${height}px;">
                <div class="${context}__marker-content">
                    <div class="${context}__marker-rooms ${context}__marker-rooms_bron">бронь</div>
                </div>
            </div>
        `);
        }

        if(status === 'sold') {
            $(`.${context}__markers`).append(`
            <div data-id="${id}" class="${context}__marker ${context}__marker_${status}" style="left: ${left}px;top: ${top}px;width: ${width}px;height: ${height}px;">
                <div class="${context}__marker-content">
                    <div class="${context}__marker-rooms ${context}__marker-rooms_sold">продано</div>
                </div>
            </div>
        `);
        }

    });

    function onMobile() {
        $(window).on("resize", function () {
            $(`.${context}__markers`).html("");
            $(`.${context}__link_in-sale, .${context}__link_bron, .${context}__link_sold`).each(function (
                i,
                e
            ) {
                const $path = $(this).find("path");
                const parentRect = $(`.${context}__img`)[0].getBoundingClientRect();
                const rect = $path[0].getBoundingClientRect();

                const left = rect.left - parentRect.left;
                const top = rect.top - parentRect.top;
                const width = rect.width;
                const height = rect.height;

                const rooms = $path.attr("data-rooms");
                const status = $path.attr("data-status");
                const id = $path.attr("data-id");



                if(status === 'in-sale') {
                    $(`.${context}__markers`).append(`
            <div data-id="${id}" class="${context}__marker ${context}__marker_${status}" style="left: ${left}px;top: ${top}px;width: ${width}px;height: ${height}px;">
                <div class="${context}__marker-content">
                    <div class="${context}__marker-rooms">${rooms}К</div>
                </div>
            </div>
        `);
                }

                if(status === 'bron') {
                    $(`.${context}__markers`).append(`
            <div data-id="${id}" class="${context}__marker ${context}__marker_${status}" style="left: ${left}px;top: ${top}px;width: ${width}px;height: ${height}px;">
                <div class="${context}__marker-content">
                    <div class="${context}__marker-rooms ${context}__marker-rooms_bron">бронь</div>
                </div>
            </div>
        `);
                }

                if(status === 'sold') {
                    $(`.${context}__markers`).append(`
            <div data-id="${id}" class="${context}__marker ${context}__marker_${status}" style="left: ${left}px;top: ${top}px;width: ${width}px;height: ${height}px;">
                <div class="${context}__marker-content">
                    <div class="${context}__marker-rooms ${context}__marker-rooms_sold">продано</div>
                </div>
            </div>
        `);
                }

            });
        });
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

    function romanize(num) {
        let lookup = {M:1000,CM:900,D:500,CD:400,C:100,XC:90,L:50,XL:40,X:10,IX:9,V:5,IV:4,I:1},roman = '',i;
        for ( i in lookup ) {
            while ( num >= lookup[i] ) {
                roman += i;
                num -= lookup[i];
            }
        }
        return roman;
    }

    $(`.b-visual-apart__contour-bg`).on("mouseover", function (e) {
        const id = $(this).attr("data-id");
        $(`.b-visual-apart__marker[data-id='${id}']`).addClass(
            `b-visual-apart__marker_hover`
        );
    });

    $(`.b-visual-apart__contour-bg`).on("mouseleave", function (e) {
        const id = $(this).attr("data-id");
        $(`.b-visual-apart__marker[data-id='${id}']`).removeClass(
            `b-visual-apart__marker_hover`
        );
    });

    $(`.b-visual-apart__image-scroll`).on("scroll", function () {
        $(`.b-visual-apart__img`).removeClass("b-visual-apart__img_opacity");
        $(`.b-visual-apart__swipe-hand`).hide();
    });

    $(".b-visual-apart__link-small").on("click mouseenter", function (e) {

        let currentItem = $(this).find(".b-visual-apart__contour-bg");
        $(`.b-visual-apart__desc-small`).css("opacity", 1);
        let img = $(currentItem).attr('data-img')


        let html = `<img src="${img}"></img>`

        $(`.b-visual-apart__desc-small`).html(html)
    });
    $(".b-visual-apart__link-small").on("click mouseleave", function () {
        if ($(window).width() <= 1024) {
            return;
        }
        $(`.b-visual-apart__desc-small`).css("opacity", 0);
    });

    const houseSmall = $(".b-visual-apart__link-small").find(".b-visual-apart__contour-bg");

    $(houseSmall).each(function (i, item) {
       if($(item).attr('data-current') === 'true') {
           $(item).addClass('b-visual-apart__contour-bg_active');
       }
        if($(item).attr('data-hidden') === 'true') {
            $(item).addClass('b-visual-apart__contour-bg_hidden');
        }
    })



    $(".b-visual-apart__link").on("click mouseenter", function (e) {

        let currentItem = $(this).find(".b-visual-apart__contour-bg");

        $(`.b-visual-apart__desc`).css("opacity", 1);

        let price = $(currentItem).attr("data-price");
        let area = $(currentItem).attr("data-area");
        let floor = $(currentItem).attr("data-floor");
        let rooms = $(currentItem).attr("data-rooms");
        let quarter = $(currentItem).attr('data-quarter');
        let year = $(currentItem).attr("data-year");
        let number = $(currentItem).attr("data-number");
        let img = $(currentItem).attr('data-img')

        if(rooms == 0) {
            $(`.b-visual-apart__desc-title`).text(`Cтудия`);
        } else {
            $(`.b-visual-apart__desc-title`).text(`${rooms}-ая квартира `);
        }

        if ($(window).width() / 2 < e.offsetX) {
            $('.b-visual-apart__desc').addClass('b-visual-apart__desc-right')
        } else {
            $('.b-visual-apart__desc').removeClass('b-visual-apart__desc-right')
        }

        $(`.b-visual-apart__new-price`).text(priceFormatter(price) + " ₽");
        $(`.b-visual-apart__desc-area`).text(`${area} м²`);
        $(`.b-visual-apart__desc-floor`).text(floor);
        $(`.b-visual-apart__desc-deadline`).text(`${romanize(quarter)} к  ${year} года `);


        if ($(window).width() <= 992) {

            $("#visual").modal("show");
            return false;
        }
    });
    $(".b-visual-apart__link").on("click mouseleave", function () {
        if ($(window).width() <= 1024) {
            return;
        }
        $(`.b-visual-apart__desc`).css("opacity", 0);
        $(`.b-visual-apart__desc-small`).css("opacity", 0);
    });

    window.bVisualFloorBitrix = function () {
        $('.b-visual-apart__link-small').on('click', function () {
            event.preventDefault();
            const parentBlock = $(this).closest('.b-visual-apart__aside');
            const url = $(parentBlock).attr('data-url');
            const iBlock = $(this).attr('data-iblock');
            const type = $(this).attr('data-type');
            const apartmentsId = $(this).attr('data-apartments');
            const projectId = $(this).attr('data-project');
            const houseId = $(this).attr('data-house');
            const loader = $('.b-visual-apart__loader');
            $(loader).addClass('b-visual-apart__loader_visible');
            $( "#b_visual" ).load( url,
                {
                    'IBLOCK': iBlock,
                    'TYPE': type,
                    'APARTMENTS_ID': apartmentsId,
                    'PROJECT_ID': projectId,
                    'HOUSE_ID': houseId,
                },
                function () {
                    bVisualFloor();
                    bVisualHouseBitrix();
                    $(loader).removeClass('b-visual-apart__loader_visible');
                }
            );
        });

        $('.b-visual-apart__floor-item').on('click', function () {
            event.preventDefault();
            const parentBlock = $(this).closest('.b-visual-apart__floor-slider');
            const url = $(parentBlock).attr('data-url');
            const iBlock = $(this).attr('data-iblock');
            const type = $(this).attr('data-type');
            const apartmentsId = $(this).attr('data-apartments');
            const projectId = $(this).attr('data-project');
            const houseId = $(this).attr('data-house');
            const floor = $(this).attr('data-floor');
            const loader = $('.b-visual-apart__loader');
            $(loader).addClass('b-visual-apart__loader_visible');
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
                    $(loader).removeClass('b-visual-apart__loader_visible');
                }
            );
        })

        $('.b-visual-apart__back').on('click', function() {
            const url = $(this).attr('data-url');
            const iBlock = $(this).attr('data-iblock');
            const type = $(this).attr('data-type');
            const apartmentsId = $(this).attr('data-apartments');
            const projectId = $(this).attr('data-project');
            const houseId = $(this).attr('data-house');
            const loader = $('.b-visual-apart__loader');
            $(loader).addClass('b-visual-apart__loader_visible');
            $( "#b_visual" ).load( url,
                {
                    'IBLOCK': iBlock,
                    'TYPE': type,
                    'APARTMENTS_ID': apartmentsId,
                    'PROJECT_ID': projectId,
                    'HOUSE_ID': houseId,
                },
                function () {
                    bVisualFloor();
                    bVisualHouseBitrix();
                    $(loader).removeClass('b-visual-apart__loader_visible');
                }
            );
        })

    }

    $('.b-visual-apart__info').append(`
    <div class="b-visual-apart__info-item">
      <div class="b-visual-apart__info-name">Дом
      </div>
      <div class="b-visual-apart__info-desc">${$('.b-visual-apart__info').attr('data-number')}
      </div>
    </div>
    <div class="b-visual-apart__info-item">
      <div class="b-visual-apart__info-name">Этаж
      </div>
      <div class="b-visual-apart__info-desc">${$('.b-visual-apart__info').attr('data-frame')}
      </div>
    </div>
    <div class="b-visual-apart__info-item">
      <div class="b-visual-apart__info-name">Срок сдачи
      </div>
      <div class="b-visual-apart__info-desc"> ${romanize($('.b-visual-apart__info').attr('data-quarter'))} кв. ${$('.b-visual-apart__info').attr('data-year')} г.
      </div>
    </div>
    <div class="b-visual-apart__info-item">
      <div class="b-visual-apart__info-name">Квартир в продаже
      </div>
      <div class="b-visual-apart__info-desc">${$('.b-visual-apart__info').attr('data-count')}
      </div>
    </div>

        `
    );

}

