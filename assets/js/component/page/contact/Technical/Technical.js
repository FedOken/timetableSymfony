import React, {useState} from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import {validateForm} from '../../../src/FormValidation';
import {preloaderEnd, preloaderStart} from '../../../src/Preloader/Preloader';
import axios from 'axios';
import {alert, alertException} from '../../../src/Alert/Alert';
import {t} from '../../../src/translate/translate';
import {sendContactLetter} from '../../../src/axios/axios';

function index(props) {
  const [email, setEmail] = useState('');
  const [phone, setPhone] = useState('');
  const [message, setMessage] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!validateForm(props.lang, 'contact-technical')) {
      return;
    }

    let formData = new FormData();
    formData.set('Contact[email]', email);
    formData.set('Contact[phone]', phone);
    formData.set('Contact[message]', message);
    formData.set('Contact[type]', 21);

    sendContactLetter({}, formData).then((res) => {
      alert('success', t(props.lang, "Your message has been processed. We'll be in touch soon."));
      redirect(`/contact`);
    });
  };

  const redirect = (url) => {
    props.push(url);
    props.history.push(url);
  };

  return (
    <div className="container">
      <div className={'row technical'}>
        <div className={'col-10'}>
          <p className={'title'}>{t(props.lang, 'Did you find a mistake or know how to do better?')}</p>
          <p className={'description'}>{t(props.lang, 'Describe as much as possible, we will answer you')}</p>
          <form className={'contact-technical'} onSubmit={(e) => handleSubmit(e)} autoComplete="off" noValidate>
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
                    placeholder={t(props.lang, 'Phone')}
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
                    placeholder={t(props.lang, 'Your message')}
                    rows="5"
                    onChange={(e) => setMessage(e.target.value)}
                    required></textarea>
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

const mapToProps = (state) => {
  return {
    lang: state.lang,
  };
};

const matchDispatch = (dispatch) => {
  return bindActionCreators({push: push}, dispatch);
};

export default connect(mapToProps, matchDispatch)(index);
