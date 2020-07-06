import React, {useEffect} from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import {useParams} from 'react-router';
import './style.scss';
import {t} from '../../../src/translate/translate';
import {sendConfirmLetter} from '../../../src/axios/axios';

function index(props) {
  let params = useParams();

  useEffect(() => {
    sendConfirmLetter(props.lang, params.code, {lang: props.lang});
  }, []);

  const redirect = (url) => {
    props.push(url);
    props.history.push(url);
  };

  return (
    <div className="confirm-email-send row h-100">
      <div className={'w-100'}>
        <div className="col-12">
          <p className={'title'}>{t(props.lang, 'Letter to you')}!</p>
          <p className={'description'}>
            {t(props.lang, 'To activate your account, click on the link that was sent to your email')}
          </p>
        </div>
        <div className={'btn-container'}>
          <div className="col-3">
            <button type={'button'} className={'btn btn-type-1 w-100'} onClick={() => redirect('/search')}>
              {t(props.lang, 'To search')}
            </button>
          </div>
          <div className="col-3">
            <button type={'button'} className={'btn btn-type-2 w-100'} onClick={() => redirect('/login')}>
              {t(props.lang, 'Back to log in page')}
            </button>
          </div>
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
