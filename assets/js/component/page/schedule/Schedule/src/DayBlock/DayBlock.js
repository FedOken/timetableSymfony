import React, {useEffect, useState} from 'react';
import {preloaderEnd, preloaderStart} from '../../../../../src/Preloader/Preloader';
import './style.scss';
import {t} from '../../../../../src/translate/translate';
import {withRouter} from 'react-router';
import {connect} from 'react-redux';

function DayBlock(props) {
  const [day] = useState(props.day);
  const [opacities] = useState(props.opacities);

  const opacity = opacities[day.id];

  useEffect(() => {
    preloaderStart();
    let divs = document.querySelectorAll('.week');

    divs.forEach(function (div) {
      let div_day = div.querySelectorAll('.block-day');
      div_day.forEach(function (div) {
        let opacityLoc = div.getAttribute('opacity');
        div.style.background = `rgba(74, 112, 122, ${opacityLoc / 100})`;
      });
    });
    preloaderEnd();
  }, []);

  return (
    <div className={'block-day'} opacity={opacity}>
      <span>{t(props.lang, day.name_full, true)}</span>
    </div>
  );
}

const mapToProps = (state) => {
  return {
    lang: state.lang,
  };
};

export default withRouter(connect(mapToProps)(DayBlock));
