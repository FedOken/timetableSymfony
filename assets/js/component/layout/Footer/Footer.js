import React, {useEffect} from 'react';
import {iconLogo, iconEarth} from '../../src/Icon';
import './style.scss';
import {connect} from 'react-redux';
import {withRouter} from 'react-router';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {changeLang} from '../../../redux/actions/lang';
import {t} from '../../src/translate/translate';

function Footer(props) {
  useEffect(() => {
    document.querySelectorAll('.lang span').forEach((el) => {
      if (el.getAttribute('code') === props.lang) el.classList.add('active_lang');
      else el.classList.remove('active_lang');
    });
  });

  const clickLang = (e) => {
    let svg = document.querySelector('div.lang .earth');
    let langs = document.querySelectorAll('div.lang span');

    if (svg.classList.contains('active')) {
      svg.classList.remove('active');

      langs.forEach(function (lang) {
        lang.style.left = '0px';
      });
    } else {
      svg.classList.add('active');

      langs.forEach(function (lang, index) {
        let i = index + 1;
        lang.style.left = '-' + i * 20 + 'px';
      });
    }
  };

  const changeLanguage = (e) => {
    props.changeLang(e.target.getAttribute('code'));
  };

  const redirect = (url) => {
    props.push(url);
    props.history.push(url);
  };

  return (
    <footer className={'footer row'}>
      <div className={'container-block col-12 col-md-10 col-lg-6 offset-md-1 offset-lg-3'}>
        <div className={'text_block left'}>
          <div className={'top_block'}>
            <span onClick={() => redirect('/term-of-use')}>{t(props.lang, 'Term of Use')}</span>
          </div>
          <div className={'bot_block'}>
            <p>
              <a href="https://www.facebook.com/agooodminute/" target={'_blanc'}>
                {t(props.lang, 'Invented and developed by FedOk')}
              </a>
            </p>
          </div>
        </div>
        <div className={'logo_block'}>{iconLogo}</div>
        <div className={'text_block right'}>
          <div className={'top_block'}>
            <div className={'lang'} onClick={clickLang}>
              <span code={'en-GB'} onClick={(e) => changeLanguage(e)}>
                en
              </span>
              <span code={'ru-RU'} onClick={(e) => changeLanguage(e)}>
                ru
              </span>
              <span code={'uk-UA'} onClick={(e) => changeLanguage(e)}>
                ua
              </span>
              {iconEarth}
            </div>
          </div>
          <div className={'bot_block'}>
            <p>
              © {new Date().getFullYear()}. {t(props.lang, 'All rights reserved')}
            </p>
          </div>
        </div>
      </div>
      <div className={'col-12 mobile-bot_block'}>
        <p>{t(props.lang, 'Invented and developed by FedOk')}</p>
        <p>
          © {new Date().getFullYear()}. {t(props.lang, 'All rights reserved')}
        </p>
      </div>
    </footer>
  );
}

const mapToProps = (state) => {
  return {
    lang: state.lang,
  };
};

const matchDispatch = (dispatch) => {
  return bindActionCreators({push: push, changeLang: changeLang}, dispatch);
};

export default withRouter(connect(mapToProps, matchDispatch)(Footer));
