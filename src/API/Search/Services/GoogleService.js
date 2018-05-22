import cheerio from "cheerio";
import { SERPService } from "./SERPService";

export class GoogleService extends SERPService 
{
    constructor() 
    {
        super();
        this.route =
            "https://www.google.com.br/search?q=__TERM__&num=__TOTAL__";
    }

    parse(htmlContent) 
    {
        let cipher = cheerio.load(htmlContent, { decodeEntities: true });

        let results = [];
        cipher("div.g").map((index, el) => 
        {
            let title = cheerio(el)
                    .find("h3.r a")
                    .text(),
                description = cheerio(el)
                    .find("span.st")
                    .text(),
                url = cheerio(el)
                    .find("cite")
                    .text();

            if (title === "") return;

            results.push({
                title,
                description,
                url
            });
        });

        return results;
    }
}
