import React from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import {withRouter} from 'react-router';

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
    props.push(url);
    props.history.push(url);
  };

  return (
    <div className={'block_template'}>
      <p className={'title'}>{props.letter.toUpperCase()}</p>
      <div>{renderElements()}</div>
    </div>
  );
}

function matchDispatchToProps(dispatch) {
  return bindActionCreators({push: push}, dispatch);
}

export default withRouter(connect(null, matchDispatchToProps)(BlockTemplate));
