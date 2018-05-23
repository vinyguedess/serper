import { Router } from "express";

export const router = Router();

router.get("/", (request, response) => response.render("app.index"));
