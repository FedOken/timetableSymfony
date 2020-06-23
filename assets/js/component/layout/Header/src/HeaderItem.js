import React from 'react';
import {NavLink, withRouter} from 'react-router-dom';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import {preloaderStart} from '../../../src/Preloader/Preloader';
import {isEmpty} from '../../../src/Helper';

const index = (props) => {
  const reduxRoute = (url) => {
    if (url === '/profile' && isEmpty(props.user.relation.data)) {
      preloaderStart();
      setTimeout(() => {
        props.push(url);
        props.history.push(url);
      }, 300);
    } else {
      props.history.push(url);
      props.push(url);
    }
  };

  const renderContent = () => {
    return (
      <div>
        <div className={'icon'}>
          {props.icon}
          {props.icon}
        </div>
        <div className={'text'}>
          <span className={'visible'}>{props.text}</span>
          <span className={'hidden'}>{props.text}</span>
        </div>
      </div>
    );
  };

  if (props.isBlanc) {
    return (
      <div className={'header_item'}>
        <a href={props.url} target={'_blanc'}>
          {renderContent()}
        </a>
      </div>
    );
  }
  return (
    <div className={'header_item'}>
      <a className={props.activeLinks.includes(props.pathname) ? 'active' : ''} onClick={() => reduxRoute(props.url)}>
        {renderContent()}
      </a>
    </div>
  );
};

function mapStateToProps(state) {
  return {
    pathname: state.router.location.pathname,
    user: state.user,
  };
}

function matchDispatchToProps(dispatch) {
  return bindActionCreators({push: push}, dispatch);
}

export default withRouter(connect(mapStateToProps, matchDispatchToProps)(index));
