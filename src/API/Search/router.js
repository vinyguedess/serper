import { Router } from "express";

export const router = Router();

router.get("/:serp", (request, response) => 
{
    return response.json({
        results: []
    });
});
