import React, {useState, useEffect} from 'react';
import {AsyncTypeahead} from 'react-bootstrap-typeahead';
import Select from '../../../../src/Select';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import axios from 'axios';
import {withRouter} from 'react-router-dom';
import {preloaderStart, preloaderEnd} from '../../../../src/Preloader/Preloader';
import {alertException} from '../../../../src/Alert/Alert';
import {loadBuildingsByUniversity} from '../../../../../redux/actions/building';
import {loadCabinetsByBuilding} from '../../../../../redux/actions/cabinet';
import {dataToOptions, isEmpty} from '../../../../src/Helper';

function index(props) {
  const [selUnVal, setSelUnVal] = useState();

  const [selBldngOpt, setSelBldngOpt] = useState([]);
  const [selBldngOptAct, setSelBldngOptAct] = useState(null);
  const [selBldngVal, setSelBldngVal] = useState();

  const [selCabinetOpt, setSelCabinetOpt] = useState([]);
  const [selCabinetValue, setSelCabinetValue] = useState();
  const [selCabinetIsDisabled, setSelCabinetIsDisabled] = useState(true);

  const [tphOptions, setTphOptions] = useState([]);
  const [tphIsLoading, setTphIsLoading] = useState(false);

  const [btnIsDisabled, setBtnIsDisabled] = useState(true);
  const [selectedCabinet, setSelectedCabinet] = useState();

  useEffect(() => {
    if (!props.building.isLoading) {
      let buildings = props.building.data.filter((building) => {
        return building.unId === selUnVal;
      });

      setSelBldngVal(null);
      setSelBldngOptAct(null);
      setBtnIsDisabled(true);
      setSelBldngOpt(dataToOptions(buildings));
    }
  }, [selUnVal, props.building, selBldngVal, props.cabinet]);

  const tphOnSearch = (searchText) => {
    setTphIsLoading(true);
    axios
      .post('/react/search/get-cabinets-autocomplete/' + searchText)
      .then((res) => {
        setTphOptions(res.data);
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
    setSelectedCabinet(query[0].value);
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

    // if (typeof data.value === 'undefined') return;
    //
    // setSelBldngValue('');
    // setSelBldngIsDisabled(true);
    //
    // setSelCabinetValue('');
    // setSelCabinetOpt([]);
    // setSelCabinetIsDisabled(true);
    //
    // setBtnIsDisabled(true);
    //
    // axios
    //   .post('/react/search/get-buildings/' + data.value)
    //   .then((res) => {
    //     setSelBldngOpt(res.data);
    //     setSelBldngIsDisabled(false);
    //   })
    //   .catch((error) => {
    //     alertException(error.response.status);
    //   });
  };

  const selBldngOnChange = (data) => {
    let buildingId = data.value;
    if (isEmpty(buildingId)) return;
    setSelBldngOptAct(data);
    setSelBldngVal(buildingId);
    setBtnIsDisabled(true);
    props.loadCabinetsByBuilding(buildingId);

    // if (typeof data.value === 'undefined') return;
    //
    // setSelBldngValue(data);
    // setSelCabinetValue('');
    // setSelCabinetIsDisabled(true);
    // setBtnIsDisabled(true);
    //
    // axios
    //   .post('/react/search/get-cabinets/' + data.value)
    //   .then((res) => {
    //     setSelCabinetOpt(res.data);
    //     setSelCabinetIsDisabled(false);
    //   })
    //   .catch((error) => {
    //     alertException(error.response.status);
    //   });
  };

  const selCabinetOnChange = (data) => {
    if (typeof data.value === 'undefined') return;

    setSelCabinetValue(data);
    setSelectedCabinet(data.value);
    setBtnIsDisabled(false);
  };

  const redirect = () => {
    let url = '/schedule/cabinet/' + selectedCabinet;
    preloaderStart();
    setTimeout(() => {
      props.push(url);
      props.history.push(url);
    }, 300);
  };

  return (
    <div>
      <p className={'enter-group'}>Введите номер аудитории</p>
      <AsyncTypeahead
        id="home-autocomplete"
        className={'input typeahead'}
        isLoading={tphIsLoading}
        onSearch={(query) => {
          tphOnSearch(query);
        }}
        onChange={(query) => {
          tphOnChange(query);
        }}
        onInputChange={() => {
          tphOnInputChange();
        }}
        options={tphOptions}
        useCache={false}
        promptText={'Вводите для поиска...'}
        searchText={'Идет поиск...'}
        emptyLabel={'Ничего не найдено'}
        paginationText={'Показать больше...'}
        maxResults={6}
        minLength={1}
      />

      <p className="row-delimiter">или</p>

      <Select
        options={props.selUnOpt}
        placeholder={'Выберите университет'}
        className={'select select-type-1 ' + (isEmpty(props.selUnOpt) ? 'disabled' : '')}
        onChange={(data) => {
          selUnOnChange(data);
        }}
      />
      <Select
        options={selBldngOpt}
        value={selBldngOptAct}
        placeholder={'Выберите корпус'}
        className={'select select-type-1 ' + (isEmpty(selUnVal) ? 'disabled' : '')}
        onChange={(data) => {
          selBldngOnChange(data);
        }}
        isDisabled={isEmpty(selUnVal)}
      />
      <Select
        options={selCabinetOpt}
        value={selCabinetValue}
        placeholder={'Выберите аудиторию'}
        className={'select select-type-1 ' + (selCabinetIsDisabled ? 'disabled' : '')}
        onChange={(data) => {
          selCabinetOnChange(data);
        }}
        isDisabled={selCabinetIsDisabled}
      />
      <button type="button" className={'w-100 btn btn-type-2'} onClick={() => redirect()} disabled={btnIsDisabled}>
        Поиск
      </button>
    </div>
  );
}

function mapStateToProps(state) {
  return {
    building: state.building,
    cabinet: state.cabinet,
  };
}

function matchDispatchToProps(dispatch) {
  return bindActionCreators(
    {push: push, loadBuildingsByUniversity: loadBuildingsByUniversity, loadCabinetsByBuilding: loadCabinetsByBuilding},
    dispatch,
  );
}

export default withRouter(connect(mapStateToProps, matchDispatchToProps)(index));
