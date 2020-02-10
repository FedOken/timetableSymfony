import React, {useState, Component} from "react";
import NavTab from "./NavTab";
import { Link } from "react-router-dom";
import {connect} from "react-redux";

function Header(props) {

    const showHeaderItem = () => {
        return props.headerItems.map((item, key) => {
            if (item.text === 'logo') {
                return <Link key={ item.id } className={'logo-container'} to={ item.url }>{ item.icon }</Link>;
            } else {
                return <NavTab key={ item.id } text={ item.text } icon={ item.icon } linkUrl={ item.url }/>;
            }

        });
    };

    return (
        <header>
            { showHeaderItem() }
        </header>
    );

}

function mapStateToProps(state) {
    return {
        headerItems: state.header,
        user: state.user,
    }
}

export default connect(mapStateToProps)(Header);