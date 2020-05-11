import React from 'react';

export default function DayBlock(props) {
    return (
        <div className={'col-2'}>
            <div className={'block-day'}>
                <span>{props.name}</span>
            </div>
        </div>
    )
}

