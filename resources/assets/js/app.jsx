import React from "react";
import { render } from "react-dom";
import { Provider } from "react-redux";
import { store } from "./config";
import { Layout } from "./components/Layout/component.jsx";

render(
    <Provider store={store}>
        <Layout />
    </Provider>,
    document.getElementById("app")
);
