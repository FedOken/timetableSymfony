import React, {useEffect, useState} from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import Select from '../../../../src/Select';
import {validateForm} from '../../../../src/FormValidation';
import {isEmpty, dataToOptions} from '../../../../src/Helper';
import {withRouter} from 'react-router-dom';
import {loadPartiesByUniversity} from '../../../../../redux/actions/party';
import {t} from '../../../../src/translate/translate';
import {createPartyUser} from '../../../../src/axios/axios';

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
      setSelGrOpt(dataToOptions(parties));
    }
  }, [selUnVal, props.party]);

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
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!validateForm(props.lang, 'register-user', {selGr: selGrVal})) {
      return;
    }

    let formData = new FormData();
    formData.set('id', selGrVal);
    formData.set('User[email]', email);
    formData.set('User[password]', password);

    createPartyUser(props.lang, formData).then((res) => {
      redirect(`/register/confirm-email-send/${res}`);
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
        placeholder={t(props.lang, 'Select university')}
        className={'select select-type-1 ' + (isEmpty(props.selUnOpt) ? 'disabled' : '')}
        onChange={(data) => {
          selUnOnChange(data);
        }}
      />
      <div className={`form-group`} id={'selGr'}>
        <Select
          options={selGrOpt}
          value={selGrOptAct}
          placeholder={t(props.lang, 'Select group')}
          className={'select select-type-1 ' + (isEmpty(selGrOpt) ? 'disabled' : '')}
          onChange={(data) => {
            selGrOnChange(data);
          }}
          isDisabled={isEmpty(selGrOpt)}
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
          placeholder={t(props.lang, 'Password')}
          type="password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          autoComplete={'new-password'}
          required
        />
        <span className={'error'} />
      </div>
      <button type="submit" className={'w-100 btn btn-type-2'}>
        {t(props.lang, 'Confirm')}
      </button>
    </form>
  );
}

const mapToProps = (state) => {
  return {
    lang: state.lang,
    party: state.party,
  };
};

const matchDispatch = (dispatch) => {
  return bindActionCreators({push: push, loadPartiesByUniversity: loadPartiesByUniversity}, dispatch);
};

export default withRouter(connect(mapToProps, matchDispatch)(index));
