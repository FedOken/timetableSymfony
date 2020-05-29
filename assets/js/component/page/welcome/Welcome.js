import React from 'react';
import {bindActionCreators} from "redux";
import {push} from "connected-react-router";
import {connect} from "react-redux";

function index(props) {

    const redirect = (url) => {
        props.push(url);
        props.history.push(url);
    };

    return (
        <div className="welcome container">
            <p className={'title'}>Удобное расписание всегда под рукой</p>
            <div className={'description'}>
                <p>SCHEDULE - платформа для университетов и студентов </p>
                <p>Теперь планировать, искать и управлять - просто</p>
            </div>
            <button type={'button'} className={'btn btn-type-1 btn-start'} onClick={() => redirect('/search')}>Начать</button>
        </div>
    );
}

function matchDispatchToProps(dispatch) {
    return bindActionCreators({push: push}, dispatch)
}

export default connect(null, matchDispatchToProps)(index);