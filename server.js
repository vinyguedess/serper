if (process.env.NODE_ENV === "dev") 
{
    require("babel-register")({
        presets: ["env"],
        plugins: ["transform-object-rest-spread"]
    });
    const { app } = require("./src/bootstrap");

    let port = process.env.PORT || 3000;
    app.listen(port, () => console.log(`Running at ${port}`));
}
else 
{
    const { app } = require("./app/bootstrap");

    let port = process.env.PORT || 3000;
    app.listen(port, () => console.log(`Running at ${port}`));
}
