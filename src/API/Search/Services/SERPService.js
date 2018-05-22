import { BaseService } from "./../../Core/BaseService";
import Axios from "axios";

export class SERPService extends BaseService 
{
    constructor() 
    {
        super();
        this.total = 100;
    }

    search(term) 
    {
        return Axios({
            method: "GET",
            url: this.route
                .replace(/__TERM__/g, term)
                .replace(/__TOTAL__/g, this.total),
            headers: {
                "Content-type": "text/html; charset=utf8",
                "User-Agent":
                    SERPService.UserAgents[
                        Math.floor(Math.random() * SERPService.UserAgents.length)
                    ]
            }
        })
            .then(httpResponse => this.parse(httpResponse.data))
            .then(results => this.resolvePositioning(results));
    }

    resolvePositioning(results) 
    {
        return results.map((item, index) => ({
            ...item,
            position: {
                page: Math.floor(index / 10) + 1,
                position: parseInt(index.toString().slice(-1)) + 1,
                general: index
            }
        }));
    }
}

SERPService.UserAgents = [
    "Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:47.0) Gecko/20100101 Firefox/47.0",
    "Mozilla/5.0 (Macintosh; Intel Mac OS X x.y; rv:42.0) Gecko/20100101 Firefox/42.0",
    "Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/10.0 Mobile/14E304 Safari/602.1",
    "Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0)",
    "Googlebot/2.1 (+http://www.google.com/bot.html)"
];
