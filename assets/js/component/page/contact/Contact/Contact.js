import React from 'react';
import {Link} from 'react-router-dom';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import './style.scss';
import {t} from '../../../src/translate/translate';
import {iconBusiness, iconCog} from '../../../src/Icon';

function index(props) {
  const redirect = (url) => {
    props.push(url);
    props.history.push(url);
  };

  return (
    <div className={'contact row h-100'}>
      <div className={'w-100'}>
        <div className="col-12">
          <p className={'title'}>{t(props.lang, 'Contact us')}</p>
        </div>
        <div className={'block_container'}>
          <div className={'col-6 col-md-4 col-lg-3 block_content'} onClick={() => redirect('/contact/business')}>
            <div className={'image'}>
              {iconBusiness}
              {iconBusiness}
            </div>
            <div className={'text'}>
              <p className={'visible'}>{t(props.lang, 'For business matters')}</p>
              <p className={'hidden'}>{t(props.lang, 'For business matters')}</p>
            </div>
          </div>
          <div className={'col-1 between'}>
            <p>{t(props.lang, 'or')}</p>
          </div>
          <div className={'col-6 col-md-4 col-lg-3 block_content'} onClick={() => redirect('/contact/technical')}>
            <div className={'image'}>
              {iconCog}
              {iconCog}
            </div>

            <div className={'text'}>
              <p className={'visible'}>{t(props.lang, 'For technical issues')}</p>
              <p className={'hidden'}>{t(props.lang, 'For technical issues')}</p>
            </div>
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
