import React from "react";
import { Route } from "react-router";
import { BrowserRouter as Router, Link } from "react-router-dom";
import { Dashboard } from "./../Dashboard/container.jsx";

export const Layout = () => {
    return (
        <div>
            <Sidebar />

            <Router>
                <Route path="/app/home" component={Dashboard} />
            </Router>
        </div>
    );
};

const Sidebar = () => (
    <ul>
        <li>
            <Link to="/app/home" />
        </li>
    </ul>
);
