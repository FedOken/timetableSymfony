import React, {useEffect, useState} from 'react';
import DayBlock from '../DayBlock/DayBlock';
import TimeBlock from '../TimeBlock/TimeBlock';
import ScheduleBlock from '../ScheduleBlock/ScheduleBlock';
import ScheduleBlockEmpty from '../ScheduleBlockEmpty/ScheduleBlockEmpty';
import {isEmpty} from '../../../../../src/Helper';
import {getScheduleData} from '../../../../../src/axios/axios';
import './style.scss';
import {withRouter} from 'react-router';
import {connect} from 'react-redux';
import {t} from '../../../../../src/translate/translate';

function Week(props) {
  const [data, setData] = useState({});

  /** Upload schedules for current week, by model*/
  useEffect(() => {
    getScheduleData(props.lang, props.type, props.week.id, props.model.id).then((res) => {
      setData(res);
      console.log(res);
    });
  }, []);

  /** Render for who this schedule (party, teacher, cabinet) */
  const renderTitleName = () => {
    if (props.type === 'cabinet') {
      return `ауд. ${props.model.name}`;
    }
    return props.model.name;
  };

  const renderTimes = (isReverseColor) => {
    return (
      <div className={`col-3 col-sm-2 col-lg-1 time-container ${isReverseColor ? 'last' : ''}`}>
        {Object.keys(data.times).map((key) => {
          let time = data.times[key];

          return (
            <TimeBlock
              key={key}
              class={isReverseColor ? '' : 'left'}
              time={time}
              opacities={data.timesOpacityPercent}
            />
          );
        })}
      </div>
    );
  };

  const renderMainSchBlock = () => {
    return (
      <div className={'main-sch-container col-9 col-sm-8 col-lg-10'}>
        {Object.keys(data.days).map((dayKey, key) => {
          return (
            <div className={'col-11-c col-sm-8-c col-md-4_8 col-lg-3_5 col-xl-2_4'} key={key}>
              <DayBlock key={key} day={data.days[dayKey]} opacities={data.dayOpacityPercent} />
              {Object.values(data.schedules[dayKey]).map((schForDay, keySch) => {
                if (!isEmpty(schForDay)) {
                  return (
                    <ScheduleBlock key={keySch} data={schForDay} buildings={data.buildingsByType} type={props.type} />
                  );
                } else {
                  return <ScheduleBlockEmpty key={keySch} />;
                }
              })}
            </div>
          );
        })}
      </div>
    );
  };

  if (!isEmpty(data)) {
    return (
      <div className={'week type-2'}>
        <div className={'row'}>
          {/*<div className={'col-sm-2 col-lg-1'}></div>*/}
          <div className={'title-container col-9 col-sm-8 col-lg-10 offset-3 offset-sm-2 offset-lg-1'}>
            <div className={'block-title'}>
              <span>{renderTitleName()}</span>
              <span>{t(props.lang, props.week.name, true)}</span>
            </div>
          </div>
        </div>
        <div className={'row'}>
          {renderTimes(false)}
          {renderMainSchBlock()}
          {renderTimes(true)}
        </div>
      </div>
    );
  }

  return <div />;
}

const mapToProps = (state) => {
  return {
    lang: state.lang,
  };
};

export default withRouter(connect(mapToProps)(Week));
