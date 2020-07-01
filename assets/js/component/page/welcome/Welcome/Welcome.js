import React from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import './style.scss';
import {t} from '../../../src/translate/translate';

function index(props) {
  const redirect = (url) => {
    props.push(url);
    props.history.push(url);
  };

  return (
    <div className="welcome row h-100">
      <div className={'w-100'}>
        <div className={'col-12'}>
          <p className={'title'}>{t(props.lang, 'Comfortable schedule is always at hand')}</p>
          <div className={'description'}>
            <p>SCHEDULE - {t(props.lang, 'platform for universities and students')}.</p>
            <p>{t(props.lang, 'Now to plan, search and manage - easy')}</p>
          </div>
        </div>
        <div className={'col-12 col-md-9 col-lg-7 col-xl-6'}>
          <button type={'button'} className={'btn btn-type-1 btn-start w-100'} onClick={() => redirect('/search')}>
            {t(props.lang, 'Start')}
          </button>
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
