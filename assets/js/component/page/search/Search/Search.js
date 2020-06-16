import React, {useEffect, useState} from 'react';
import Group from './src/Group';
import Teacher from './src/Teacher';
import Cabinet from './src/Cabinet';
import Tabs from '../../../src/Tabs/Tabs';
import TabsItem from '../../../src/Tabs/TabsItem';
import './style.scss';
import {isEmpty, dataToOptions} from '../../../src/Helper';
import {bindActionCreators} from 'redux';
import {loadUniversities} from '../../../../redux/actions/univeristy';
import {iconUser, iconTeacher, iconUniversity} from '../../../src/Icon';
import {connect} from 'react-redux';

function index(props) {
  const [unSelOpt, setUnSelOpt] = useState([]);

  useEffect(() => {
    if (!props.university.isLoaded && !props.university.isLoading) props.loadUniversities();
    if (isEmpty(props.university.data) || !isEmpty(unSelOpt)) return;
    setUnSelOpt(dataToOptions(props.university.data));
  });

  return (
    <div className="search container">
      <div className="col-xs-12 col-sm-6 col-md-4">
        <div className={'block-search'}>
          <span className={'block-name'}>Поиск</span>

          <form>
            <Tabs className={'tabs'} id={'search-tabs'}>
              <TabsItem group={'group'} title={'Группа'} active={true} svg={iconUser}>
                <Group selUnOpt={unSelOpt} />
              </TabsItem>
              <TabsItem group={'teacher'} title={'Преподаватель'} svg={iconTeacher}>
                <Teacher selUnOpt={unSelOpt} />
              </TabsItem>
              <TabsItem group={'cabinet'} title={'Аудитория'} svg={iconUniversity}>
                <Cabinet selUnOpt={unSelOpt} />
              </TabsItem>
            </Tabs>
          </form>
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
