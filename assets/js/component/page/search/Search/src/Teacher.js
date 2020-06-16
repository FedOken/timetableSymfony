import React, {useState, useEffect} from 'react';
import {AsyncTypeahead} from 'react-bootstrap-typeahead';
import Select from '../../../../src/Select';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import axios from 'axios';
import {withRouter} from 'react-router-dom';
import {preloaderStart, preloaderEnd} from '../../../../src/Preloader/Preloader';
import {alert, alertException} from '../../../../src/Alert/Alert'
import {loadTeachersByUniversity} from '../../../../../redux/actions/teacher';
import {isEmpty, dataToOptions} from '../../../../src/Helper'

function index(props) {
  const [selUnVal, setSelUnVal] = useState();

  const [selTchrOpt, setSelTchrOpt] = useState([]);
  const [selTchrOptAct, setSelTchrOptAct] = useState(null);
  const [selTchrVal, setSelTchrVal] = useState();

  const [tphOptions, setTphOptions] = useState([]);
  const [tphIsLoading, setTphIsLoading] = useState(false);

  const [btnIsDisabled, setBtnIsDisabled] = useState(true);

  useEffect(() => {
    if (!props.teacher.isLoading) {
      let teacher = props.teacher.data.filter((teacher) => {
        return teacher.unId === selUnVal;
      });

      setSelTchrVal(null);
      setSelTchrOptAct(null);
      setBtnIsDisabled(true);
      setSelTchrOpt(dataToOptions(teacher));
    }
  }, [selUnVal, props.teacher]);

  const tphOnSearch = (searchText) => {
    setTphIsLoading(true);
    axios
      .get(`/api/teacher/get-teachers-by-name/${searchText}`)
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
    setSelTchrVal(query[0].value);
    setBtnIsDisabled(false);
  };

  const tphOnInputChange = () => {
    setBtnIsDisabled(true);
  };

  const selUnOnChange = (data) => {
    let unId = data.value;
    if (isEmpty(unId)) return;
    setSelUnVal(unId);
    props.loadTeachersByUniversity(unId);
  };

  const selTchrOnChange = (data) => {
    if (isEmpty(data.value)) return;
    setSelTchrOptAct(data);
    setSelTchrVal(data.value);
    setBtnIsDisabled(false);
  };

  const redirect = () => {
    let url = `/schedule/teacher/${selTchrVal}`;
    preloaderStart();
    setTimeout(() => {
      props.push(url);
      props.history.push(url);
    }, 300);
  };

  return (
    <div>
      <p className={'enter-group'}>Введите фамилию преподавателя</p>
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
        name="group-select"
        options={props.selUnOpt}
        placeholder={'Выберите университет'}
        className={'select select-type-1 ' + (isEmpty(props.selUnOpt) ? 'disabled' : '')}
        onChange={(data) => {
          selUnOnChange(data);
        }}
      />
      <Select
        name="group-select"
        options={selTchrOpt}
        value={selTchrOptAct}
        placeholder={'Выберите преподавателя'}
        className={'select select-type-1 ' + (isEmpty(selUnVal) ? 'disabled' : '')}
        onChange={(data) => {
          selTchrOnChange(data);
        }}
        isDisabled={isEmpty(selUnVal)}
      />
      <button type="button" className={'w-100 btn btn-type-2'} onClick={() => redirect()} disabled={btnIsDisabled}>
        Поиск
      </button>
    </div>
  );
}

function mapStateToProps(state) {
  return {
    teacher: state.teacher,
  };
}

function matchDispatchToProps(dispatch) {
  return bindActionCreators({push: push, loadTeachersByUniversity: loadTeachersByUniversity}, dispatch);
}

export default withRouter(connect(mapStateToProps, matchDispatchToProps)(index));
