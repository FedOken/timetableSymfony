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

    const [selGrOpt, setSelGrOpt] = useState([]);
    const [selGrValue, setSelGrValue] = useState();
    const [selGrIsDisabled, setSelGrIsDisabled] = useState(true);

    const [tphOptions, setTphOptions] = useState([]);
    const [tphIsLoading, setTphIsLoading] = useState(false);

    const [btnIsDisabled, setBtnIsDisabled] = useState(true);
    const [selectedGroup, setSelectedGroup] = useState();

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
        axios.post('/react/search/get-parties-autocomplete/' + searchText)
            .then((res) => {
                setTphOptions(res.data);
                setTphIsLoading(false);
            })
            .catch((error) => {alertException(error.response.status)})
            .then(() => { preloaderEnd() });
    };

    const tphOnChange = (query) => {
        if (typeof query[0] === 'undefined' || typeof query[0].value === 'undefined') return;
        setSelectedGroup(query[0].value);
        setBtnIsDisabled(false);
    };

    const tphOnInputChange = () => {
        setBtnIsDisabled(true);
    };

    const selUnOnChange = (data) => {
        if (typeof data.value === 'undefined') return;

        setSelGrValue('');
        setSelGrIsDisabled(true);
        setBtnIsDisabled(true);

        axios.post('/react/search/get-parties/' + data.value)
            .then((res) => {
                setSelGrOpt(res.data);
                setSelGrIsDisabled(false);
            })
            .catch((error) => {alertException(error.response.status)});
    };

    const selGrOnChange = (data) => {
        if (typeof data.value === 'undefined') return;

        setSelGrValue(data);
        setSelectedGroup(data.value);
        setBtnIsDisabled(false);
    };

    const redirect = () => {
        let url = "/schedule/group/" + selectedGroup;
        preloaderStart();
        setTimeout(() => {
            props.push(url);
            props.history.push(url);
        }, 300)
    };

    return (
        <div>
            <p className={'enter-group'}>Введите название группы</p>
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
                options={selGrOpt}
                value={selGrValue}
                placeholder={'Выберите группу'}
                className={'select select-type-1 ' + (selGrIsDisabled ? 'disabled' : '')}
                onChange={ (data) => {selGrOnChange(data)} }
                isDisabled={selGrIsDisabled}
            />
            <button type="button" className={"w-100 btn btn-type-2"} onClick={() => redirect()} disabled={btnIsDisabled} >Поиск</button>
        </div>
    );
}


function matchDispatchToProps(dispatch) {

    return bindActionCreators({push: push}, dispatch)
}

export default withRouter(connect(null, matchDispatchToProps)(index));