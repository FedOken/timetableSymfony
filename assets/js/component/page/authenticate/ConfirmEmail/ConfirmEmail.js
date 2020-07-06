import React, {useEffect} from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import {useParams} from 'react-router';
import {confirmUserViaEmailCode} from '../../../src/axios/axios';
import {alert} from '../../../src/Alert/Alert';
import {t} from '../../../src/translate/translate';

function index(props) {
  let params = useParams();

  useEffect(() => {
    confirmUserViaEmailCode(props.lang, params).then((res) => {
      if (res.status) alert('success', t(props.lang, 'Account successful activated. You can log in!'));
      else alert('error', t(props.lang, res.error));
      redirect('/login');
    });
  }, []);

  const redirect = (url) => {
    props.push(url);
    props.history.push(url);
  };

  return <div></div>;
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
