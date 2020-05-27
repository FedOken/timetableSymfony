import React, {useEffect, useState} from 'react';
import {preloaderEnd, preloaderStart} from "../../../src/Preloader";

export default function DayBlock(props) {
    const [day] = useState(props.day);
    const [opacities] = useState(props.opacities);

    const opacity = opacities[day.id];

    useEffect(() => {
        preloaderStart();
        let divs = document.querySelectorAll('.week');

        divs.forEach(function(div) {
            let div_day = div.querySelectorAll('.block-day');
            div_day.forEach(function(div) {
                let opacityLoc = div.getAttribute('opacity');
                div.style.background = `rgba(74, 112, 122, ${opacityLoc / 100})`;
            });
        });
        preloaderEnd();

    }, []);

    return (
        <div className={'col-2'}>
            <div className={'block-day'} opacity={opacity}>
                <span>{day.name_full}</span>
            </div>
        </div>
    )
}

