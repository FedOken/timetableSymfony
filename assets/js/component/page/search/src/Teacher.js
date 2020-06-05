import React, { useState, useEffect } from 'react';
import {AsyncTypeahead} from "react-bootstrap-typeahead";
import Select from "../../../src/Select";
import {bindActionCreators} from "redux";
import {push} from "connected-react-router";
import {connect} from "react-redux";
import axios from "axios";
import { withRouter } from 'react-router-dom';
import { preloaderStart, preloaderEnd } from "../../../src/Preloader/Preloader";
import { alert, alertException } from "../../../src/Alert/Alert";

function index(props) {
    const [selUnOpt, setSelUnOpt] = useState([]);
    const [selUnIsDisabled, setSelUnIsDisabled] = useState(true);

    const [selTchrOpt, setSelTchrOpt] = useState([]);
    const [selTchrValue, setSelTchrValue] = useState();
    const [selTchrIsDisabled, setSelTchrIsDisabled] = useState(true);

    const [tphOptions, setTphOptions] = useState([]);
    const [tphIsLoading, setTphIsLoading] = useState(false);

    const [btnIsDisabled, setBtnIsDisabled] = useState(true);
    const [selectedTeacher, setSelectedTeacher] = useState();

    useEffect(() => {
        axios.post('/react/search/get-universities')
            .then((res) => {
                setSelUnOpt(res.data);
                setSelUnIsDisabled(false);
            })
            .catch((error) => {alertException(error.response.status)});
    }, []);

    const tphOnSearch = (searchText) => {
        setTphIsLoading(true);
        axios.post('/react/search/get-teachers-autocomplete/' + searchText)
            .then((res) => {
                setTphOptions(res.data);
                setTphIsLoading(false);
            })
            .catch((error) => {alertException(error.response.status)})
            .then(() => { preloaderEnd() });
    };

    const tphOnChange = (query) => {
        if (typeof query[0] === 'undefined' || typeof query[0].value === 'undefined') return;
        setSelectedTeacher(query[0].value);
        setBtnIsDisabled(false);
    };

    const tphOnInputChange = () => {
        setBtnIsDisabled(true);
    };

    const selUnOnChange = (data) => {
        if (typeof data.value === 'undefined') return;

        setSelTchrValue('');
        setSelTchrIsDisabled(true);
        setBtnIsDisabled(true);

        axios.post('/react/search/get-teachers/' + data.value)
            .then((res) => {
                setSelTchrOpt(res.data);
                setSelTchrIsDisabled(false);
            })
            .catch((error) => {alertException(error.response.status)});
    };

    const selTchrOnChange = (data) => {
        if (typeof data.value === 'undefined') return;

        setSelTchrValue(data);
        setSelectedTeacher(data.value);
        setBtnIsDisabled(false);
    };




    const redirect = () => {
        let url = "/schedule/teacher/" + selectedTeacher;
        preloaderStart();
        setTimeout(() => {
            props.push(url);
            props.history.push(url);
        }, 300)
    };



    return (
        <div>
            <p className={'enter-group'}>Введите фамилию преподавателя</p>
            <AsyncTypeahead
                id="home-autocomplete"
                className={'input typeahead'}
                isLoading={tphIsLoading}
                onSearch={ (query) => {tphOnSearch(query)} }
                onChange={ (query) => {tphOnChange(query)} }
                onInputChange = { () => {tphOnInputChange()} }
                options={tphOptions}
                useCache={false}
                promptText={"Вводите для поиска..."}
                searchText={"Идет поиск..."}
                emptyLabel={"Ничего не найдено"}
                paginationText={"Показать больше..."}
                maxResults={6}
                minLength={1}
            />

            <p className="row-delimiter">или</p>

            <Select
                name="group-select"
                options={selUnOpt}
                placeholder={'Выберите университет'}
                className={'select select-type-1 ' + (selUnIsDisabled ? 'disabled' : '')}
                onChange={ (data) => {selUnOnChange(data)} }
            />
            <Select
                name="group-select"
                options={selTchrOpt}
                value={selTchrValue}
                placeholder={'Выберите преподавателя'}
                className={'select select-type-1 ' + (selTchrIsDisabled ? 'disabled' : '')}
                onChange={ (data) => {selTchrOnChange(data)} }
                isDisabled={selTchrIsDisabled}
            />
            <button type="button" className={"w-100 btn btn-type-2"} onClick={() => redirect()} disabled={btnIsDisabled} >Поиск</button>
        </div>
    );
}


function matchDispatchToProps(dispatch) {

    return bindActionCreators({push: push}, dispatch)
}

export default withRouter(connect(null, matchDispatchToProps)(index));