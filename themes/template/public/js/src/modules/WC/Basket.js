import {Config} from "../../settings";
import AddHandlerForEvent from "../../Controllers/AddHandlerForEvent";
import {getParent, queryElement} from "../../common";

const selectors = Config.modules.basket.selectors;
const attributes = Config.modules.basket.attributes;
const classes = Config.modules.basket.classes;
const actions = Config.modules.basket.actions;

export default class Basket{
    constructor(btn=null)
    {
        this.btnsBasket = selectors.btn;

        if(!this.btnsBasket)
            return;

        this.countElements = selectors.countElement;
        this.priceElements = selectors.priceElement;


        this.inputQuantityElements = selectors.inputQuantity;
        // this.table = selectors.table;
        this.btnDeleteProducts = selectors.btnDeleteProducts;

        this.classAdd = classes.add;
        this.classRemove=classes.remove;
        this.classInputQuantity = classes.inputQuantity;
        // this.classLoad = classes.load;
        // this.selectorLineTotalPrice = selectors.lineTotalPrice;
        // this.selectorRow = selectors.row;
        this.attributeId=attributes.id;
        this.attributeKey = attributes.key;
        this.attributeEmpty = attributes.emptyBasket;
        this.attributeCurrency = attributes.currency;
        this.actionsAdd = actions.add;
        this.actionsRemove = actions.remove;
        this.actionsQuantity = actions.quantity;


        if(this.btnsBasket)
        new AddHandlerForEvent(this.btnsBasket,'click',(event)=>
        {
            let target = event.target;

            this.handler(target)
        });

        if(this.inputQuantityElements)
        new AddHandlerForEvent(this.inputQuantityElements,'click',(event)=>
        {
            this.handler(event.target)
        })

        if(this.btnDeleteProducts)
        new AddHandlerForEvent(this.btnDeleteProducts,'click',(event)=>
        {
            document.querySelectorAll('[data-product]').forEach(product=>
            {
                if(product.querySelector('.input-select ').checked)
                {
                    setInterval(()=>
                    {
                        this.removeFromBasket(product.getAttribute('data-key'));
                        product.remove();
                    },500)

                }

            })

            // setTimeout(()=>
            // {
            //     location.reload();
            // },500)

        })

    }

    set btnsBasket(selector)
    {
        this._btnsBasket = document.querySelectorAll(selector);
    }

    get btnsBasket()
    {
        return this._btnsBasket;
    }

    set countElements(selector)
    {
        this._countElements = document.querySelectorAll(selector);
    }

    get countElements()
    {
        return this._countElements;
    }

    set priceElements(selector)
    {
        this._priceElements = document.querySelectorAll(selector);
    }

    get priceElements()
    {
        return this._priceElements;
    }

    set inputQuantityElements(selector)
    {
        this._inputQuantityElement = document.querySelectorAll(selector);
    }

    get inputQuantityElements()
    {
        return this._inputQuantityElement;
    }

    set table(selector)
    {
        this._table = queryElement(selector);
    }

    get table()
    {
        return this._table;
    }

    set btnDeleteProducts(selector)
    {
        this._btnDeleteProducts = document.querySelector(selector)
    }

    get btnDeleteProducts()
    {
        return  this._btnDeleteProducts;
    }

    addToBasket(id,btn)
    {

        this.ajax(id,this.actionsAdd,this.updateCountAndPrice);
        btn.style.display= 'none';
        // btn.classList.remove(this.classAdd);
        // btn.classList.add(this.classRemove);
    }

    removeFromBasket(key)
    {
        this.ajax(key,this.actionsRemove,this.updateCountAndPrice);
        // btn.style.display= 'none';
    }

    changeQuantity(key,value)
    {

        // this.table.classList.add(this.classLoad);
        this.ajax(key,this.actionsQuantity,(xhr,status)=>
        {
            let response = JSON.parse(xhr.responseText);

            if(!response.count || !response.price)
            {
                console.error(response)
                throw 'Error response in change quantity products';
            }
            this.updateCountAndPrice(
                response.count,
                response.price,
                this.priceElements,
                this.countElements,
                this.attributeEmpty,
                this.attributeCurrency);
            // this.updateRowTotalPrice(input.getAttribute(this.attributeKey),response.line_total)
            // this.table.classList.remove(this.classLoad);

        },{quantity:value})
    }

    updateRowTotalPrice(key,lineTotalPrice)
    {
         document.querySelector(`${this.selectorRow}[${this.attributeKey}="${key}"] ${this.selectorLineTotalPrice}`).innerHTML = lineTotalPrice;

    }

    updateCountAndPrice(count,price,priceElements,countElements,attributeEmpty,attributeCurrency)
    {

        if(priceElements)
        {
            priceElements.forEach(priceElement=>{
                priceElement.innerHTML = Number(count) === 0?
                    priceElement.getAttribute(attributeEmpty):
                    `${price}`;
            });
        }

        if(countElements)
        {
            countElements.forEach(countElement=>
            {
                countElement.innerHTML = count;
            })
        }


    }

    ajax(id,action,callback=this.callback,args={})
    {
        let data =
            {
                id:id,
                action:action
            };
        if(Object.keys(args).length > 0)
        {
            data = Object.assign(data,args);
        }

        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            method: "POST",
            data:data,
            complete:(jqXHR, textStatus)=>
            {
                let response = JSON.parse(jqXHR.responseText);

                switch (callback)
                {
                    case this.updateCountAndPrice:

                        this.updateCountAndPrice(response.count,response.price,this.priceElements,this.countElements,this.attributeEmpty,this.attributeCurrency);
                        break
                    default:
                        callback(jqXHR, textStatus);
                        break;
                }

            },
        });
    }

    handler(btn)
    {

        if(btn.classList.contains(this.classAdd))
        {

            this.addToBasket(btn.getAttribute(this.attributeId),btn)

        }else if(btn.classList.contains(this.classInputQuantity))
                {

                    this.changeQuantity(btn.closest('.product-cart').getAttribute('data-key'),
                        btn.closest('.counter-wrapper').querySelector('.counter-current').innerHTML);
                }
    }

    callback(jqXHR, textStatus)
    {

    }

}