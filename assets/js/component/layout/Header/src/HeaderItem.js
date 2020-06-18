import React from 'react';
import {NavLink, withRouter} from 'react-router-dom';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';

const index = (props) => {
  const reduxRoute = (url) => {
    props.push(url);
  };

  return (
    <div className={'header_item'}>
      <NavLink
        to={props.url}
        className={props.activeLinks.includes(props.pathname) ? 'active' : ''}
        onClick={() => reduxRoute(props.url)}>
        <div className={'icon'}>
          {props.icon}
          {props.icon}
        </div>
        <div className={'text'}>
          <span className={'visible'}>{props.text}</span>
          <span className={'hidden'}>{props.text}</span>
        </div>
      </NavLink>
    </div>
  );
};

function mapStateToProps(state) {
  return {
    pathname: state.router.location.pathname,
  };
}

function matchDispatchToProps(dispatch) {
  return bindActionCreators({push: push}, dispatch);
}

export default withRouter(connect(mapStateToProps, matchDispatchToProps)(index));
