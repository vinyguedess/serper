import * as path from "path";
import express from "express";
import * as pug from "pug";
import { router as apiRouter } from "./API/router";
import { router as webRouter } from "./Web/router";
import { router as appRouter } from "./App/router";

export const app = express();

app.use(express.static("public"));

app.use((request, response, next) => 
{
    response.render = (view, params = {}) => 
    {
        view = (`resources.views.${view}`.split(".").join("/") + ".pug").split("/");
        let file = path.resolve(...view);

        return response.send(pug.renderFile(file, params));
    };

    next();
});

app.use("/api", apiRouter);
app.use("/app*", appRouter);
app.use("/", webRouter);
