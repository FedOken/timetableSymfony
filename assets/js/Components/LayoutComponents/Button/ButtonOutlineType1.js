import React, {Component} from "react";

export default class ButtonOutlineType1 extends Component {
    render() {
        return (
            <button
                type={this.props.type}
                className={'btn btn-outline-info ' + this.props.class}
                disabled={this.props.disabled}
            >
                {this.props.text}
            </button>
        );
    }
}