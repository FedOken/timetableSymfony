import React, {useEffect, useState} from 'react';
import Tabs from '../../../src/Tabs/Tabs';
import TabsItem from '../../../src/Tabs/TabsItem';
import RegisterGroup from './src/RegisterGroup';
import RegisterTeacher from './src/RegisterTeacher';
import RegisterUniversity from './src/RegisterUniversity';
import {iconUser, iconTeacher, iconUniversity} from '../../../src/Icon';
import './style.scss';
import {bindActionCreators} from 'redux';
import {loadUniversities} from '../../../../redux/actions/univeristy';
import {connect} from 'react-redux';
import {isEmpty, unDataToOptions} from '../../../src/Helper';

function index(props) {
  const [unSelOpt, setUnSelOpt] = useState([]);

  useEffect(() => {
    if (!props.university.isLoaded && !props.university.isLoading) props.loadUniversities();
    if (isEmpty(props.university.data) || !isEmpty(unSelOpt)) return;
    setUnSelOpt(unDataToOptions(props.university.data));
  });

  return (
    <div className="container">
      <div className={'register row'}>
        <div className="col-xs-12 col-sm-4 block-center">
          <div className={'block-register'}>
            <span className={'block-name'}>Регистрация</span>

            <Tabs className={'tabs'} id={'register-tabs'}>
              <TabsItem group={'student'} title={'Студентам'} active={true} svg={iconUser}>
                <RegisterGroup selUnOpt={unSelOpt} />
              </TabsItem>
              <TabsItem group={'teacher'} title={'Преподавателям'} svg={iconTeacher}>
                <RegisterTeacher selUnOpt={unSelOpt} />
              </TabsItem>
              <TabsItem group={'university'} title={'Университетам'} svg={iconUniversity}>
                <RegisterUniversity />
              </TabsItem>
            </Tabs>
          </div>
        </div>
      </div>
    </div>
  );
}

function mapStateToProps(state) {
  return {
    university: state.university,
  };
}

function matchDispatchToProps(dispatch) {
  return bindActionCreators({loadUniversities: loadUniversities}, dispatch);
}

export default connect(mapStateToProps, matchDispatchToProps)(index);
