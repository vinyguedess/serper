const path = require("path");
const NodemonPlugin = require("nodemon-webpack-plugin");

module.exports = {
    mode: "development",
    entry: "./resources/assets/js/app.jsx",
    output: {
        path: path.resolve("./public/assets/js"),
        filename: "bundle.js"
    },
    plugins: [
        new NodemonPlugin({
            watch: path.resolve("./src"),
            script: "./server.js"
        })
    ],
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: "babel-loader"
                }
            },
            {
                test: /\.jsx$/,
                exclude: /node_modules/,
                use: {
                    loader: "babel-loader",
                    options: {
                        presets: ["env", "react"],
                        plugins: ["transform-object-rest-spread"]
                    }
                }
            }
        ]
    }
};
