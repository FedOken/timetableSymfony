import React, {Component} from 'react';
import axios from 'axios';

import MessageWarning from "../CommonComponents/MessageWarning";

export default class Login extends Component {

    constructor(props) {
        super(props);
        this.state = {
            response: [],
        };
    }

    componentDidMount() {
        axios.post(`/react/login`)
            .then(res => {
                console.log(res.data);
                this.setState( {response: res.data} );
            });
    }

    render() {
        return (
            <div className="container">
                {this.state.response.error ? <MessageWarning message={this.state.response.error}/> : ''}

                <div className="col-md-4">
                    <form method="post" action="">



                        <div className="checkbox mb-3">You are logged in as {this.state.response.user ? this.state.response.user.email : ''}, <a href="/logout">Logout</a></div>

                        <h1 className="h3 mb-3 font-weight-normal">Please sign in</h1>
                        <label htmlFor="inputEmail" className="sr-only">Email</label>
                        <input type="email" name="email" id="inputEmail" className="form-control" placeholder="Email" required autoFocus/>
                        <label htmlFor="inputPassword" className="sr-only">Password</label>
                        <input type="password" name="password" id="inputPassword" className="form-control" placeholder="Password" required/>

                        <input type="hidden" name="_csrf_token" value={this.state.response.token || ''}/>
                        <button className="btn btn-lg btn-primary" type="submit">Sign in</button>
                    </form>
                </div>
            </div>
        );
    }
}

