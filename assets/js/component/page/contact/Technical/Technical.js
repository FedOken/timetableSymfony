import React from 'react';
import {bindActionCreators} from "redux";
import {push} from "connected-react-router";
import {connect} from "react-redux";
import '../Business/style.scss';

function index(props) {

    const redirect = (url) => {
        props.push(url);
        props.history.push(url);
    };

    return (
        <div className="technical container">
            <p className={'title'}>Обнаружили ошибку или знаете как сделать лучше?</p>
            <p className={'description'}>Опишите как можно подробнее, мы обязательно Вам ответим</p>
            <div className={'block'}>
                <input className={'form-control input input-type-1'} placeholder={'Email'} type="text"/>
            </div>
            <textarea className={"form-control txt-area area-type-1"} placeholder={'Ваше сообщение'} rows="5"></textarea>
            <div className={'block_button'}>
                <button className={'btn btn-type-2'} onClick={() => redirect("/search")}>Отправить</button>
            </div>
        </div>
    );
}


function matchDispatchToProps(dispatch) {
    return bindActionCreators({push: push}, dispatch)
}

export default connect(null, matchDispatchToProps)(index);