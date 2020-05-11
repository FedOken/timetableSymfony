import React from 'react';

export default function TimeBlock(props) {
    return (
        <div className={'col-1'}>
            <div className={'block-time'}>
                <div className={'time'}>{props.start}</div>
                <div className={'delimiter'}></div>
                <div className={'time'}>{props.end}</div>
            </div>
        </div>
    )
}

