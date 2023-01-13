import {Config} from "../../settings";
import {queryElement} from "../../common";
import AddHandlerForEvent from "../../Controllers/AddHandlerForEvent";
import Basket from "../WC/Basket";
const config = Config.modules.loadProducts.selectors.product
const attributes = Config.modules.basket.attributes;

export default class Products
{
    constructor()
    {
        this.wrapper = config.wrapper;
        this.productClone = config.item;
        this.products = config.item;
        this.attributeId=attributes.id;
    }

    set wrapper(selector)
    {

        this._wrapper = queryElement(selector);
    }

    get wrapper()
    {
        return this._wrapper;
    }

    set productClone(selector)
    {
        if(this.wrapper)
        {

            this._productClone = this.wrapper.querySelector(selector).cloneNode(true);
        }else
            {
                this._productClone =false;
            }
    }

    get productClone()
    {
        return this._productClone;
    }

    set products(selector)
    {
        if(this.wrapper)
        {
            this._products = this.wrapper.querySelectorAll(selector);
        }else
            {
                this._products=[];
            }

    }

    get products()
    {
        return this._products;
    }



    get_count_products()
    {
        this.products = config.item;
        return this.products.length;


    }

    get_ids()
    {
        this.products = config.item;

        let result = [];
        this.products.forEach(product=>
        {
            result.push(product.getAttribute('data-id'));
        });
        return result;
    }

    insertProducts(data)
    {
        if(!this.wrapper)
        {
            return ;
        }
        this.wrapper.innerHTML='';

        data.forEach(item=>
        {
            let product = this.productClone.cloneNode(true);
            let element = this.productAssembly(product,item)
            this.wrapper.appendChild(element);
        })

        new Basket();
    }

    addProducts(data)
    {
        if(!this.wrapper)
        {
            return;
        }
            data.forEach(item=>
        {
            let product = this.productClone.cloneNode(true);
            let element = this.productAssembly(product,item)
            this.wrapper.appendChild(element);
        })
        new Basket();
    }
    productAssembly(element,data)
    {
        element.setAttribute('data-id',data.id);

        element.querySelector(config.card.shortcard_thumb_link).href=data.link;

        element.querySelector(config.card.shortcard_thumb_img).src=data.img.url;
        element.querySelector(config.card.shortcard_thumb_img).alt=data.img.alt;

        element.querySelectorAll(config.card.compatibilityElements).forEach(ul=>
        {
            data.compatibility.forEach(compatibility=>
            {
                let li = document.createElement('li');
                li.innerText = compatibility;
                ul.appendChild(li);
            });
        });

        element.querySelector(config.card.article).innerText= data.article;

        element.querySelector(config.card.title).innerText= data.title;
        element.querySelector(config.card.article).href= data.link;

        element.querySelectorAll(config.card.priceElements).forEach(item=>
        {
            item.innerText = data.price;
        });

        element.querySelectorAll(config.card.addBasket).forEach(btn=>
        {
            btn.setAttribute(this.attributeId,data.id)
        })

        for (let key in data.dimensions) {
            let compatibility = data.dimensions[key];

            let li = document.createElement('li');

            let label = document.createElement('div');
            label.classList.add('label')
            label.innerText = compatibility.title;

            let span = document.createElement('div');
            span.innerText = compatibility.value;

            li.appendChild(label);
            li.appendChild(span)

            element.querySelector(config.card.dimensions).appendChild(li);
        }


        return element;

    }



}