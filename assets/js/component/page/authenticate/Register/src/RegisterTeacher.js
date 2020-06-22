import React, {useEffect, useState} from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import Select from '../../../../src/Select';
import {validateForm} from '../../../../src/FormValidation';
import {isEmpty, dataToOptions} from '../../../../src/Helper';
import {withRouter} from 'react-router-dom';
import {loadTeachersByUniversity} from '../../../../../redux/actions/teacher';
import {t} from '../../../../src/translate/translate';
import {createTeacherUser} from '../../../../src/axios/axios';

function index(props) {
  const [selUnVal, setSelUnVal] = useState();

  const [selTchrOpt, setSelTchrOpt] = useState([]);
  const [selTchrOptAct, setSelTchrOptAct] = useState(null);
  const [selTchrVal, setSelTchrVal] = useState();

  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  useEffect(() => {
    if (!props.teacher.isLoading) {
      let parties = props.teacher.data.filter((teacher) => {
        return teacher.unId === selUnVal;
      });

      setSelTchrVal(null);
      setSelTchrOptAct(null);
      setSelTchrOpt(dataToOptions(parties));
    }
  }, [selUnVal, props.teacher]);

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
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!validateForm(props.lang, 'register-teacher', {selTchr: selTchrVal})) {
      return;
    }

    let formData = new FormData();
    formData.set('id', selTchrVal);
    formData.set('User[email]', email);
    formData.set('User[password]', password);

    createTeacherUser(props.lang, formData).then((res) => {
      redirect(`/register/confirm-email-send/${res}`);
    });
  };

  const redirect = (url) => {
    props.push(url);
    props.history.push(url);
  };

  return (
    <form className={'register-teacher'} onSubmit={(e) => handleSubmit(e)} autoComplete="off" noValidate>
      <Select
        options={props.selUnOpt}
        placeholder={t(props.lang, 'Select university')}
        className={'select select-type-1 ' + (isEmpty(props.selUnOpt) ? 'disabled' : '')}
        onChange={(data) => {
          selUnOnChange(data);
        }}
      />
      <div className={`form-group`} id={'selTchr'}>
        <Select
          options={selTchrOpt}
          value={selTchrOptAct}
          placeholder={t(props.lang, 'Select teacher')}
          className={'select select-type-1 ' + (isEmpty(selTchrOpt) ? 'disabled' : '')}
          onChange={(data) => {
            selTchrOnChange(data);
          }}
          isDisabled={isEmpty(selTchrOpt)}
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
    teacher: state.teacher,
  };
};

const matchDispatch = (dispatch) => {
  return bindActionCreators({push: push, loadTeachersByUniversity: loadTeachersByUniversity}, dispatch);
};

export default withRouter(connect(mapToProps, matchDispatch)(index));
