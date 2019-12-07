import React, {Component} from "react";

export default class ButtonType1 extends Component {
    render() {
        return (
            <button type={this.props.type} className={'btn btn-info ' + this.props.class}>{this.props.text}</button>
        );
    }
}