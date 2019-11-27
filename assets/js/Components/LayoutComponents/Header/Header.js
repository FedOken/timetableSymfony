import React, {Component} from "react";
import NavTab from "./NavTab";

export default class Header extends Component {
    render() {
        return (
            <header>
                <NavTab text={'Home'} icon={<i className="fas fa-home"></i>} linkUrl={'/'}/>
                <NavTab text={'Help'} icon={<i className="fas fa-question-circle"></i>} linkUrl={'/help'}/>
                <NavTab text={'Login'} icon={<i className="fas fa-user"></i>} linkUrl={'/login'}/>
            </header>
        );
    }
}