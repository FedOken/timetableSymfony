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
    });
  }, []);

  /** Render days (Sunday, Monday...) */
  const renderDays = () => {
    if (isEmpty(data)) return;
    return Object.keys(data.days).map((key) => {
      return <DayBlock key={key} day={data.days[key]} opacities={data.dayOpacityPercent} />;
    });
  };

  /** Render one row with time and schedules */
  const renderTimeAndScheduleRow = () => {
    return Object.keys(data.times).map((key) => {
      let time = data.times[key];

      return (
        <div className={'row'} key={key}>
          <TimeBlock class={'left'} time={time} opacities={data.timesOpacityPercent} />
          {renderScheduleRow(time.id)}
          <TimeBlock
            start={time.timeFrom}
            end={time.timeTo}
            time={time}
            type={key}
            opacities={data.timesOpacityPercent}
          />
        </div>
      );
    });
  };

  /** Render schedules in row */
  const renderScheduleRow = (timeKey) => {
    return Object.keys(data.schedules).map((keySchedule) => {
      if (!Object.prototype.hasOwnProperty.call(data.schedules[keySchedule], timeKey)) return '';

      let schedule = data.schedules[keySchedule][timeKey];
      if (!isEmpty(schedule)) {
        return <ScheduleBlock key={keySchedule} data={schedule} buildings={data.buildingsByType} type={props.type} />;
      } else {
        return <ScheduleBlockEmpty key={keySchedule} />;
      }
    });
  };

  /** Render for who this schedule (party, teacher, cabinet) */
  const renderTitleName = () => {
    if (props.type === 'cabinet') {
      return `ауд. ${props.model.name}`;
    }
    return props.model.name;
  };

  if (!isEmpty(data)) {
    return (
      <div className={'week'}>
        <div className={'row'}>
          <div className={'col-1'}></div>
          <div className={'col-10'}>
            <div className={'block-title'}>
              <span>{renderTitleName()}</span>
              <span>{t(props.lang, props.week.name, true)}</span>
            </div>
          </div>
          <div className={'col-1'}></div>
        </div>
        <div className={'row block-day-container'}>
          <div className={'col-1'}></div>
          {renderDays()}
          <div className={'col-1'}></div>
        </div>
        {renderTimeAndScheduleRow()}
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
