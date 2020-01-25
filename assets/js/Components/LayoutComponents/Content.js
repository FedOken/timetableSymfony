import React, { useState, useEffect } from 'react';
import { Switch, Route } from 'react-router-dom'

import Home from "../HomeComponents/Home";
import Login from "../LoginComponent/Login";
import GroupShow from "../GroupComponents/GroupShow";

export default function Content() {
    const [loginStatus, setLoginStatus] = useState(1);

    const changeStatus = (value) => {
      setLoginStatus(value);
    };

    return (
        <main>
            <Switch>
                <Route exact path='/' component={Home}/>
                <Route path='/login'><Login loginStatus={loginStatus} changeStatus={changeStatus}/></Route>
                <Route path='/group/show' component={GroupShow}/>
            </Switch>
        </main>
    );
}