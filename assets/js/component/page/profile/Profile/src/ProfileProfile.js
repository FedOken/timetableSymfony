import React, {useEffect, useState} from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import {validateForm} from '../../../../src/FormValidation';
import {withRouter} from 'react-router-dom';
import axios from 'axios';
import {alertException} from '../../../../src/Alert/Alert';
import {preloaderEnd, preloaderStart} from '../../../../src/Preloader/Preloader';
import {userLogout} from '../../../../../redux/actions/user';
import {isEmpty} from '../../../../src/Helper';

function index(props) {
  const [firstName, setFirstName] = useState('');
  const [lastName, setLastName] = useState('');
  const [email, setEmail] = useState('');
  const [phone, setPhone] = useState('');

  useEffect(() => {

    if (props.user.isLoaded && !isEmpty(props.user.data)) {
      setFirstName(props.user.data.first_name ? props.user.data.first_name : '');
      setLastName(props.user.data.last_name ? props.user.data.last_name : '');
      setEmail(props.user.data.email);
      setFirstName(props.user.data.phone);
    }
  });

  const renderMainInfo = () => {
    // if (props.user.isLoaded && !isEmpty(props.user.data)) {
    //   console.log(1);
    //   preloaderStart();
    //   axios
    //     .post(`/react/profile/get-user-data/${props.user.data.code}`)
    //     .then((res) => {
    //       if (res.data.status) {
    //         let data = res.data.data;
    //         for (let prop in data) {
    //           let p = document.createElement('p');
    //           p.innerHTML = data[prop];
    //           let span = document.createElement('span');
    //           span.innerHTML = prop + ':';
    //           p.prepend(span);
    //
    //           let cont = document.querySelector('.profile-info');
    //           cont.appendChild(p);
    //         }
    //       }
    //     })
    //     .catch((error) => {
    //       alertException(error.response.status);
    //     })
    //     .then(() => {
    //       preloaderEnd();
    //     });
    // }
  };

  const test = () => {
    if (props.user.isLoaded && !isEmpty(props.user.data)) {
      setEmail(props.user.data.email)
      return email;
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!validateForm('profile-profile')) return;
  };

  const clickLogout = () => {
    props.userLogout();
    redirect('/login');
  };

  const redirect = (url) => {
    props.push(url);
    props.history.push(url);
  };

  return (
    <form className={'profile-profile'} onSubmit={(e) => handleSubmit(e)} autoComplete="off" noValidate>
      <div className={'block'}>
        <p className={'block-title'}>Общая информация</p>
        <div className={'profile-info'}>{renderMainInfo()}</div>
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
        {/*{test()}*/}
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
        <button type="button" className={'btn btn-type-1'} onClick={() => {clickLogout()}}>
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
  return bindActionCreators({push: push, userLogout: userLogout}, dispatch);
}

export default withRouter(connect(mapStateToProps, matchDispatchToProps)(index));
