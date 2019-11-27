import React, {Component} from "react";
import {Link} from "react-router-dom";

export default class NavTabs extends Component {
    render() {
        return (
            <Link to={this.props.linkUrl}>
            <div className={'nav-tab'}>
                <div className={'icons'}>
                    {this.props.icon}
                    {this.props.icon}
                </div>
                <div className={'name'}>
                    <span datatext={this.props.text}>{this.props.text}</span>
                </div>
            </div>
            </Link>
        );
    }
}