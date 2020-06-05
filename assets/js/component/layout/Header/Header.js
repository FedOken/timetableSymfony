import React, {useState, useEffect} from 'react';
import {bindActionCreators} from "redux";
import {changeHeaderType} from "../../../redux/actions/header";
import {connect} from "react-redux";
import { push } from 'connected-react-router'
import HeaderItem from "./src/HeaderItem";
import HeaderLogo from "./src/HeaderLogo";
import './style.scss';

function index(props) {

    const rendering = () => {
        return props.items.map((item, key) => {
            if (item.id === 'logo') {
                return <HeaderLogo item={item} key={key}/>;
            } else {
                return <HeaderItem item={item} key={key}/>;
            }
        });
    };

    if (props.pathname === '/welcome') {
        return (
            <header className={'only_logo'}>
                {props.items.find((item) => {
                    return item.id === 'logo';
                }).icon}
            </header>
        );
    } else {
        return (
            <header>
                {rendering()}
            </header>
        );
    }
}

function mapStateToProps(state) {
    return {
        items: state.header.items,
        pathname: state.router.location.pathname,
    }
}

function matchDispatchToProps(dispatch) {
    return bindActionCreators({changeHeaderType: changeHeaderType, push: push}, dispatch)
}

export default connect(mapStateToProps, matchDispatchToProps)(index);
