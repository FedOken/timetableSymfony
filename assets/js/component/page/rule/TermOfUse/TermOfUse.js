import React from 'react';
import './style.scss';
import {bindActionCreators} from 'redux';
import {loadUniversities} from '../../../../redux/actions/univeristy';
import {connect} from 'react-redux';
import {t} from '../../../src/translate/translate';

function index(props) {
  return (
    <div className="container">
      <div className={'term row'}>
        <div className="col-xs-12 col-sm-6 block-center">
          <div className={'block-term'}>
            <span className={'block-name'}>{t(props.lang, 'Term of use')}</span>
            <div className={'group'}>
              <div>1.</div>
              <div>
                {t(props.lang, 'Your access to and use of the service means you agree to be bound by these Terms of Use')};
              </div>
            </div>
            <div className={'group'}>
              <div>2.</div>
              <div>
                {t(props.lang, 'The Company may at any time change the terms and conditions set out in these Rules and such changes shall become effective immediately after their publication on this service')};
              </div>
            </div>
            <div className={'group'}>
              <div>3.</div>
              <div>
                {t(props.lang, 'You must read these Rules before using this service. If you continue to use this service after the Rules are published and/or modified, you agree to be bound by the Rules with all the changes')};
              </div>
            </div>
            <div className={'group'}>
              <div>4.</div>
              <div>
                {t(props.lang, 'If any of the terms of these Terms or changes to them are unacceptable to you, you may not start using or discontinue using this service')};
              </div>
            </div>
            <div className={'group'}>
              <div>5.</div>
              <div>
                {t(props.lang, 'The materials and services of this service are provided "as is" without warranty of any kind. The Company does not guarantee the accuracy or completeness of the materials, programs and services on this service. The Company may make changes to the materials and services provided on this service, as well as to the products and prices mentioned therein, at any time without notice. If the materials and services on this service become obsolete, the Company has no obligation to update them')};
              </div>
            </div>
            <div className={'group'}>
              <div>6.</div>
              <div>
                {t(props.lang, 'By registering on the service, you agree to provide true and accurate information about yourself and your contact details. As a result of registration, you get a login and password, for the security of which you are responsible for yourself. You are also responsible for all activities under your login and password on the service. In case of loss of your registration data you are obliged to inform us about it')};
              </div>
            </div>
            <div className={'group'}>
              <div>7.</div>
              <div>
                {t(props.lang, 'We grant the user a limited, non-exclusive, revocable and non-sublicensable license to access and use our service on users\' devices and to use any content on our service for non-commercial purposes')};
              </div>
            </div>
            <div className={'group'}>
              <div>8.</div>
              <div>
                {t(props.lang, 'All rights to the service are and shall remain the property of our company')};
              </div>
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
  return bindActionCreators({loadUniversities: loadUniversities}, dispatch);
};

export default connect(mapToProps, matchDispatch)(index);
