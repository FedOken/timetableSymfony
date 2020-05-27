import React, {useEffect, useState} from 'react';
import Week from "./src/Week";
import {connect} from "react-redux";
import {preloaderEnd, preloaderStart} from "../../src/Preloader";
import axios from "axios";
import {alertException} from "../../src/Alert";
import {useParams, withRouter} from "react-router";
import DayBlock from "./src/DayBlock";
import {isEmpty} from "../../src/Helper";
import {bindActionCreators} from "redux";
import {push} from "connected-react-router";

function index(props) {
    const [data, setData] = useState();

    let params = props.loc.pathname.split('/');
    let type = params[params.length - 2];

    useEffect(() => {
        preloaderStart();
        axios.post(`/react/schedule/get-weeks/${type}/${params[params.length - 1]}`)
            .then((res) => {
                //console.log(res.data);
                setData(res.data);
            })
            .catch((error) => {alertException(error.response.status)})
            .then(() => { preloaderEnd() });
        preloaderEnd();
    }, []);

    const renderDays = () => {
        if (!data) return;

        return Object.keys(data.weeks).map((key) => {
            return <Week key={key} week={data.weeks[key]} model={data.model} type={type}/>
        });
    };

    const redirect = (url) => {
        props.push(url);
        props.history.push(url);
    };


    if (isEmpty(data)) {
        return (
            <div className="schedule container not-found">
                <p>Расписание не найдено</p>
                <button type={'button'} className={"btn btn-type-2"} onClick={() => redirect('/search')}>К поиску</button>
            </div>
        );
    }
    return (
        <div className="schedule container">
            {renderDays()}
        </div>
    );
}

function mapStateToProps(state) {
    return {
        loc: state.router.location,
    }
}

function matchDispatchToProps(dispatch) {

    return bindActionCreators({push: push}, dispatch)
}

export default withRouter(connect(mapStateToProps, matchDispatchToProps)(index));

