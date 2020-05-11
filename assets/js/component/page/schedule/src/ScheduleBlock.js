import React from 'react';

export default function ScheduleBlock(props) {
    if (props.isEmpty) {
        return (
            <div className={'col-2'}>
                <div className={'block-schedule empty'}>
                    <span>-</span>
                </div>
            </div>
        )
    }
    return (
        <div className={'col-2'}>
            <div className={'block-schedule'}>
                <div className={'block-lesson'}>
                    <p>{props.lesson}</p>
                </div>
                <div className={'delimiter'}></div>
                <div className={'block-info'}>
                    <span className={'teacher'}>{props.teacher}</span>
                    <span className={'block cabinet'}>{props.cabinet}</span>
                    <span className={'block building'}>{props.building}</span>
                </div>
            </div>
        </div>
    )
}

