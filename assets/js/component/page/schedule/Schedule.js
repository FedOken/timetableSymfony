import React, {useEffect} from 'react';
import Week from "./src/Week";
import {connect} from "react-redux";
import { useParams } from "react-router-dom";
import {preloaderEnd, preloaderStart} from "../../src/Preloader";
import axios from "axios";
import {alertException} from "../../src/Alert";



function index(props) {

    return (
        <div className="schedule container">
            <Week number={1}/>
            <Week number={2}/>
        </div>
    );
}

function mapStateToProps(state) {
    return {
        router: state.router,
    }
}

export default connect(mapStateToProps)(index);

