export const Config =
    {
        tabs:
            [
                {
                    selector:'.tabs-cat',
                },
            ],
        modules:
            {
                tabs:
                    {
                        selectors:
                            {
                                links:'.link',
                                tabs:'.content',
                                active:'active'
                            },
                    },
                numberDivision:
                    {
                        selector:'.number-division'
                    },
                mapWrapper:
                    {
                        selector:'section.map',
                        mapWrapperContent:"Нажмите,что бы воспользоваться картой"
                    },
                heightBlocksInGrid:
                    {
                        selectors:
                            [
                                '.carousel-card  .card-furniture',
                                '.cases .card-furniture',
                                '.catalog-all .card-furniture'
                            ],
                    },
                FilterItems:
                    [
                        {
                            control:'.cases .nav-wrapper li',
                            items:'.cases .wrapper .card-furniture',
                            bootstrap:true,
                        },
                        {
                            control:'.catalog-all .sidebar nav li',
                            items:'.catalog-all .card_product',
                            bootstrap:true,
                        },
                    ],
                searchForm:
                    {
                        selectors:
                            {
                                wrapper:'._search_form_wrapper',
                                typeField:'select._field_type',
                                manufacturerField:'select._field_manufacturer',
                                textField:'input._field_text',
                                btn:'._btn_search',
                                close:'.close',
                                response:'.home_catalog__filter__response',
                                responseItem:'.item'
                            },
                    },
                loadProducts:
                    {
                        selectors:
                            {
                                product:
                                    {
                                        wrapper: '.catalog__list',
                                        item:'.shortcard',
                                        card:
                                            {
                                                shortcard_thumb_link:'a.shortcard__thumb',
                                                shortcard_thumb_img:'a.shortcard__thumb img',
                                                compatibilityElements:'.shortcard__compatibility ul',
                                                article:'.shortcard__header .article span',
                                                title:'.shortcard__header .shortcard__title',
                                                priceElements:'.shortcard__price',
                                                addBasket:'.add_basket',
                                                dimensions:'.shortcard__params ul',
                                                dimensionLabel:'.label',
                                            }
                                    },
                                loadMore:
                                    {
                                        btn:'._btn_load_more'
                                    },
                                filters:
                                    {
                                        btn:'.enter_filter_btn',
                                        reset:'.reset_filter_btn',
                                        firstCat:'.cat_first',
                                        secondCat:'.cat_second',
                                        thirdCat:'.cat_third',
                                        minPrice:'.price_min',
                                        maxPrice:'.price_max',
                                        manufacturers:'.manufacturers'
                                    }

                            },
                        action:'load_products'
                    },
                basket:
                    {
                        selectors:
                            {
                                btn:'.add_to_cart',
                                countElement:'._basket_amount',
                                priceElement:'._basket_price',
                                inputQuantity:'[data-action="minus"],[data-action="plus"]',
                                table:'.cart__table',
                                lineTotalPrice:'.cart__itm__res',
                                row:'.row.cart__itm',
                                btnDeleteProducts:'.dell-select'
                            },
                        classes:
                            {
                                add:'add_to_basket',
                                remove:'remove_from_basket',
                                inputQuantity:'control',
                                load:'load'
                            },
                        attributes:
                            {
                                id:'data-id',
                                emptyBasket:'data-empty',
                                key:'data-key',
                                currency:'data-currency'
                            },
                        actions:
                            {
                                add:'add_to_basket',
                                remove:'remove_from_basket',
                                quantity:'change_quantity_in_basket'
                            },
                    },
                order:
                    {
                        selectors:
                            {
                                wrapper:'#order-popup',

                                inputAddress:'.inputAddress',
                                inputComment: '.inputComment',
                                // inputStreet:'.inputStreet',
                                //
                                // inputHouse:'.inputHouse',
                                //
                                // inputAppartment:'.inputAppartment',
                                //
                                // inputIndex:'.inputIndex',

                                inputName:'.inputName',

                                inputPhone:'.inputPhone',

                                inputEmail:'.inputEmail',

                                btn:'.order'
                            },
                        action:'order'
                    },
                changeCity:
                    {
                        selectors:
                            {
                                selectCity:'.change_city',
                                address:'.change_address',
                                phone:'.change_phone',
                                email:'.change_email',
                                closeWindowButton:'.location_popup__close',
                                cityLabel:'.current_city',
                                mapWrapper:'.contacts #map'
                            },
                        attributes:
                            {
                                address:'data-address',
                                phone:'data-phone',
                                email:'data-email',
                                mapX:'data-mapx',
                                mapY:'data-mapy',
                                mapCaption:'data-mapcaption',
                            }
                    }


            },
    };

export const carousels =
    [
        {
            selector:'.owl-carousel-card',
            options:
                {
                    items:3,
                    dots:false,
                    nav:true,
                    mouseDrag:false,
                    navElement:'nav',
                    loop:true,
                    responsive : {
                        0 : {
                            items:1,
                        },
                        768 : {
                            items:3,
                        }
                    }
                },
        },
        {
            selector:'.carousel-img',
            options:
                {
                    items:1,
                    dots:true,
                    nav:true,
                    loop:true,
                },
        },
        {
            selector:'.carousel-imgContent .owl-carousel',
            options:
                {
                    items:3,
                    nav:true,
                    loop:true,
                    dots:false,
                    responsive : {
                        0 : {
                            items:1,
                        },
                        768 : {
                            items:3,
                        }
                    }
                },
        },
        {
            selector:'.carousel_characters',
            options:
                {
                    items:1,
                    nav:true,
                    // loop:true,
                    dots:true,
                },
        },
        {
            selector:'.carousel-img-threeColumns',
            options:
                {
                    items:3,
                    dots:false,
                    nav:true,
                    loop:true,
                    responsive : {
                        0 : {
                            items:1,
                        },
                        768 : {
                            items:3,
                        }
                    }
                },
        },
    ];

export const carouselsConfig =
    {
        classes: [ 'owl-theme','owl-carousel'],
    };

export const  formConfig =
    {
        'selectors' :
            {
                'forms':'form._form',
                'send':'.send',
                'response':'.response',
            },
        'action': 'send_form'
    };

export const fancyBoxConfig =
    {
        selector:'.fancybox',
        selectorGallery:'[data-fancybox-warpper]',
        classNameZoom:'icon_zoom',
        options:
            {
                type:'image',
                opts:
                    {
                        modal:true,
                        showCloseButton:true,
                        hideOnContentClick:true,
                    },

            },
    };