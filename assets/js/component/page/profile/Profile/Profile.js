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

function index(props) {
  useEffect(() => {
    if (isEmpty(props.user.relation.data) && !props.user.relation.isLoading && !isEmpty(props.user.model.data)) {
      props.loadUserRelation();
    }
  });

  return (
    <div className="profile container">
      <div className={'row'}>
        <div className="col-xs-12 col-sm-6 block-center">
          <Tabs className={'tabs'} id={'profile-tabs'}>
            <TabsItem group={'student'} title={t(props.lang, 'Profile')} active={true} svg={iconProfile}>
              <Common />
            </TabsItem>
            <TabsItem group={'group'} title={t(props.lang, 'Groups')} svg={iconGroup} disabled={props.user.model.data.role === 'ROLE_PARTY_MANAGER'}>
              <Party />
            </TabsItem>
            <TabsItem group={'teacher'} title={t(props.lang, 'Teachers')} svg={iconTeacher}>
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
  return bindActionCreators({loadUserRelation: loadUserRelation}, dispatch);
};

export default withRouter(connect(mapToProps, matchDispatch)(index));
