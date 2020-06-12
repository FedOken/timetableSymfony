import React, {useEffect, useState} from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import {validateForm} from '../../../../../src/FormValidation';
import {withRouter} from 'react-router-dom';
import {userLogout} from '../../../../../../redux/actions/user';
import {isEmpty} from '../../../../../src/Helper';
import CommonInfo from './src/CommonInfo';

function index(props) {
  const [firstName, setFirstName] = useState('');
  const [lastName, setLastName] = useState('');
  const [email, setEmail] = useState('');
  const [phone, setPhone] = useState('');

  useEffect(() => {
    if (!props.user.model.isLoading && !isEmpty(props.user.model.data)) {
      setFirstName(props.user.model.data.first_name ? props.user.model.data.first_name : '');
      setLastName(props.user.model.data.last_name ? props.user.model.data.last_name : '');
      setEmail(props.user.model.data.email);
      setFirstName(props.user.model.data.phone);
    }
  });

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
        <CommonInfo />
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

//export default index;
export default withRouter(connect(mapStateToProps, matchDispatchToProps)(index));
