import React, { useState, useEffect } from 'react';
import {AsyncTypeahead} from "react-bootstrap-typeahead";
import Select from "../../../../src/Select";
import {bindActionCreators} from "redux";
import {push} from "connected-react-router";
import {connect} from "react-redux";
import axios from "axios";
import { withRouter } from 'react-router-dom';
import { preloaderStart, preloaderEnd } from "../../../../src/Preloader/Preloader";
import { alertException } from "../../../../src/Alert/Alert";

function index(props) {
    const [selUnOpt, setSelUnOpt] = useState([]);
    const [selUnIsDisabled, setSelUnIsDisabled] = useState(true);

    const [selBldngOpt, setSelBldngOpt] = useState([]);
    const [selBldngValue, setSelBldngValue] = useState();
    const [selBldngIsDisabled, setSelBldngIsDisabled] = useState(true);

    const [selCabinetOpt, setSelCabinetOpt] = useState([]);
    const [selCabinetValue, setSelCabinetValue] = useState();
    const [selCabinetIsDisabled, setSelCabinetIsDisabled] = useState(true);

    const [tphOptions, setTphOptions] = useState([]);
    const [tphIsLoading, setTphIsLoading] = useState(false);

    const [btnIsDisabled, setBtnIsDisabled] = useState(true);
    const [selectedCabinet, setSelectedCabinet] = useState();

    useEffect(() => {
        axios.post('/react/search/get-universities')
            .then((res) => {
                setSelUnOpt(res.data);
                setSelUnIsDisabled(false);
            })
            .catch((error) => {alertException(error.response.status)})
    }, []);

    const tphOnSearch = (searchText) => {
        setTphIsLoading(true);
        axios.post('/react/search/get-cabinets-autocomplete/' + searchText)
            .then((res) => {
                setTphOptions(res.data);
                setTphIsLoading(false);
            })
            .catch((error) => {alertException(error.response.status)})
            .then(() => { preloaderEnd() });
    };

    const tphOnChange = (query) => {
        if (typeof query[0] === 'undefined' || typeof query[0].value === 'undefined') return;
        setSelectedCabinet(query[0].value);
        setBtnIsDisabled(false);

    };

    const tphOnInputChange = () => {
        setBtnIsDisabled(true);
    };

    const selUnOnChange = (data) => {
        if (typeof data.value === 'undefined') return;

        setSelBldngValue('');
        setSelBldngIsDisabled(true);

        setSelCabinetValue('');
        setSelCabinetOpt([]);
        setSelCabinetIsDisabled(true);

        setBtnIsDisabled(true);

        axios.post('/react/search/get-buildings/' + data.value)
            .then((res) => {
                setSelBldngOpt(res.data);
                setSelBldngIsDisabled(false);
            })
            .catch((error) => {alertException(error.response.status)});
    };

    const selBldngOnChange = (data) => {
        if (typeof data.value === 'undefined') return;

        setSelBldngValue(data);
        setSelCabinetValue('');
        setSelCabinetIsDisabled(true);
        setBtnIsDisabled(true);

        axios.post('/react/search/get-cabinets/' + data.value)
            .then((res) => {
                setSelCabinetOpt(res.data);
                setSelCabinetIsDisabled(false);
            })
            .catch((error) => {alertException(error.response.status)});
    };

    const selCabinetOnChange = (data) => {
        if (typeof data.value === 'undefined') return;

        setSelCabinetValue(data);
        setSelectedCabinet(data.value);
        setBtnIsDisabled(false);
    };

    const redirect = () => {
        let url = "/schedule/cabinet/" + selectedCabinet;
        preloaderStart();
        setTimeout(() => {
            props.push(url);
            props.history.push(url);
        }, 300)
    };



    return (
        <div>
            <p className={'enter-group'}>Введите номер аудитории</p>
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
                options={selUnOpt}
                placeholder={'Выберите университет'}
                className={'select select-type-1 ' + (selUnIsDisabled ? 'disabled' : '')}
                onChange={ (data) => {selUnOnChange(data)} }
            />
            <Select
                options={selBldngOpt}
                value={selBldngValue}
                placeholder={'Выберите корпус'}
                className={'select select-type-1 ' + (selBldngIsDisabled ? 'disabled' : '')}
                onChange={ (data) => {selBldngOnChange(data)} }
                isDisabled={selBldngIsDisabled}
            />
            <Select
                options={selCabinetOpt}
                value={selCabinetValue}
                placeholder={'Выберите аудиторию'}
                className={'select select-type-1 ' + (selCabinetIsDisabled ? 'disabled' : '')}
                onChange={ (data) => {selCabinetOnChange(data)} }
                isDisabled={selCabinetIsDisabled}
            />
            <button type="button" className={"w-100 btn btn-type-2"} onClick={() => redirect()} disabled={btnIsDisabled} >Поиск</button>
        </div>
    );
}


function matchDispatchToProps(dispatch) {

    return bindActionCreators({push: push}, dispatch)
}

export default withRouter(connect(null, matchDispatchToProps)(index));
