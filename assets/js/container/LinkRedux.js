import React from 'react';
import {Link} from "react-router-dom";
import {bindActionCreators} from "redux";
import {push} from "connected-react-router";
import {connect} from "react-redux";

function index(props) {
    const reduxRoute = () => {
        props.push(props.route);
    };

    return (
        <Link to={props.route} className={props.className} onClick={reduxRoute}>{props.text}</Link>
    );
}

function matchDispatchToProps(dispatch) {
    return bindActionCreators({push: push}, dispatch)
}

export default connect(null, matchDispatchToProps)(index);

