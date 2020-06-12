import React, {useEffect} from 'react';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {connect} from 'react-redux';
import {preloaderEnd} from '../../../src/Preloader/Preloader';
import './style.scss';
import Tabs from '../../../src/Tabs/Tabs';
import TabsItem from '../../../src/Tabs/TabsItem';
import {iconDoor, iconProfile, iconShield, iconTeacher} from '../../../src/Icon';
import ProfileProfile from './src/ProfileProfile/ProfileProfile';

function index(props) {
  return (
    <div className="profile container">
      <div className="col-xs-12 col-sm-6 block-center">
        <Tabs className={'tabs'} id={'profile-tabs'}>
          <TabsItem group={'student'} title={'Профиль'} active={true} svg={iconProfile}>
            <ProfileProfile />
          </TabsItem>
          <TabsItem group={'teacher'} title={'Преподаватели'} svg={iconTeacher}></TabsItem>
          <TabsItem group={'teacher'} title={'Аудитории'} svg={iconDoor}>
            <p>asdassd</p>
          </TabsItem>
          <TabsItem group={'university'} title={'Безопасность'} svg={iconShield}>
            <p>asdsasdasasd</p>
          </TabsItem>
        </Tabs>
      </div>
    </div>
  );
}

function matchDispatchToProps(dispatch) {
  return bindActionCreators({push: push}, dispatch);
}

export default connect(null, matchDispatchToProps)(index);
