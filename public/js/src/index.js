import $ from 'jquery';
import 'owl.carousel/dist/assets/owl.carousel.css';
import 'owl.carousel';
import 'bootstrap/dist/js/bootstrap.js';
import '../../libs/awesome/all-min.js';
import '@fortawesome/fontawesome-free'
import '../../less/style.less'
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons'
library.add(fas, far, fab)
import Basket from "./modules/WC/Basket";
import Order from "./modules/WC/Order";
import URLParams from "./modules/URLParams";
import Forms from "./modules/Forms";
import HeightBlocksInGrid from "./modules/HeightBlocksInGrid";
let UrlClass = new URLParams();
document.addEventListener('DOMContentLoaded',
    function()
    {
        new Forms();
        new Basket();
        new Order();
        if(null !== document.querySelector('#search-form'))
        {
            document.querySelector('#search-form').addEventListener('submit', function(e) {
                e.preventDefault();
                location.href='/?'+e.target.getAttribute('data-parameter')+'='+e.target.querySelector('#_input_search').value

            });
        }


        $('.header__location__current, .select_city-js').on('click', function(event) {
            event.preventDefault();

            $('.location_popup').slideToggle()
        });

        $('.location_popup__close').on('click', function(event) {
            event.preventDefault();
            $('.location_popup').slideUp()
        });

        $('.owl-carousel').owlCarousel(
            {
                items:1,
                nav:true,
                dots:false
            }
        );


        const btnBurger = document.querySelector('.burger');
        const mobileMenu = document.querySelectorAll('[data-mobile]');
        document.addEventListener("click",(evt) => {
            if (evt.target.closest('.burger')) {
                btnBurger.classList.toggle('burger--open');
                mobileMenu.forEach(el => {
                    el.classList.toggle('d-none');
                })
            }
        });

        new HeightBlocksInGrid(['article.product-card','.related-products article.tool','.similar-products article.equipment'])

    });//-----[ END document load ]


    function add_sort_attribute(element,value)
    {
        let parameters = {};
        parameters[element.getAttribute('data-parameter')] = value;
        UrlClass.add_urlParams_to_clear_url(parameters);
        // UrlClass.add_urlParams(parameters,true);
    }