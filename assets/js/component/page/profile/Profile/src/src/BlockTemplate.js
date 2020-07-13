import React from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import {withRouter} from 'react-router';
import {preloaderStart} from '../../../../../src/Preloader/Preloader';

function BlockTemplate(props) {
  const renderElements = () => {
    return props.models.map((model, key) => {
      return (
        <p className={'element'} key={key} onClick={() => redirect(`/schedule/${props.type}/${model.id}`)}>
          {model.name}
        </p>
      );
    });
  };

  const redirect = (url) => {
    preloaderStart();
    setTimeout(() => {
      props.push(url);
      props.history.push(url);
    }, 300);
  };

  let classes = '';
  if (props.type === 'teacher') classes = 'col-6 col-md-6 col-lg-4';
  else classes = 'col-4 col-md-3 col-lg-3 col-xl-2';
  return (
    <div className={`block_template ${classes}`}>
      <p className={'title'}>{props.letter.toUpperCase()}</p>
      <div>{renderElements()}</div>
    </div>
  );
}

function matchDispatchToProps(dispatch) {
  return bindActionCreators({push: push}, dispatch);
}

export default withRouter(connect(null, matchDispatchToProps)(BlockTemplate));
