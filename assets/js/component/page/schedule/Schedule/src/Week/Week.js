import React, {useEffect, useState} from 'react';
import DayBlock from '../DayBlock/DayBlock';
import TimeBlock from '../TimeBlock/TimeBlock';
import ScheduleBlock from '../ScheduleBlock/ScheduleBlock';
import {preloaderEnd, preloaderStart} from '../../../../../src/Preloader/Preloader';
import axios from 'axios';
import { alert, alertException } from "../../../../../src/Alert/Alert";
import ScheduleBlockEmpty from '../ScheduleBlockEmpty/ScheduleBlockEmpty';
import {isEmpty} from '../../../../../src/Helper';
import {getScheduleData} from '../../../../../src/axios/axios';
import './style.scss';

export default function Week(props) {
  const [week] = useState(props.week);
  const [model] = useState(props.model);
  const [type] = useState(props.type);

  const [data, setData] = useState({});

  useEffect(() => {
    // getScheduleData(type, week.id, model.id).then((res) => {
    //   setData(res);
    // });
    preloaderStart();
    axios
      .post(`/api/schedule/get-data/${type}/${week.id}/${model.id}`)
      .then((res) => {
        setData(res.data);
      })
      .catch((error) => {
        alertException(error.response.status);
      })
      .then(() => {
        preloaderEnd();
      });
  }, []);

  const renderDays = () => {
    if (isEmpty(data)) return;
    return Object.keys(data.days).map((key) => {
      return <DayBlock key={key} day={data.days[key]} opacities={data.dayOpacityPercent} />;
    });
  };

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

  const renderScheduleRow = (timeKey) => {
    return Object.keys(data.schedules).map((keySchedule) => {
      if (!Object.prototype.hasOwnProperty.call(data.schedules[keySchedule], timeKey)) return '';

      let schedule = data.schedules[keySchedule][timeKey];
      if (!isEmpty(schedule)) {
        return <ScheduleBlock key={keySchedule} data={schedule} buildings={data.buildingsByType} type={type} />;
      } else {
        return <ScheduleBlockEmpty key={keySchedule} />;
      }
    });
  };

  const renderTitleName = () => {
    if (type === 'cabinet') {
      return `ауд. ${model.name}`;
    }
    return model.name;
  };

  if (!isEmpty(data)) {
    return (
      <div className={'week'}>
        <div className={'row'}>
          <div className={'col-1'}></div>
          <div className={'col-10'}>
            <div className={'block-title'}>
              <span>{renderTitleName()}</span>
              <span>{week.name}</span>
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
