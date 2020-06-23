import React from 'react';
import {NavLink, withRouter} from 'react-router-dom';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import {preloaderStart} from '../../../src/Preloader/Preloader';

const index = (props) => {
  const reduxRoute = (url) => {
    props.push(url);
    props.history.push(url);
  };

  return (
    <div className={'header_item_logo'}>
      <a onClick={() => reduxRoute(props.url)}>
        {props.icon}
      </a>
    </div>
  );
};

function matchDispatchToProps(dispatch) {
  return bindActionCreators({push: push}, dispatch);
}

export default withRouter(connect(null, matchDispatchToProps)(index));
