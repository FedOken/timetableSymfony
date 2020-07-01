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
import {t} from '../../../src/translate/translate';

function index(props) {
  const [unSelOpt, setUnSelOpt] = useState([]);

  useEffect(() => {
    if (!props.university.isLoaded && !props.university.isLoading) props.loadUniversities();
    if (isEmpty(props.university.data) || !isEmpty(unSelOpt)) return;
    setUnSelOpt(dataToOptions(props.university.data));
  });

  return (
    <div className={'search row h-100'}>
      <div className="col-12 col-md-6 col-lg-5 col-xl-4">
        <div className={'block-search'}>
          <span className={'block-name'}>{t(props.lang, 'Search')}</span>
          <form>
            <Tabs className={'tabs'} id={'search-tabs'}>
              <TabsItem group={'group'} title={t(props.lang, 'Groups')} active={true} svg={iconUser}>
                <Group selUnOpt={unSelOpt} />
              </TabsItem>
              <TabsItem group={'teacher'} title={t(props.lang, 'Teachers')} svg={iconTeacher}>
                <Teacher selUnOpt={unSelOpt} />
              </TabsItem>
              <TabsItem group={'cabinet'} title={t(props.lang, 'Cabinets')} svg={iconUniversity}>
                <Cabinet selUnOpt={unSelOpt} />
              </TabsItem>
            </Tabs>
          </form>
        </div>
      </div>
    </div>
  );
}

const mapToProps = (state) => {
  return {
    university: state.university,
    lang: state.lang,
  };
};

const matchDispatch = (dispatch) => {
  return bindActionCreators({loadUniversities: loadUniversities}, dispatch);
};

export default connect(mapToProps, matchDispatch)(index);
