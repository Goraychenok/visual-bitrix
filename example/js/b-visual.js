export default function () {
    let context = 'b-visual'

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

    const allCountoursArr = Array.from($(`.${context}__contour`));

     allCountoursArr.forEach(item => {
         if (item.getAttribute('data-status') === 'finish') {
            item.classList.add('b-visual__contour-finished');
         }
    })



    $('.b-visual-floor__add').hide()


    $(`.${context}__img`).on('mousemove', function(e) {
        $(this)[0].style.setProperty('--left', (e.offsetX))
        $(this)[0].style.setProperty('--top', (e.offsetY))
    })

    const url = $(`.${context}__image-wrapper`).attr('data-url');


    $(`.${context}__contour`).on('click mouseenter', function (e) {

        const house = $(this).attr("data-house");
        const deadlinePercent = $(this).attr("data-deadlinePercent");
        const deadlineQuarter = $(this).attr("data-deadlineQuarter");
        const deadlineYear = $(this).attr("data-deadlineYear");
        const apartCount = $(this).attr("data-apartCount");
        const status = $(this).attr("data-status");
        let apartments = [];
        let apartmentsItems = ``;

        if ($(this).attr("data-aparments")) {
            apartments = JSON.parse($(this).attr("data-aparments"));
            apartmentsItems = getApartments(apartments);
        }

        if ($(window).width() / 2 > e.offsetX) {
            $('.b-visual__add').addClass('b-visual__add-left')
        } else {
            $('.b-visual__add').removeClass('b-visual__add-left')
        }

        let html = '';

        if (status === 'key') {
            html += `
            <div class="b-visual__add-item">
                <div class="b-visual__add-title">${house}</div>
                <div class="b-visual__deadline">
                    <div class="b-visual__deadline-wrapper">
                        <div class="b-visual__deadline-text">
                            ${romanize(deadlineQuarter)} к ${deadlineYear} года
                        </div>
                         <div class="b-visual__deadline-percent">
                            ${deadlinePercent} %
                        </div>
                    </div>
                    <div class="b-visual__deadline-progress" style="--percent: ${deadlinePercent} "></div>
                </div>
                <div class="b-visual__count-wrapper">
                     <div class="b-visual__count">
                       ${apartCount} ${decLabel(apartCount, ['квартира', 'квартиры', 'квартир'])}
                    </div>
                    <div class="b-visual__count-key">
                        <div class="b-visual__count-key-text">
                            ключи в этом году
                        </div>
                        <div class="b-visual__count-key-ico">
                           <svg class="" width="12px" height="12px">
                                <use xlink:href="${url}svg-symbols.svg#visual-key"></use>
                           </svg>
                        </div>
                    </div>
                </div>
                <div class="b-visual__row">
                    ${apartmentsItems}
                </div>
            </div>
            `
        }

        if (status === 'sale') {
            html += `
            <div class="b-visual__add-item">
                <div class="b-visual__add-title">${house}</div>
                <div class="b-visual__deadline">
                    <div class="b-visual__deadline-wrapper">
                        <div class="b-visual__deadline-text">
                            ${romanize(deadlineQuarter)} к ${deadlineYear} года
                        </div>
                         <div class="b-visual__deadline-percent">
                            ${deadlinePercent} %
                        </div>
                    </div>
                    <div class="b-visual__deadline-progress" style="--percent: ${deadlinePercent} "></div>
                </div>
                <div class="b-visual__count">
                   ${apartCount} ${decLabel(apartCount, ['квартира', 'квартиры', 'квартир'])}
                </div>
                <div class="b-visual__row">
                    ${apartmentsItems}
                </div>
            </div>
            `
        }

        if( status === 'thunder') {
            html += `
            <div class="b-visual__add-item">
                <div class="b-visual__deadline">
                    <div class="b-visual__deadline-wrapper-sale">
                        <div class="b-visual__deadline-start">
                            старт продаж
                        </div>
                        <div class="b-visual__deadline-text">
                            ${romanize(deadlineQuarter)} к  ${deadlineYear} года
                        </div>
                    </div>
                </div>
            </div>
            `
        }
        if(status === 'finish') {
            $(this).addClass('b-visual__contour-finished')
        }


        $('.b-visual__add-items').html(html)
        $('.b-visual__add').show()

        if ($(window).width() <= 992) {
            const house = $(this).attr("data-house");
            const deadlinePercent = $(this).attr("data-deadlinePercent");
            const deadlineQuarter = $(this).attr("data-deadlineQuarter");
            const deadlineYear = $(this).attr("data-deadlineYear");
            const apartCount = $(this).attr("data-apartCount");
            const status = $(this).attr("data-status");
            let apartments = [];
            let apartmentsItems = ``;

            if ($(this).attr("data-aparments")) {
                apartments = JSON.parse($(this).attr("data-aparments"));
                apartmentsItems = getApartments(apartments);
            }
            let html = '';

            if (status === 'key') {
                html += `
            <div class="b-visual__add-item">
                <div class="b-visual__add-title">${house}</div>
                <div class="b-visual__deadline">
                    <div class="b-visual__deadline-wrapper">
                        <div class="b-visual__deadline-text">
                            ${romanize(deadlineQuarter)} к ${deadlineYear} года
                        </div>
                         <div class="b-visual__deadline-percent">
                            ${deadlinePercent} %
                        </div>
                    </div>
                    <div class="b-visual__deadline-progress" style="--percent: ${deadlinePercent} "></div>
                </div>
                <div class="b-visual__count-wrapper">
                     <div class="b-visual__count">
                       ${apartCount} ${decLabel(apartCount, ['квартира', 'квартиры', 'квартир'])}
                    </div>
                    <div class="b-visual__count-key">
                        <div class="b-visual__count-key-text">
                            ключи в этом году
                        </div>
                        <div class="b-visual__count-key-ico">
                           <svg class="" width="12px" height="12px">
                                <use xlink:href="${url}svg-symbols.svg#visual-key"></use>
                           </svg>
                        </div>
                    </div>
                </div>
                <div class="b-visual__row">
                    ${apartmentsItems}
                </div>
                <div class="b-visual__btn-wrapper">
                     <a href="#" class="b-visual__btn">
                         Выбрать этаж
                    </a>
                </div>
            </div>
            `
            }

            if (status === 'sale') {
                html += `
            <div class="b-visual__add-item">
                <div class="b-visual__add-title">${house}</div>
                <div class="b-visual__deadline">
                    <div class="b-visual__deadline-wrapper">
                        <div class="b-visual__deadline-text">
                            ${romanize(deadlineQuarter)} к ${deadlineYear} года
                        </div>
                         <div class="b-visual__deadline-percent">
                            ${deadlinePercent} %
                        </div>
                    </div>
                    <div class="b-visual__deadline-progress" style="--percent: ${deadlinePercent} "></div>
                </div>
                <div class="b-visual__count">
                   ${apartCount} ${decLabel(apartCount, ['квартира', 'квартиры', 'квартир'])}
                </div>
                <div class="b-visual__row">
                    ${apartmentsItems}
                </div>
                <div class="b-visual__btn-wrapper">
                    <a href="#" class="b-visual__btn">
                         Выбрать этаж
                    </a>
                </div>
            </div>
            `
            }

            if( status === 'thunder') {
                html += `
            <div class="b-visual__add-item">
                <div class="b-visual__deadline">
                    <div class="b-visual__deadline-wrapper-sale">
                        <div class="b-visual__deadline-start">
                            старт продаж
                        </div>
                        <div class="b-visual__deadline-text">
                            ${romanize(deadlineQuarter)} к  ${deadlineYear} года
                        </div>
                    </div>
                </div>
            </div>
            `
            }
            if(status === 'finish') {
                $(this).addClass('b-visual__contour-finished')
            }
            $("#visual .b-visual__add-modal").html(html)
            $("#visual").modal("show");
            return false;
        }
    })

    $(`.b-visual__image-scroll`).on("scroll", function () {
        $(`.b-visual__img`).removeClass("b-visual__img_opacity");
        $(`.b-visual__swipe-hand`).hide();
    });

    $(`.${context}__contour`).on('mouseleave', function (e) {
        $('.b-visual__add').hide()
    })


    onMobile();
    $(`.${context}__markers`).html("");
    $(`.${context}__link`).each(function (
        i,
        e
    ) {
        const $path = $(this).find("path");
        const parentRect = $(`.${context}__img`)[0].getBoundingClientRect();
        const rect = $path[0].getBoundingClientRect();

        const left = rect.left - parentRect.left / 20;
        const top = rect.top - parentRect.top;
        // const width = rect.width;
        // const height = rect.height;

        const house = $path.attr("data-house");
        const id = $path.attr("data-id");
        const status = $path.attr("data-status")
        let ico = ''
        let finishClass =  ""

        switch (status) {
            case 'key':
                ico = 'visual-key'
                break;
            case 'thunder':
                ico = 'visual-sale'
                break;
            case 'finish':
                finishClass = 'b-visual__marker-finish'
                break;
        }

        if (ico === 'visual-key' || ico === 'visual-sale') {
            $(`.${context}__markers`).append(`
            <div data-id="${id}" class="${context}__marker" style="left: ${left}px;top: ${top}px;">
                <div class="b-visual__marker-wrapper">
                    <div class="b-visual__marker-ico">
                       <svg class="" width="16px" height="16px">
                            <use xlink:href="${url}svg-symbols.svg#${ico}"></use>
                       </svg>
                    </div>
                    <div class="b-visual__marker-text">${house}</div>
                </div>
            </div>
        `);
        } else {
            $(`.${context}__markers`).append(`
            <div data-id="${id}" class="${context}__marker ${finishClass}" style="left: ${left}px;top: ${top}px;">
                <div class="b-visual__marker-wrapper">
                    <div class="b-visual__marker-ico"></div>
                    <div class="b-visual__marker-text">${house}</div>
                </div>
            </div>
        `);
        }
    });

    function onMobile() {
        $(window).on('resize'), function () {
            $(`.${context}__markers`).html("");
            $(`.${context}__link`).each(function (
                i,
                e
            ) {
                const $path = $(this).find("path");
                const parentRect = $(`.${context}__img`)[0].getBoundingClientRect();
                const rect = $path[0].getBoundingClientRect();

                const left = rect.left - parentRect.left / 20;
                const top = rect.top - parentRect.top;
                // const width = rect.width;
                // const height = rect.height;

                const house = $path.attr("data-house");
                const id = $path.attr("data-id");
                const status = $path.attr("data-status")
                let ico = ''
                let finishClass =  ""

                switch (status) {
                    case 'key':
                        ico = 'visual-key'
                        break;
                    case 'thunder':
                        ico = 'visual-sale'
                        break;
                    case 'finish':
                        finishClass = 'b-visual__marker-finish'
                        break;
                }

                if (ico === 'visual-key' || ico === 'visual-sale') {
                    $(`.${context}__markers`).append(`
            <div data-id="${id}" class="${context}__marker" style="left: ${left}px;top: ${top}px;">
                <div class="b-visual__marker-wrapper">
                    <div class="b-visual__marker-ico">
                       <svg class="" width="16px" height="16px">
                            <use xlink:href="${url}svg-symbols.svg#${ico}"></use>
                       </svg>
                    </div>
                    <div class="b-visual__marker-text">${house}</div>
                </div>
            </div>
        `);
                } else {
                    $(`.${context}__markers`).append(`
            <div data-id="${id}" class="${context}__marker ${finishClass}" style="left: ${left}px;top: ${top}px;">
                <div class="b-visual__marker-wrapper">
                    <div class="b-visual__marker-ico"></div>
                    <div class="b-visual__marker-text">${house}</div>
                </div>
            </div>
        `);
                }
            });
        }
    }
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

    $(document).ready(function () {
        $('.b-visual__link').on('click', function () {
            event.preventDefault();
            const parentBlock = $(this).closest('.page__b-visual');
            const url = $(parentBlock).attr('data-url');
            const iBlock = $(parentBlock).attr('data-iblock');
            const type = $(parentBlock).attr('data-type');
            const apartmentsId = $(parentBlock).attr('data-apartments');
            const projectId = $(parentBlock).attr('data-project');
            const houseId = $(this).attr('data-house');
            $( "#b_visual" ).load( url,
                {
                    'IBLOCK': iBlock,
                    'TYPE': type,
                    'APARTMENTS_ID': apartmentsId,
                    'PROJECT_ID': projectId,
                    'HOUSE_ID': houseId
                },
                function () {
                    bVisualFloor();
                    bVisualHouseBitrix();
                }
            );
        })
    })

    window.bVisualBitrix = function () {
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

        const allCountoursArr = Array.from($(`.${context}__contour`));

        allCountoursArr.forEach(item => {
            if (item.getAttribute('data-status') === 'finish') {
                item.classList.add('b-visual__contour-finished');
            }
        })



        $('.b-visual-floor__add').hide()


        $(`.${context}__img`).on('mousemove', function(e) {
            $(this)[0].style.setProperty('--left', (e.offsetX))
            $(this)[0].style.setProperty('--top', (e.offsetY))
        })

        const url = $(`.${context}__image-wrapper`).attr('data-url');


        $(`.${context}__contour`).on('click mouseenter', function (e) {

            const house = $(this).attr("data-house");
            const deadlinePercent = $(this).attr("data-deadlinePercent");
            const deadlineQuarter = $(this).attr("data-deadlineQuarter");
            const deadlineYear = $(this).attr("data-deadlineYear");
            const apartCount = $(this).attr("data-apartCount");
            const status = $(this).attr("data-status");
            let apartments = [];
            let apartmentsItems = ``;

            if ($(this).attr("data-aparments")) {
                apartments = JSON.parse($(this).attr("data-aparments"));
                apartmentsItems = getApartments(apartments);
            }

            if ($(window).width() / 2 > e.offsetX) {
                $('.b-visual__add').addClass('b-visual__add-left')
            } else {
                $('.b-visual__add').removeClass('b-visual__add-left')
            }

            let html = '';

            if (status === 'key') {
                html += `
            <div class="b-visual__add-item">
                <div class="b-visual__add-title">${house}</div>
                <div class="b-visual__deadline">
                    <div class="b-visual__deadline-wrapper">
                        <div class="b-visual__deadline-text">
                            ${romanize(deadlineQuarter)} к ${deadlineYear} года
                        </div>
                         <div class="b-visual__deadline-percent">
                            ${deadlinePercent} %
                        </div>
                    </div>
                    <div class="b-visual__deadline-progress" style="--percent: ${deadlinePercent} "></div>
                </div>
                <div class="b-visual__count-wrapper">
                     <div class="b-visual__count">
                       ${apartCount} ${decLabel(apartCount, ['квартира', 'квартиры', 'квартир'])}
                    </div>
                    <div class="b-visual__count-key">
                        <div class="b-visual__count-key-text">
                            ключи в этом году
                        </div>
                        <div class="b-visual__count-key-ico">
                           <svg class="" width="12px" height="12px">
                                <use xlink:href="${url}svg-symbols.svg#visual-key"></use>
                           </svg>
                        </div>
                    </div>
                </div>
                <div class="b-visual__row">
                    ${apartmentsItems}
                </div>
            </div>
            `
            }

            if (status === 'sale') {
                html += `
            <div class="b-visual__add-item">
                <div class="b-visual__add-title">${house}</div>
                <div class="b-visual__deadline">
                    <div class="b-visual__deadline-wrapper">
                        <div class="b-visual__deadline-text">
                            ${romanize(deadlineQuarter)} к ${deadlineYear} года
                        </div>
                         <div class="b-visual__deadline-percent">
                            ${deadlinePercent} %
                        </div>
                    </div>
                    <div class="b-visual__deadline-progress" style="--percent: ${deadlinePercent} "></div>
                </div>
                <div class="b-visual__count">
                   ${apartCount} ${decLabel(apartCount, ['квартира', 'квартиры', 'квартир'])}
                </div>
                <div class="b-visual__row">
                    ${apartmentsItems}
                </div>
            </div>
            `
            }

            if( status === 'thunder') {
                html += `
            <div class="b-visual__add-item">
                <div class="b-visual__deadline">
                    <div class="b-visual__deadline-wrapper-sale">
                        <div class="b-visual__deadline-start">
                            старт продаж
                        </div>
                        <div class="b-visual__deadline-text">
                            ${romanize(deadlineQuarter)} к  ${deadlineYear} года
                        </div>
                    </div>
                </div>
            </div>
            `
            }
            if(status === 'finish') {
                $(this).addClass('b-visual__contour-finished')
            }


            $('.b-visual__add-items').html(html)
            $('.b-visual__add').show()

            if ($(window).width() <= 992) {
                const house = $(this).attr("data-house");
                const deadlinePercent = $(this).attr("data-deadlinePercent");
                const deadlineQuarter = $(this).attr("data-deadlineQuarter");
                const deadlineYear = $(this).attr("data-deadlineYear");
                const apartCount = $(this).attr("data-apartCount");
                const status = $(this).attr("data-status");
                let apartments = [];
                let apartmentsItems = ``;

                if ($(this).attr("data-aparments")) {
                    apartments = JSON.parse($(this).attr("data-aparments"));
                    apartmentsItems = getApartments(apartments);
                }
                let html = '';

                if (status === 'key') {
                    html += `
            <div class="b-visual__add-item">
                <div class="b-visual__add-title">${house}</div>
                <div class="b-visual__deadline">
                    <div class="b-visual__deadline-wrapper">
                        <div class="b-visual__deadline-text">
                            ${romanize(deadlineQuarter)} к ${deadlineYear} года
                        </div>
                         <div class="b-visual__deadline-percent">
                            ${deadlinePercent} %
                        </div>
                    </div>
                    <div class="b-visual__deadline-progress" style="--percent: ${deadlinePercent} "></div>
                </div>
                <div class="b-visual__count-wrapper">
                     <div class="b-visual__count">
                       ${apartCount} ${decLabel(apartCount, ['квартира', 'квартиры', 'квартир'])}
                    </div>
                    <div class="b-visual__count-key">
                        <div class="b-visual__count-key-text">
                            ключи в этом году
                        </div>
                        <div class="b-visual__count-key-ico">
                           <svg class="" width="12px" height="12px">
                                <use xlink:href="${url}svg-symbols.svg#visual-key"></use>
                           </svg>
                        </div>
                    </div>
                </div>
                <div class="b-visual__row">
                    ${apartmentsItems}
                </div>
                <div class="b-visual__btn-wrapper">
                     <a href="#" class="b-visual__btn">
                         Выбрать этаж
                    </a>
                </div>
            </div>
            `
                }

                if (status === 'sale') {
                    html += `
            <div class="b-visual__add-item">
                <div class="b-visual__add-title">${house}</div>
                <div class="b-visual__deadline">
                    <div class="b-visual__deadline-wrapper">
                        <div class="b-visual__deadline-text">
                            ${romanize(deadlineQuarter)} к ${deadlineYear} года
                        </div>
                         <div class="b-visual__deadline-percent">
                            ${deadlinePercent} %
                        </div>
                    </div>
                    <div class="b-visual__deadline-progress" style="--percent: ${deadlinePercent} "></div>
                </div>
                <div class="b-visual__count">
                   ${apartCount} ${decLabel(apartCount, ['квартира', 'квартиры', 'квартир'])}
                </div>
                <div class="b-visual__row">
                    ${apartmentsItems}
                </div>
                <div class="b-visual__btn-wrapper">
                    <a href="#" class="b-visual__btn">
                         Выбрать этаж
                    </a>
                </div>
            </div>
            `
                }

                if( status === 'thunder') {
                    html += `
            <div class="b-visual__add-item">
                <div class="b-visual__deadline">
                    <div class="b-visual__deadline-wrapper-sale">
                        <div class="b-visual__deadline-start">
                            старт продаж
                        </div>
                        <div class="b-visual__deadline-text">
                            ${romanize(deadlineQuarter)} к  ${deadlineYear} года
                        </div>
                    </div>
                </div>
            </div>
            `
                }
                if(status === 'finish') {
                    $(this).addClass('b-visual__contour-finished')
                }
                $("#visual .b-visual__add-modal").html(html)
                $("#visual").modal("show");
                return false;
            }
        })

        $(`.b-visual__image-scroll`).on("scroll", function () {
            $(`.b-visual__img`).removeClass("b-visual__img_opacity");
            $(`.b-visual__swipe-hand`).hide();
        });

        $(`.${context}__contour`).on('mouseleave', function (e) {
            $('.b-visual__add').hide()
        })


        onMobile();
        $(`.${context}__markers`).html("");
        $(`.${context}__link`).each(function (
            i,
            e
        ) {
            const $path = $(this).find("path");
            const parentRect = $(`.${context}__img`)[0].getBoundingClientRect();
            const rect = $path[0].getBoundingClientRect();

            const left = rect.left - parentRect.left / 20;
            const top = rect.top - parentRect.top;
            // const width = rect.width;
            // const height = rect.height;

            const house = $path.attr("data-house");
            const id = $path.attr("data-id");
            const status = $path.attr("data-status")
            let ico = ''
            let finishClass =  ""

            switch (status) {
                case 'key':
                    ico = 'visual-key'
                    break;
                case 'thunder':
                    ico = 'visual-sale'
                    break;
                case 'finish':
                    finishClass = 'b-visual__marker-finish'
                    break;
            }

            if (ico === 'visual-key' || ico === 'visual-sale') {
                $(`.${context}__markers`).append(`
            <div data-id="${id}" class="${context}__marker" style="left: ${left}px;top: ${top}px;">
                <div class="b-visual__marker-wrapper">
                    <div class="b-visual__marker-ico">
                       <svg class="" width="16px" height="16px">
                            <use xlink:href="${url}svg-symbols.svg#${ico}"></use>
                       </svg>
                    </div>
                    <div class="b-visual__marker-text">${house}</div>
                </div>
            </div>
        `);
            } else {
                $(`.${context}__markers`).append(`
            <div data-id="${id}" class="${context}__marker ${finishClass}" style="left: ${left}px;top: ${top}px;">
                <div class="b-visual__marker-wrapper">
                    <div class="b-visual__marker-ico"></div>
                    <div class="b-visual__marker-text">${house}</div>
                </div>
            </div>
        `);
            }
        });

        function onMobile() {
            $(window).on('resize'), function () {
                $(`.${context}__markers`).html("");
                $(`.${context}__link`).each(function (
                    i,
                    e
                ) {
                    const $path = $(this).find("path");
                    const parentRect = $(`.${context}__img`)[0].getBoundingClientRect();
                    const rect = $path[0].getBoundingClientRect();

                    const left = rect.left - parentRect.left / 20;
                    const top = rect.top - parentRect.top;
                    // const width = rect.width;
                    // const height = rect.height;

                    const house = $path.attr("data-house");
                    const id = $path.attr("data-id");
                    const status = $path.attr("data-status")
                    let ico = ''
                    let finishClass =  ""

                    switch (status) {
                        case 'key':
                            ico = 'visual-key'
                            break;
                        case 'thunder':
                            ico = 'visual-sale'
                            break;
                        case 'finish':
                            finishClass = 'b-visual__marker-finish'
                            break;
                    }

                    if (ico === 'visual-key' || ico === 'visual-sale') {
                        $(`.${context}__markers`).append(`
            <div data-id="${id}" class="${context}__marker" style="left: ${left}px;top: ${top}px;">
                <div class="b-visual__marker-wrapper">
                    <div class="b-visual__marker-ico">
                       <svg class="" width="16px" height="16px">
                            <use xlink:href="${url}svg-symbols.svg#${ico}"></use>
                       </svg>
                    </div>
                    <div class="b-visual__marker-text">${house}</div>
                </div>
            </div>
        `);
                    } else {
                        $(`.${context}__markers`).append(`
            <div data-id="${id}" class="${context}__marker ${finishClass}" style="left: ${left}px;top: ${top}px;">
                <div class="b-visual__marker-wrapper">
                    <div class="b-visual__marker-ico"></div>
                    <div class="b-visual__marker-text">${house}</div>
                </div>
            </div>
        `);
                    }
                });
            }
        }
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

        $(document).ready(function () {
            $('.b-visual__link').on('click', function () {
                event.preventDefault();
                const parentBlock = $(this).closest('.page__b-visual');
                const url = $(parentBlock).attr('data-url');
                const iBlock = $(parentBlock).attr('data-iblock');
                const type = $(parentBlock).attr('data-type');
                const apartmentsId = $(parentBlock).attr('data-apartments');
                const projectId = $(parentBlock).attr('data-project');
                const houseId = $(this).attr('data-house');
                $( "#b_visual" ).load( url,
                    {
                        'IBLOCK': iBlock,
                        'TYPE': type,
                        'APARTMENTS_ID': apartmentsId,
                        'PROJECT_ID': projectId,
                        'HOUSE_ID': houseId
                    },
                    function () {
                        bVisualFloor();
                        bVisualHouseBitrix();
                    }
                );
            })
        })
    }

}
