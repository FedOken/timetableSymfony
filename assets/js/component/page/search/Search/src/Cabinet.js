import React, {useState, useEffect} from 'react';
import {AsyncTypeahead} from 'react-bootstrap-typeahead';
import Select from '../../../../src/Select';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import axios from 'axios';
import {withRouter} from 'react-router-dom';
import {preloaderStart, preloaderEnd} from '../../../../src/Preloader/Preloader';
import {alert, alertException} from '../../../../src/Alert/Alert';
import {loadBuildingsByUniversity} from '../../../../../redux/actions/building';
import {loadCabinetsByBuilding} from '../../../../../redux/actions/cabinet';
import {dataToOptions, isEmpty} from '../../../../src/Helper';
import Typeahead from '../../../../src/Typeahead';
import {t} from '../../../../src/translate/translate';

function index(props) {
  const [selUnVal, setSelUnVal] = useState();

  const [selBldngOpt, setSelBldngOpt] = useState([]);
  const [selBldngOptAct, setSelBldngOptAct] = useState(null);
  const [selBldngVal, setSelBldngVal] = useState();

  const [selCabOpt, setSelCabOpt] = useState([]);
  const [selCabOptAct, setSelCabOptAct] = useState(null);
  const [selCabVal, setSelCabVal] = useState();

  const [tphOptions, setTphOptions] = useState([]);
  const [tphIsLoading, setTphIsLoading] = useState(false);

  const [btnIsDisabled, setBtnIsDisabled] = useState(true);

  useEffect(() => {
    let buildings = props.building.data.filter((building) => {
      return building.unId === selUnVal;
    });

    setSelBldngVal(null);
    setSelBldngOptAct(null);
    setSelBldngOpt(dataToOptions(buildings));

    setBtnIsDisabled(true);
  }, [selUnVal, props.building]);

  useEffect(() => {
    let cabinets = props.cabinet.data.filter((cabinet) => {
      return cabinet.buildingId === selBldngVal;
    });

    setSelCabVal(null);
    setSelCabOptAct(null);
    setSelCabOpt(dataToOptions(cabinets));
    setBtnIsDisabled(true);
  }, [selBldngVal, props.cabinet]);

  const tphOnSearch = (searchText) => {
    setTphIsLoading(true);
    axios
      .get(`/api/cabinet/get-cabinets-by-name/${searchText}`)
      .then((res) => {
        if (res.data.status) {
          setTphOptions(res.data.data);
        } else {
          alert('error', res.data.error);
        }
        setTphIsLoading(false);
      })
      .catch((error) => {
        alertException(error.response.status);
      })
      .then(() => {
        preloaderEnd();
      });
  };

  const tphOnChange = (query) => {
    if (typeof query[0] === 'undefined' || typeof query[0].value === 'undefined') return;
    setSelCabVal(query[0].value);
    setBtnIsDisabled(false);
  };

  const tphOnInputChange = () => {
    setBtnIsDisabled(true);
  };

  const selUnOnChange = (data) => {
    let unId = data.value;
    if (isEmpty(unId)) return;
    setSelUnVal(unId);
    props.loadBuildingsByUniversity(unId);
  };

  const selBldngOnChange = (data) => {
    let buildingId = data.value;
    if (isEmpty(buildingId)) return;
    setSelBldngOptAct(data);
    setSelBldngVal(buildingId);
    setBtnIsDisabled(true);
    props.loadCabinetsByBuilding(buildingId);
  };

  const selCabinetOnChange = (data) => {
    if (isEmpty(data.value)) return;
    setSelCabOptAct(data);
    setSelCabVal(data.value);
    setBtnIsDisabled(false);
  };

  const redirect = () => {
    let url = `/schedule/cabinet/${selCabVal}`;
    preloaderStart();
    setTimeout(() => {
      props.push(url);
      props.history.push(url);
    }, 300);
  };

  return (
    <div>
      <p className={'enter-group'}>{t(props.lang, 'Enter cabinet number')}</p>
      <Typeahead
        isLoading={tphIsLoading}
        onSearch={tphOnSearch}
        onChange={tphOnChange}
        onInputChange={tphOnInputChange}
        options={tphOptions}
      />

      <p className="row-delimiter">{t(props.lang, 'or')}</p>

      <Select
        options={props.selUnOpt}
        placeholder={t(props.lang, 'Select university')}
        className={'select select-type-1 ' + (isEmpty(props.selUnOpt) ? 'disabled' : '')}
        onChange={(data) => {
          selUnOnChange(data);
        }}
      />
      <Select
        options={selBldngOpt}
        value={selBldngOptAct}
        placeholder={t(props.lang, 'Select building')}
        className={'select select-type-1 ' + (isEmpty(props.building.data) ? 'disabled' : '')}
        onChange={(data) => {
          selBldngOnChange(data);
        }}
        isDisabled={isEmpty(selUnVal)}
      />
      <Select
        options={selCabOpt}
        value={selCabOptAct}
        placeholder={t(props.lang, 'Select cabinet')}
        className={'select select-type-1 ' + (isEmpty(props.cabinet.data) ? 'disabled' : '')}
        onChange={(data) => {
          selCabinetOnChange(data);
        }}
        isDisabled={isEmpty(selBldngVal)}
      />
      <button type="button" className={'w-100 btn btn-type-2'} onClick={() => redirect()} disabled={btnIsDisabled}>
        {t(props.lang, 'Search')}
      </button>
    </div>
  );
}

const mapToProps = (state) => {
  return {
    building: state.building,
    cabinet: state.cabinet,
    lang: state.lang,
  };
};

const matchDispatch = (dispatch) => {
  return bindActionCreators(
    {push: push, loadBuildingsByUniversity: loadBuildingsByUniversity, loadCabinetsByBuilding: loadCabinetsByBuilding},
    dispatch,
  );
};

export default withRouter(connect(mapToProps, matchDispatch)(index));
