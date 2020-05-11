import React, { useState } from 'react';
import Button from "react-bootstrap/Button";
import {bindActionCreators} from "redux";
import {push} from "connected-react-router";
import {connect} from "react-redux";
import Tabs from "react-bootstrap/Tabs";
import {Tab} from "react-bootstrap";
import Select from "../../src/Select";

function index(props) {
    const [selectUnOpt, setSelectUnOpt] = useState([
        { value: 'chocolate', label: 'Hert' },
        { value: 'chocolate1', label: 'Chocolate' },
        { value: 'chocolate2', label: 'Chocolate' },
        { value: 'chocolate3', label: 'Chocolate' },
        { value: 'chocolate4', label: 'Chocolate' },
        { value: 'chocolate5', label: 'Chocolate' },
        { value: 'chocolate6', label: 'Chocolate' },
        { value: 'chocolate7', label: 'Chocolate chocolate chocolate chocolate chocolate chocolate chocolate chocolate' },
        { value: 'chocolate6', label: 'Chocolate' },
        { value: 'chocolate6', label: 'Chocolate' },
        { value: 'chocolate6', label: 'Chocolate' },
        { value: 'chocolate6', label: 'Chocolate' },
        { value: 'chocolate6', label: 'Chocolate' },
        { value: 'chocolate6', label: 'Chocolate' },
        ]);

    const clickRegister = () => {
        redirect('/register/confirm-email-send')
    };

    const redirect = (url) => {
        props.push(url);
        props.history.push(url);
    };



    return (
        <div className="register container">
            <div className="col-xs-12 col-sm-6 col-md-5 block-center">
                <div className={'block-register'}>
                    <Tabs defaultActiveKey="student" id="group-tab">
                        <Tab eventKey="student" title="Студентам">
                            <form>
                                <Select
                                    name="university-select"
                                    options={selectUnOpt}
                                    placeholder={'Выберите университет'}
                                    className={'select select-type-1'}

                                />
                                <Select
                                    name="group-select"
                                    options={selectUnOpt}
                                    placeholder={'Выберите группу'}
                                    className={'select select-type-1'}
                                />
                                <input className={'form-control input input-type-1 w-100'} placeholder={'Email'} type="email" />
                                <input className={'form-control input input-type-1 w-100'} placeholder={'Пароль'} type="text"/>
                                <Button type="button" className={"w-100"} variant="type-2" onClick={() => clickRegister()}>Зарегистрироваться</Button>
                            </form>
                        </Tab>
                        <Tab eventKey="teacher" title="Преподавателям">
                            <form>
                                <Select
                                    name="university-select"
                                    options={selectUnOpt}
                                    placeholder={'Выберите университет'}
                                    className={'select select-type-1'}

                                />
                                <Select
                                    name="group-select"
                                    options={selectUnOpt}
                                    placeholder={'Выберите преподавателя'}
                                    className={'select select-type-1'}
                                />
                                <input className={'form-control input input-type-1 w-100'} placeholder={'Email'} type="email" />
                                <input className={'form-control input input-type-1 w-100'} placeholder={'Пароль'} type="text"/>
                                <Button type="button" className={"w-100"} variant="type-2" onClick={() => clickRegister()}>Зарегистрироваться</Button>
                            </form>
                        </Tab>
                        <Tab eventKey="university" title="Университетам">
                            <input className={'form-control input input-type-1 w-100'} placeholder={'Код доступа'} type="text" />
                            <input className={'form-control input input-type-1 w-100'} placeholder={'Email'} type="email" />
                            <input className={'form-control input input-type-1 w-100'} placeholder={'Пароль'} type="text"/>
                            <Button type="button" className={"w-100"} variant="type-2" onClick={() => clickRegister()}>Зарегистрироваться</Button>
                        </Tab>
                    </Tabs>

                </div>
            </div>
        </div>


    );
}


function matchDispatchToProps(dispatch) {
    return bindActionCreators({push: push}, dispatch)
}

export default connect(null, matchDispatchToProps)(index);