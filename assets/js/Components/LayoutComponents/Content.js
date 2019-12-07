import React, {Component} from "react";
import { Switch, Route } from 'react-router-dom';

import Home from "../HomeComponents/Home";
import Login from "../LoginComponent/Login";
import GroupShow from "../GroupComponents/GroupShow";

export default class Content extends Component {
    render() {
        return (
            <main>
                <Switch>
                    <Route exact path='/' component={Home}/>
                    <Route path='/login' component={Login}/>
                    <Route path='/group/show' component={GroupShow}/>
                </Switch>
            </main>
        );
    }
}