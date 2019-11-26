import React, {Component} from 'react';

export default class Login extends Component {

    componentDidMount() {

    }


    render() {
        return (
            <div className="container">
                <div className="col-md-4">
                    <form method="post" action="">

                        {/*<div className="alert alert-danger">error message</div>*/}
                        {/*    <div className="checkbox mb-3">You are logged in as asdasdasdasd, <a href="/asdasd">Logout</a>*/}
                        {/*</div>*/}

                        <h1 className="h3 mb-3 font-weight-normal">Please sign in</h1>
                        <label htmlFor="inputEmail" className="sr-only">Email</label>
                        <input type="email" name="email" id="inputEmail" className="form-control" placeholder="Email" required autoFocus/>
                        <label htmlFor="inputPassword" className="sr-only">Password</label>
                        <input type="password" name="password" id="inputPassword" className="form-control" placeholder="Password" required/>

                        <input type="hidden" name="_csrf_token" value="csrf_token('authenticate')"/>
                        <button className="btn btn-lg btn-primary" type="submit">Sign in</button>
                    </form>
                </div>
            </div>
        );
    }
}

