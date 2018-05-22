import { Router } from "express";
import { SERPFactory } from "./Factory/SERPFactory";

export const router = Router();

router.get("/:serp", (request, response) => 
{
    if (!request.query.term)
        return response.status(400).json({
            message: "Missing parameters in url",
            errors: {
                term: "You must send term as URL parameter before searching"
            }
        });

    let factory = SERPFactory(request.params.serp);
    if (!factory)
        return response.status(403).json({
            message: "Invalid serp service defined",
            errors: {
                service: "You must send request for a valid serp service"
            }
        });

    return factory
        .search(request.query.term)
        .then(results => response.json(results));
});
