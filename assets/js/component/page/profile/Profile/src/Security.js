import React, {useState} from 'react';
import {validateForm} from '../../../../src/FormValidation';
import {preloaderEnd, preloaderStart} from '../../../../src/Preloader/Preloader';
import axios from 'axios';
import {alert, alertException} from '../../../../src/Alert/Alert';

function index(props) {
  const [password, setPassword] = useState('');
  const [repPassword, setRepPassword] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!validateForm('profile-security')) return;

    let formData = new FormData();
    formData.set('password', password);
    formData.set('repeatPassword', repPassword);

    preloaderStart();
    axios
      .post(`/api/user/update-password`, formData)
      .then((res) => {
        if (res.data.status) {
          alert('success', 'Password successfully updated.');
        } else {
          alert('error', res.data.error);
        }
      })
      .catch((error) => {
        alertException(error.response.status);
      })
      .then(() => {
        preloaderEnd();
      });
  };

  return (
    <form className={'profile-security'} onSubmit={(e) => handleSubmit(e)} autoComplete="off" noValidate>
      <div className={'block'}>
        <div className={`form-group`}>
          <input
            className={`form-control input input-type-1 w-100`}
            placeholder={'Password'}
            type="password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            autoComplete={'new-password'}
            min={5}
            required
          />
          <span className={'error'} />
        </div>
        <div className={`form-group`}>
          <input
            className={`form-control input input-type-1 w-100`}
            placeholder={'Repeat password'}
            type="password"
            value={repPassword}
            onChange={(e) => setRepPassword(e.target.value)}
            autoComplete={'new-password'}
            required
          />
          <span className={'error'} />
        </div>
      </div>
      <div className={'buttons'}>
        <button type="submit" className={'btn btn-type-2'}>
          Сохранить
        </button>
      </div>
    </form>
  );
}

export default index;
