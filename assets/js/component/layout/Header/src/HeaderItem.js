import React from "react";
import {NavLink} from "react-router-dom";
import {bindActionCreators} from "redux";
import {push} from "connected-react-router";
import {connect} from "react-redux";

const index = (props) => {

    const reduxRoute = (url) => {
        props.push(url);
    };

    return (
        <div className={'header_item'}>
            <NavLink exact to={props.item.url} onClick={() => reduxRoute(props.item.url)}>
                <div className={'icon'}>
                    {props.item.icon}
                    {props.item.icon}
                </div>
                <div className={'text'}>
                    <span className={'visible'}>{props.item.text}</span>
                    <span className={'hidden'}>{props.item.text}</span>
                </div>
            </NavLink>
        </div>
    );
};

function matchDispatchToProps(dispatch) {
    return bindActionCreators({push: push}, dispatch)
}

export default connect(null, matchDispatchToProps)(index);