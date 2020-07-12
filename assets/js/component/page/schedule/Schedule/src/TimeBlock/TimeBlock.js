import React, {useEffect, useState} from 'react';
import {preloaderEnd, preloaderStart} from '../../../../../src/Preloader/Preloader';
import './style.scss';

export default function TimeBlock(props) {
  const [time] = useState(props.time);
  const [opOriginal] = useState(props.opacities.original);
  const [opReverse] = useState(props.opacities.reverse);

  const opacity = props.class === 'left' ? opOriginal[time.id] : opReverse[time.id];

  useEffect(() => {
    preloaderStart();
    let divs = document.querySelectorAll('.week');

    divs.forEach(function (div) {
      let div_times = div.querySelectorAll('.block-time');
      div_times.forEach(function (div) {
        //let div_times = div.querySelectorAll('.block-time.left');
        //console.log(ss);
        let opacityLoc = div.getAttribute('opacity');
        div.style.background = `rgba(74, 112, 122, ${opacityLoc / 100})`;
      });
    });
    preloaderEnd();
  }, []);

  return (
    <div className={`block-time ${props.class}`} opacity={opacity}>
      <div className={'time'}>{time.timeFrom}</div>
      <div className={'delimiter'}></div>
      <div className={'time'}>{time.timeTo}</div>
    </div>
  );
}
