import express from "express";
import { router as apiRouter } from "./API/router";

export const app = express();

app.use("/api", apiRouter);
