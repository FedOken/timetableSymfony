import React, {useEffect, useState} from 'react';
import Button from "react-bootstrap/Button";
import {bindActionCreators} from "redux";
import {push} from "connected-react-router";
import {connect} from "react-redux";
import {preloaderEnd, preloaderStart} from "../../src/Preloader/Preloader";
import axios from "axios";
import {alertException} from "../../src/Alert/Alert";

function index(props) {

    const redirect = (url) => {
        props.push(url);
        props.history.push(url);
    };

    useEffect(() => {
        preloaderEnd();
    }, []);

    return (
        <div className="profile container">
            <div className="col-xs-12 col-sm-6 block-center">
                <form>
                    <div>
                        <p className={'title'}>Общая информация:</p>
                        <input className={'form-control input input-type-1 w-100'} placeholder={'Имя'} type="text"/>
                        <input className={'form-control input input-type-1 w-100'} placeholder={'Фамилия'} type="text"/>
                        <p>Университет: <span>Национальный транспортный университет</span></p>
                        <p>Группа: <span>УТ-1-1м</span></p>
                    </div>
                    <div>
                        <p className={'title'}>Контакты:</p>
                        <input className={'form-control input input-type-1 w-100'} placeholder={'Email'} type="text"/>
                        <input className={'form-control input input-type-1 w-100'} placeholder={'Телефон'} type="email"/>
                    </div>
                    <div>
                        <p className={'title'}>Безопасность:</p>
                        <input className={'form-control input input-type-1 w-100'} placeholder={'Старый пароль'} type="password"/>
                        <input className={'form-control input input-type-1 w-100'} placeholder={'Новый пароль'} type="password"/>
                        <input className={'form-control input input-type-1 w-100'} placeholder={'Еще раз новый пароль'} type="password"/>
                    </div>
                    <div className={'buttons'}>
                        <button type={"button"} className={"btn btn-type-2"}>Восстановить</button>
                        <button type={"button"} className={"btn btn-type-1"} onClick={() => redirect('/logout')}>Выйти из аккаунта</button>
                    </div>
                </form>
            </div>
        </div>
    );
}


function matchDispatchToProps(dispatch) {
    return bindActionCreators({push: push}, dispatch)
}

export default connect(null, matchDispatchToProps)(index);