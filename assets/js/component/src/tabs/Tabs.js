import React, {useState} from 'react';

export default function index(props) {

    const clickTab = (e) => {
        let element = e.currentTarget;
        if (element.classList.contains('active')) return;

        let container = document.querySelector(`div#${props.id}`);
        let allNavs = container.querySelectorAll(`.nav-item`);
        allNavs.forEach(item => {
            item.classList.remove('active');
        });
        let allTabs = container.querySelectorAll(`.tab-pane`);
        allTabs.forEach(item => {
           item.classList.remove('show', 'active');
        });

        let target = element.getAttribute("target");
        element.classList.add('active');
        document.querySelector(`div[tabname=${target}]`).classList.add('show', 'active');
    };

    const renderNavs = () => {
        return props.children.map((item, key) => {
            return (
                <li className={`nav-item ${item.props.active === true ? 'active' : ''}`} key={key} target={item.props.group} onClick={(e) => clickTab(e)}>
                    {item.props.svg}
                    <span>{item.props.title}</span>
                </li>
            );
        });
    };

    const renderTabs = () => {
        return props.children.map((item, key) => {
            return (
                <div
                    key={key}
                    className={`tab-pane fade ${item.props.active === true ? 'show active' : ''}`}
                    id="profile"
                    tabname={item.props.group}
                    role="tabpanel"
                    aria-labelledby="profile-tab"
                >
                    {item.props.children}
                </div>
            );
        });
    };

    return (
        <div className={props.className} id={props.id}>
            <ul className="nav nav-tabs" role="tablist">
                {renderNavs()}
            </ul>
            <div className="tab-content">
                {renderTabs()}
            </div>
        </div>
    );
}