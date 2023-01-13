import {Config} from "../../settings";
import {queryElement} from "../../common";
import AddHandlerForEvent from "../../Controllers/AddHandlerForEvent";
import LoadProducts from "./LoadProducts";
import URLParams from "../URLParams";

const selectors = Config.modules.loadProducts.selectors.filters;

export default class Filters{
    constructor(productClass)
    {
        this.btn = selectors.btn;
        if(!this.btn)
        {
            return ;
        }

        this.reset = selectors.reset;
        this.productClass = productClass;
        this.urlCLass = new URLParams();
        this.firstCat = selectors.firstCat;
        this.secondCat = selectors.secondCat;
        this.thirdCat = selectors.thirdCat;
        this.minPrice = selectors.minPrice;
        this.maxPrice = selectors.maxPrice;
        this.manufacturers = selectors.manufacturers;
        this.arg = {};




        new AddHandlerForEvent(this.btn,'click',()=>
        {
            this.handler();
            this.queryProducts();
        });

        new AddHandlerForEvent(this.reset,'click',()=>
        {
            this.handlerReset();
        });
    }

    set btn(selector)
    {
        this._btn = queryElement(selector);
    }

    get btn()
    {
        return this._btn;
    }

    set reset(selector)
    {
        this._reset = queryElement(selector);
    }

    get reset()
    {
        return this._reset;
    }

    set firstCat(selector)
    {
        this._firstCat = queryElement(selector);
    }

    get firstCat()
    {
        return this._firstCat;
    }

    set secondCat(selector)
    {
        this._secondCat = queryElement(selector);
    }

    get secondCat()
    {
        return this._secondCat;
    }

    set thirdCat(selector)
    {
        this._thirdCat = queryElement(selector);
    }

    get thirdCat()
    {
        return this._thirdCat;
    }

    set minPrice(selector)
    {
        this._minPrice = queryElement(selector);
    }

    get minPrice()
    {
        return this._minPrice;
    }

    set maxPrice(selector)
    {
        this._maxPrice = queryElement(selector);
    }

    get maxPrice()
    {
        return this._maxPrice;
    }

    set manufacturers(selector)
    {
        this._manufacturers = queryElement(selector);
    }

    get manufacturers()
    {
        return this._manufacturers;
    }

    addArg(param,value)
    {
        this.arg[param]= value;
    }

    removeArg(param)
    {
        delete this.arg[param]
    }


    addURLparam(args={})
    {

        this.urlCLass.add_urlParams(args);
    }

    getURLparam(parameter)
    {
        return this.urlCLass.get_urlParams()[parameter];
    }


    changeCat(id,nextSelect)
    {
        if(Number(id)===0 || Number(id)===undefined)
        {
            nextSelect.querySelectorAll('option').forEach(option=>
            {
                option.disabled = false;
            })
        }else
            {
                nextSelect.querySelectorAll('option').forEach(option=>
                {
                    if(option.getAttribute('data-parent') !== id)
                    {
                        option.disabled = true;
                    }else
                        {
                            option.disabled = false;
                        }
                })
            }


    }

    handler()
    {
        if(this.firstCat.value !== '0')
        {
            // this.addURLparam('firstCat',this.firstCat.value)
            this.addArg('firstCat',this.firstCat.value)
        }else
            {
                // this.removerURLparam('firstCat')
                this.removeArg('firstCat')
            }

        if(this.secondCat.value !== '0')
        {
            // this.addURLparam('secondCat',this.secondCat.value)
            this.addArg('secondCat',this.secondCat.value)
        }else
            {
                // this.removerURLparam('secondCat')
                this.removeArg('secondCat')
            }

        if(this.thirdCat.value !== '0')
        {
            // this.addURLparam('thirdCat',this.thirdCat.value)
            this.addArg('thirdCat',this.thirdCat.value)
        }else
            {
                // this.removerURLparam('thirdCat')
                this.removeArg('thirdCat')
            }

        if(this.minPrice.value !== this.minPrice.min)
        {
            // this.addURLparam('minPrice',this.minPrice.value)
            this.addArg('minPrice',this.minPrice.value)
        }else
            {
                // this.removerURLparam('minPrice')
                this.removeArg('minPrice')
            }

        if(this.maxPrice.value !== this.maxPrice.max)
        {
            // this.addURLparam('maxPrice',this.maxPrice.value)
            this.addArg('maxPrice',this.maxPrice.value)
        }else
            {
                // this.removerURLparam('maxPrice')
                this.removeArg('maxPrice')
            }


        if(this.manufacturers.value !== '0')
        {
            // this.addURLparam('manufacturers',this.manufacturers.value)
            this.addArg('manufacturers',this.manufacturers.value)
        }else
            {
                // this.removerURLparam('manufacturers')
                this.removeArg('manufacturers')
            }

        this.addURLparam(this.arg)
    }

    handlerReset()
    {
        this.urlCLass.reloadPageWithoutGET();
    }

    queryProducts()
    {
        new LoadProducts(this.insertProducts,this.arg,{productClass:this.productClass})
    }

    insertProducts(jqXHR, textStatus,args ={} )
    {
        if(textStatus == 'success')
        {

            args.productClass.insertProducts(JSON.parse(jqXHR.responseText));
        }
    }

}