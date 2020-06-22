import React, {useEffect, useState} from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import {validateForm} from '../../../../src/FormValidation';
import {withRouter} from 'react-router-dom';
import {userLogout, loadUserModel} from '../../../../../redux/actions/user';
import {isEmpty} from '../../../../src/Helper';
import {commonInfo} from './src/CommonInfo';
import axios from 'axios';
import {alert, alertException} from '../../../../src/Alert/Alert';
import {preloaderEnd, preloaderStart} from '../../../../src/Preloader/Preloader';
import {t} from '../../../../src/translate/translate';
import {updateUserModel, userLogoutRequest} from '../../../../src/axios/axios';

function index(props) {
  const [isLoadRel, setIsLoadRel] = useState(false);
  const [isLoadMod, setIsLoadMod] = useState(false);

  const [firstName, setFirstName] = useState('');
  const [lastName, setLastName] = useState('');
  const [email, setEmail] = useState('');
  const [phone, setPhone] = useState('');

  useEffect(() => {
    if (!isEmpty(props.user.model.data) && !isLoadMod) {
      setFirstName(props.user.model.data.first_name);
      setLastName(props.user.model.data.last_name);
      setEmail(props.user.model.data.email);
      setPhone(props.user.model.data.phone);
      setIsLoadMod(true);
    }

    if (!isEmpty(props.user.relation.data) && !isEmpty(props.user.model.data) && !isLoadRel) {
      let relations = props.user.relation.data;
      let model = props.user.model.data;

      switch (model.role) {
        case 'ROLE_ADMIN':
          commonInfo(t(props.lang, 'Access type'), t(props.lang, 'Full access'));
          break;
        case 'ROLE_UNIVERSITY_MANAGER':
          commonInfo(t(props.lang, 'University'), relations.universities[0].name);
          break;
        case 'ROLE_FACULTY_MANAGER':
          commonInfo(t(props.lang, 'University'), relations.universities[0].name);
          commonInfo(t(props.lang, 'Faculty'), relations.faculties[0].name);
          break;
        case 'ROLE_PARTY_MANAGER':
          commonInfo(t(props.lang, 'University'), relations.universities[0].name);
          commonInfo(t(props.lang, 'Faculty'), relations.faculties[0].name);
          commonInfo(t(props.lang, 'Group'), relations.parties[0].name);
          break;
      }
      setIsLoadRel(true);
    }
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!validateForm('profile-profile')) return;

    let formData = new FormData();
    formData.set('User[first_name]', firstName);
    formData.set('User[last_name]', lastName);
    formData.set('User[phone]', phone);

    updateUserModel(props.lang, formData).then((res) => {
      if (res.status) props.loadUserModel();
      else alert('error', res.reason);
    });
  };

  const clickLogout = () => {
    userLogoutRequest(props.lang).then((res) => {
      if (res.status) {
        props.userLogout();
        redirect('/login');
      } else {
        alert('error', res.reason);
      }
    });
  };

  const redirect = (url) => {
    props.push(url);
    props.history.push(url);
  };

  return (
    <form className={'profile-profile'} onSubmit={(e) => handleSubmit(e)} autoComplete="off" noValidate>
      <div className={'block'}>
        <p className={'block-title'}>{t(props.lang, 'Common info')}</p>
        <div className={'profile-info'}></div>
        <div className={`form-group`}>
          <input
            className={`form-control input input-type-1 w-100`}
            placeholder={t(props.lang, 'First name')}
            type="text"
            value={firstName}
            onChange={(e) => setFirstName(e.target.value)}
          />
          <span className={'error'} />
        </div>
        <div className={`form-group`}>
          <input
            className={`form-control input input-type-1 w-100`}
            placeholder={t(props.lang, 'Last name')}
            type="text"
            value={lastName}
            onChange={(e) => setLastName(e.target.value)}
          />
          <span className={'error'} />
        </div>
      </div>
      <div className={'block'}>
        <p className={'block-title'}>{t(props.lang, 'Contacts')}</p>
        <div className={`form-group`}>
          <input
            className={`form-control input input-type-1 w-100`}
            placeholder={'Email'}
            type="text"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            disabled={true}
          />
          <span className={'error'} />
        </div>
        <div className={`form-group`}>
          <input
            className={`form-control input input-type-1 w-100`}
            placeholder={t(props.lang, 'Phone')}
            type="text"
            value={phone}
            onChange={(e) => setPhone(e.target.value)}
          />
          <span className={'error'} />
        </div>
      </div>
      <div className={'buttons'}>
        <button
          type="button"
          className={'btn btn-type-1'}
          onClick={() => {
            clickLogout();
          }}>
          {t(props.lang, 'Log out')}
        </button>
        <button type="submit" className={'btn btn-type-2'}>
          {t(props.lang, 'Save')}
        </button>
      </div>
    </form>
  );
}

const mapToProps = (state) => {
  return {
    lang: state.lang,
    user: state.user,
  };
};

const matchDispatch = (dispatch) => {
  return bindActionCreators({push: push, userLogout: userLogout, loadUserModel: loadUserModel}, dispatch);
};

export default withRouter(connect(mapToProps, matchDispatch)(index));
