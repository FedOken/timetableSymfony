import React, {useState} from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import './style.scss';
import {validateForm} from '../../../src/FormValidation';
import {preloaderEnd, preloaderStart} from '../../../src/Preloader/Preloader';
import axios from 'axios';
import {alert, alertException} from '../../../src/Alert/Alert';

function index(props) {
  const [email, setEmail] = useState('');
  const [phone, setPhone] = useState('');
  const [message, setMessage] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!validateForm('contact-business')) {
      return;
    }

    let formData = new FormData();
    formData.set('Contact[email]', email);
    formData.set('Contact[phone]', phone);
    formData.set('Contact[message]', message);
    formData.set('Contact[type]', 20);

    preloaderStart();
    axios
      .post('/api/contact/send-contact-letter', formData)
      .then((res) => {
        let data = res.data;
        if (!res.data.status) {
          alert('error', data.error);
        }
        alert('success', "Your message has been processed. We'll be in touch soon.");
        redirect(`/contact`);
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
    <div className="container">
      <div className={'row business'}>
        <div className={'col-8'}>
          <p className={'title'}>И Вы может принять участие в проекте!</p>
          <p className={'description'}>Заполните форму ниже и с Вами скоро свяжутся</p>
          <form className={'contact-business'} onSubmit={(e) => handleSubmit(e)} autoComplete="off" noValidate>
            <div className={'row form'}>
              <div className={'col-4'}>
                <div className={`form-group`}>
                  <input
                    className={'form-control input input-type-1 w-100'}
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
                    placeholder={'Телефон'}
                    type="text"
                    value={phone}
                    onChange={(e) => setPhone(e.target.value)}
                    autoComplete={'off'}
                  />
                  <span className={'error'} />
                </div>
                <button type={'submit'} className={'btn btn-type-2 w-100'}>
                  Отправить
                </button>
              </div>
              <div className={'col-8'}>
                <div className={`form-group`}>
                  <textarea
                    className={'form-control txt-area area-type-1'}
                    placeholder={'Ваше сообщение'}
                    rows="5"
                    onChange={(e) => setMessage(e.target.value)}
                    required
                  >
                  </textarea>
                  <span className={'error'} />
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
}

function matchDispatchToProps(dispatch) {
  return bindActionCreators({push: push}, dispatch);
}

export default connect(null, matchDispatchToProps)(index);
