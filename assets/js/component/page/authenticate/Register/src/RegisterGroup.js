import React, {useEffect, useState} from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import Select from '../../../../src/Select';
import axios from 'axios';
import {alert, alertException} from '../../../../src/Alert/Alert';
import {validateForm} from '../../../../src/FormValidation';
import {isEmpty, partiesDataToOptions} from '../../../../src/Helper';
import {preloaderEnd, preloaderStart} from '../../../../src/Preloader/Preloader';
import {withRouter} from 'react-router-dom';
import {loadPartiesByUniversity} from '../../../../../redux/actions/party';

function index(props) {
  const [selUnVal, setSelUnVal] = useState();

  const [selGrOpt, setSelGrOpt] = useState([]);
  const [selGrOptAct, setSelGrOptAct] = useState(null);
  const [selGrVal, setSelGrVal] = useState();

  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  useEffect(() => {
    if (!props.party.isLoading) {
      let parties = props.party.data.filter((party) => {
        return party.unId === selUnVal;
      });

      setSelGrVal(null);
      setSelGrOptAct(null);
      setSelGrOpt(partiesDataToOptions(parties));
    }
  }, [selUnVal, props.party]);

  const selUnOnChange = (data) => {
    let unId = data.value;
    if (isEmpty(unId)) return;
    setSelUnVal(unId);
    props.loadPartiesByUniversity(unId);
  };

  const selGrOnChange = (data) => {
    if (isEmpty(data.value)) return;
    setSelGrOptAct(data);
    setSelGrVal(data.value);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!validateForm('register-user', {selGr: selGrVal})) {
      return;
    }

    let formData = new FormData();
    formData.set('id', selGrVal);
    formData.set('User[email]', email);
    formData.set('User[password]', password);

    preloaderStart();
    axios
      .post('/react/register/create-party-user', formData)
      .then((res) => {
        let data = res.data;
        if (!data.status) {
          alert('error', data.error);
          return;
        }
        redirect(`/register/confirm-email-send/${data.code}`);
      })
      .catch((error) => {
        alertException(error.response.status);
      })
      .then(() => {
        preloaderEnd();
      });
  };

  const redirect = (url) => {
    props.push(url);
    props.history.push(url);
  };

  return (
    <form className={'register-user'} onSubmit={(e) => handleSubmit(e)} autoComplete="off" noValidate>
      <Select
        options={props.selUnOpt}
        placeholder={'Выберите университет'}
        className={'select select-type-1 ' + (isEmpty(props.selUnOpt) ? 'disabled' : '')}
        onChange={(data) => {
          selUnOnChange(data);
        }}
      />
      <div className={`form-group`} id={'selGr'}>
        <Select
          options={selGrOpt}
          value={selGrOptAct}
          placeholder={'Выберите группу'}
          className={'select select-type-1 ' + (isEmpty(selUnVal) ? 'disabled' : '')}
          onChange={(data) => {
            selGrOnChange(data);
          }}
          isDisabled={isEmpty(selUnVal)}
        />
        <span className={'error'} />
      </div>
      <div className={`form-group`}>
        <input
          name={'email'}
          className={`form-control input input-type-1 w-100`}
          placeholder={'Email'}
          type="email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          autoComplete={'off'}
          required
        />
        <span className={'error'} />
      </div>

      <div className={`form-group`}>
        <input
          className={'form-control input input-type-1 w-100'}
          placeholder={'Пароль'}
          type="password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          autoComplete={'new-password'}
          required
        />
        <span className={'error'} />
      </div>
      <button type="submit" className={'w-100 btn btn-type-2'}>
        Подтвердить
      </button>
    </form>
  );
}

function mapStateToProps(state) {
  return {
    party: state.party,
  };
}

function matchDispatchToProps(dispatch) {
  return bindActionCreators({push: push, loadPartiesByUniversity: loadPartiesByUniversity}, dispatch);
}

export default withRouter(connect(mapStateToProps, matchDispatchToProps)(index));
