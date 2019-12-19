import React, {Component} from "react";

export default class Footer extends Component {
    render() {
        return (
            <footer>
                <div className={'container footer'}>
                    <span>&#169; 2019 SCHEDULE. All rights reserved.</span>
                    <span>Created by Oleksandr Fedorenko</span>
                </div>
            </footer>
        );
    }
}