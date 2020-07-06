import React, {useState, useEffect} from 'react';
import Select from '../../../../src/Select';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import axios from 'axios';
import {withRouter} from 'react-router-dom';
import {preloaderStart, preloaderEnd} from '../../../../src/Preloader/Preloader';
import {alert, alertException} from '../../../../src/Alert/Alert';
import {loadTeachersByUniversity} from '../../../../../redux/actions/teacher';
import {isEmpty, dataToOptions} from '../../../../src/Helper';
import Typeahead from '../../../../src/Typeahead';
import {t} from '../../../../src/translate/translate';

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
    setSelTchrOpt(null);
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
      <p className={'enter-group'}>{t(props.lang, 'Enter teacher name')}</p>
      <Typeahead
        isLoading={tphIsLoading}
        onSearch={tphOnSearch}
        onChange={tphOnChange}
        onInputChange={tphOnInputChange}
        options={tphOptions}
      />

      <p className="row-delimiter">{t(props.lang, 'or')}</p>

      <Select
        name="group-select"
        options={props.selUnOpt}
        placeholder={t(props.lang, 'Select university')}
        className={'select select-type-1 ' + (isEmpty(props.selUnOpt) ? 'disabled' : '')}
        onChange={(data) => {
          selUnOnChange(data);
        }}
        isDisabled={isEmpty(props.selUnOpt)}
      />
      <Select
        name="group-select"
        options={selTchrOpt}
        value={selTchrOptAct}
        placeholder={t(props.lang, 'Select teacher')}
        className={'select select-type-1 ' + (isEmpty(selTchrOpt) ? 'disabled' : '')}
        onChange={(data) => {
          selTchrOnChange(data);
        }}
        isDisabled={isEmpty(selTchrOpt)}
      />
      <button type="button" className={'w-100 btn btn-type-2'} onClick={() => redirect()} disabled={btnIsDisabled}>
        {t(props.lang, 'Search')}
      </button>
    </div>
  );
}

const mapToProps = (state) => {
  return {
    teacher: state.teacher,
    lang: state.lang,
  };
};

const matchDispatch = (dispatch) => {
  return bindActionCreators({push: push, loadTeachersByUniversity: loadTeachersByUniversity}, dispatch);
};

export default withRouter(connect(mapToProps, matchDispatch)(index));
