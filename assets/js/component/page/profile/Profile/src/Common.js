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
          commonInfo('Access type', 'Full access');
          break;
        case 'ROLE_UNIVERSITY_MANAGER':
          commonInfo('Университет', relations.universities[0].name);
          break;
        case 'ROLE_FACULTY_MANAGER':
          commonInfo('Университет', relations.universities[0].name);
          commonInfo('Факультет', relations.faculties[0].name);
          break;
        case 'ROLE_PARTY_MANAGER':
          commonInfo('Университет', relations.universities[0].name);
          commonInfo('Факультет', relations.faculties[0].name);
          commonInfo('Группа', relations.parties[0].name);
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

    preloaderStart();
    axios
      .post(`/api/user/update-model`, formData)
      .then((res) => {
        if (res.data.status) {
          props.loadUserModel();
        } else {
          alert('error', res.data.reason);
        }
      })
      .catch((error) => {
        alertException(error.response.status);
      })
      .then(() => {
        preloaderEnd();
      });
  };

  const clickLogout = () => {
    preloaderStart();
    axios
      .post(`/api/user/logout-start`)
      .then((res) => {
        if (res.data.status) {
          props.userLogout();
          redirect('/login');
          preloaderEnd();
        }
      })
      .catch((error) => {
        alertException(error.response.status);
        preloaderEnd();
      });
  };

  const redirect = (url) => {
    props.push(url);
    props.history.push(url);
  };

  return (
    <form className={'profile-profile'} onSubmit={(e) => handleSubmit(e)} autoComplete="off" noValidate>
      <div className={'block'}>
        <p className={'block-title'}>Общая информация</p>
        <div className={'profile-info'}></div>
        <div className={`form-group`}>
          <input
            className={`form-control input input-type-1 w-100`}
            placeholder={'Имя'}
            type="text"
            value={firstName}
            onChange={(e) => setFirstName(e.target.value)}
          />
          <span className={'error'} />
        </div>
        <div className={`form-group`}>
          <input
            className={`form-control input input-type-1 w-100`}
            placeholder={'Фамилия'}
            type="text"
            value={lastName}
            onChange={(e) => setLastName(e.target.value)}
          />
          <span className={'error'} />
        </div>
      </div>
      <div className={'block'}>
        <p className={'block-title'}>Контакты</p>
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
            placeholder={'Телефон'}
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
          Выйти
        </button>
        <button type="submit" className={'btn btn-type-2'}>
          Сохранить
        </button>
      </div>
    </form>
  );
}

function mapStateToProps(state) {
  return {
    user: state.user,
  };
}

function matchDispatchToProps(dispatch) {
  return bindActionCreators({push: push, userLogout: userLogout, loadUserModel: loadUserModel}, dispatch);
}

export default withRouter(connect(mapStateToProps, matchDispatchToProps)(index));
