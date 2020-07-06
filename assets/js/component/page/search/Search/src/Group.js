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
import {isEmpty, dataToOptions} from '../../../../src/Helper';
import {loadPartiesByUniversity} from '../../../../../redux/actions/party';
import {t} from '../../../../src/translate/translate';
import Typeahead from '../../../../src/Typeahead';

function index(props) {
  const [selUnVal, setSelUnVal] = useState();

  const [selGrOpt, setSelGrOpt] = useState([]);
  const [selGrOptAct, setSelGrOptAct] = useState(null);
  const [selGrVal, setSelGrVal] = useState();

  const [tphOptions, setTphOptions] = useState([]);
  const [tphIsLoading, setTphIsLoading] = useState(false);

  const [btnIsDisabled, setBtnIsDisabled] = useState(true);

  useEffect(() => {
    if (!props.party.isLoading) {
      let parties = props.party.data.filter((party) => {
        return party.unId === selUnVal;
      });

      setSelGrVal(null);
      setSelGrOptAct(null);
      setBtnIsDisabled(true);
      setSelGrOpt(dataToOptions(parties));
    }
  }, [selUnVal, props.party]);

  const tphOnSearch = (searchText) => {
    setTphIsLoading(true);
    axios
      .get(`/api/party/get-parties-by-name/${searchText}`)
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
    setSelGrVal(query[0].value);
    setBtnIsDisabled(false);
  };

  const tphOnInputChange = () => {
    setBtnIsDisabled(true);
  };

  const selUnOnChange = (data) => {
    let unId = data.value;
    if (isEmpty(unId)) return;
    setSelUnVal(unId);
    setSelGrOpt(null);
    props.loadPartiesByUniversity(unId);
  };

  const selGrOnChange = (data) => {
    if (isEmpty(data.value)) return;
    setSelGrOptAct(data);
    setSelGrVal(data.value);
    setBtnIsDisabled(false);
  };

  const redirect = () => {
    let url = `/schedule/group/${selGrVal}`;
    preloaderStart();
    setTimeout(() => {
      props.push(url);
      props.history.push(url);
    }, 300);
  };

  return (
    <div>
      <p className={'enter-group'}>{t(props.lang, 'Enter group name')}</p>
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
        options={selGrOpt}
        value={selGrOptAct}
        placeholder={t(props.lang, 'Select group')}
        className={'select select-type-1 ' + (isEmpty(selGrOpt) ? 'disabled' : '')}
        onChange={(data) => {
          selGrOnChange(data);
        }}
        isDisabled={isEmpty(selGrOpt)}
      />
      <button type="button" className={'w-100 btn btn-type-2'} onClick={() => redirect()} disabled={btnIsDisabled}>
        {t(props.lang, 'Search')}
      </button>
    </div>
  );
}

const mapToProps = (state) => {
  return {
    party: state.party,
    lang: state.lang,
  };
};

const matchDispatch = (dispatch) => {
  return bindActionCreators({push: push, loadPartiesByUniversity: loadPartiesByUniversity}, dispatch);
};

export default withRouter(connect(mapToProps, matchDispatch)(index));
