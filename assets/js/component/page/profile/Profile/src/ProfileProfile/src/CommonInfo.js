import React, {useEffect, useState} from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import axios from 'axios';
import {loadUserRelation} from '../../../../../../../redux/actions/user';
import {isEmpty} from '../../../../../../src/Helper';

function index(props) {
  const [firstName, setFirstName] = useState('');

  useEffect(() => {
    if (!props.user.relation.isLoading && isEmpty(props.user.relation.data)) {
      props.loadUserRelation();
    }
    if (!isEmpty(props.user.relation.data)) {
      console.log(123);
    }
    //   let data = res.data.data;
    //   for (let prop in data) {
    //     let p = document.createElement('p');
    //     p.innerHTML = data[prop];
    //     let span = document.createElement('span');
    //     span.innerHTML = prop + ':';
    //     p.prepend(span);
    //
    //     let cont = document.querySelector('.profile-info');
    //     cont.appendChild(p);
    //   }
    // }
  });



  const redirect = (url) => {
    props.push(url);
    props.history.push(url);
  };

  return <div className={'profile-info'}>{'asd'}</div>;
}

function mapStateToProps(state) {
  return {
    user: state.user,
  };
}

function matchDispatchToProps(dispatch) {
  return bindActionCreators({push: push, loadUserRelation: loadUserRelation}, dispatch);
}

//export default index;
export default withRouter(connect(mapStateToProps, matchDispatchToProps)(index));
