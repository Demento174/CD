const queryString = require('query-string');

export default class URLParams{


    get_urlParams()
    {
        return queryString.parse(location.search);
    }

    add_urlParams_reload(params={})
    {

        if(Object.keys(params).length <= 0)
        {
            return ;
        }
        let parsed = this.get_urlParams();
        let separator = '?';
        location.search =separator+queryString.stringify(Object.assign(parsed,params));

    }

    add_urlParams(params,reload=false)
    {
        if(Object.keys(params).length <= 0)
        {
            return ;
        }
        if (history.pushState)
        {
            let parsed = this.get_urlParams();

            let separator = '?';
            history.pushState(null, null, separator+queryString.stringify(Object.assign(parsed,params)));
            if(reload)
                this.add_urlParams_reload(params);
        }else {
            if(!reload)
            {
                console.warn('History API не поддерживается');
            }else
                {
                    this.add_urlParams_reload(params);
                }

        }
    }

    add_urlParams_to_clear_url(params)
    {
        if(Object.keys(params).length <= 0)
        {
            return ;
        }
        location.search ='?'+queryString.stringify(params);
    }

    reloadPageWithoutGET()
    {
        window.location = window.location.href.split("?")[0];

    }

    clear_URL()
    {
        return window.location.href.replace(window.location.search,'');
    }

}