import React, {Component} from "react";
import { Switch, Route } from 'react-router-dom';

import Home from "../HomeComponents/Home";
import Login from "../LoginComponent/Login";

export default class Content extends Component {
    render() {
        return (
            <main>
                <Switch>
                    <Route exact path='/' component={Home}/>
                    <Route path='/login' component={Login}/>
                </Switch>
            </main>
        );
    }
}