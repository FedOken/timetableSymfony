import React from 'react';
import './style.scss';

export default function ScheduleBlockEmpty(props) {
  return (
    <div className={`block-schedule-container`}>
      <div className={'block-schedule-main empty'}>
        <span>-</span>
      </div>
    </div>
  );
}
