import React, {Component} from 'react';

export default class MessageWarning extends Component {
    render() {
        return (
            <div className="alert alert-danger">{this.props.message}</div>
        );
    }
}

