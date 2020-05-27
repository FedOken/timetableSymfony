import React, {useEffect, useState} from 'react';

export default function ScheduleBlockEmpty(props) {
    return (
        <div className={'col-2 block-schedule-container'}>
            <div className={'block-schedule-main empty'}>
                <span>-</span>
            </div>
        </div>
    );
}

