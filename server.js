const { app } = require("./app/bootstrap");

let port = process.env.PORT || 3000;
app.listen(port, () => console.log(`Runnig at ${port}`));
