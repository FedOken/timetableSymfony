import React from 'react';
import {bindActionCreators} from "redux";
import {push} from "connected-react-router";
import {connect} from "react-redux";
import './style.scss'

function index(props) {

    const redirect = (url) => {
        props.push(url);
        props.history.push(url);
    };

    return (
        <div className="business container">
            <p className={'title'}>И Ваш университет может принять участие в проекте!</p>
            <p className={'description'}>Как бы там ни было, заполните форму ниже и с Вами скоро свяжутся</p>
            <div className={'block'}>
                <input className={'form-control input input-type-1'} placeholder={'Email'} type="text"/>
                <span>или</span>
                <input className={'form-control input input-type-1'} placeholder={'Телефон'} type="text"/>
            </div>
            <textarea className={"form-control txt-area area-type-1"} placeholder={'Ваше сообщение'} rows="5"></textarea>
            <div className={'block_button'}>
                <button type={'button'} className={"btn btn-type-2"} onClick={() => redirect('/search')}>Отправить</button>
            </div>

        </div>
    );
}

function matchDispatchToProps(dispatch) {
    return bindActionCreators({push: push}, dispatch)
}

export default connect(null, matchDispatchToProps)(index);