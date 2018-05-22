import { Router } from "express";
import { router as SearchRouter } from "./Search/router";

export const router = Router();

router.use("/search", SearchRouter);
