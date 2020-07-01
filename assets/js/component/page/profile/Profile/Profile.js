import React, {useEffect} from 'react';
import {bindActionCreators} from 'redux';
import {connect} from 'react-redux';
import './style.scss';
import Tabs from '../../../src/Tabs/Tabs';
import TabsItem from '../../../src/Tabs/TabsItem';
import {iconDoor, iconProfile, iconShield, iconTeacher, iconGroup} from '../../../src/Icon';
import Common from './src/Common';
import Teacher from './src/Teacher';
import Party from './src/Party';
import Cabinet from './src/Cabinet';
import Security from './src/Security';
import {isEmpty} from '../../../src/Helper';
import {loadUserRelation} from '../../../../redux/actions/user';
import {withRouter} from 'react-router';
import {t} from '../../../src/translate/translate';
import {preloaderEnd, preloaderStart} from '../../../src/Preloader/Preloader';
import {push} from 'connected-react-router';
import {getRoleLabel} from '../../../src/Auth';

function index(props) {
  useEffect(() => {
    if (!props.user.relation.isLoaded && !props.user.relation.isLoading && !isEmpty(props.user.model.data)) {
      props.loadUserRelation();
    } else if (!isEmpty(props.user.relation.data) || props.user.relation.isLoaded) {
      preloaderEnd();
    }
  });

  const redirect = (url) => {
    preloaderStart();
    setTimeout(() => {
      props.push(url);
      props.history.push(url);
    }, 300);
  };

  return (
    <div className="profile row h-100">
      <div className="col-12 col-md-8 col-lg-6 col-xl-6">
        <Tabs className={'tabs'} id={'profile-tabs'}>
          <TabsItem group={'student'} title={t(props.lang, 'Profile')} active={true} svg={iconProfile}>
            <Common />
          </TabsItem>
          <TabsItem
            group={'group'}
            title={t(props.lang, 'Groups')}
            svg={iconGroup}
            disabled={props.user.model.data.role === getRoleLabel('party')}>
            <Party />
          </TabsItem>
          <TabsItem
            group={'teacher'}
            title={t(props.lang, 'Teachers')}
            svg={iconTeacher}
            disabled={props.user.model.data.role === getRoleLabel('teacher')}>
            <Teacher />
          </TabsItem>
          <TabsItem group={'cabinet'} title={t(props.lang, 'Cabinets')} svg={iconDoor}>
            <Cabinet />
          </TabsItem>
          <TabsItem group={'university'} title={t(props.lang, 'Security')} svg={iconShield}>
            <Security />
          </TabsItem>
        </Tabs>
      </div>
    </div>
  );
}

const mapToProps = (state) => {
  return {
    lang: state.lang,
    user: state.user,
  };
};

const matchDispatch = (dispatch) => {
  return bindActionCreators({push: push, loadUserRelation: loadUserRelation}, dispatch);
};

export default withRouter(connect(mapToProps, matchDispatch)(index));
