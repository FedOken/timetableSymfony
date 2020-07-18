import React, {useEffect, useState} from 'react';
import Week from './src/Week/Week';
import {connect} from 'react-redux';
import {withRouter} from 'react-router';
import {isEmpty} from '../../../src/Helper';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {getScheduleWeeks} from '../../../src/axios/axios';
import './style.scss';
import {preloaderEnd} from '../../../src/Preloader/Preloader';
import {t} from '../../../src/translate/translate';

function index(props) {
  const [data, setData] = useState();

  let params = props.loc.pathname.split('/');
  let type = params[params.length - 2];

  useEffect(() => {
    getScheduleWeeks(props.lang, type, params[params.length - 1]).then((res) => {
      setData(res);
      preloaderEnd();
    });
  }, []);

  /** Render weeks. Main render. */
  const renderWeeks = () => {
    if (isEmpty(data)) return;
    return Object.keys(data.weeks).map((key) => {
      return <Week key={key} week={data.weeks[key]} model={data.model} type={type} />;
    });
  };

  const redirect = (url) => {
    props.push(url);
    props.history.push(url);
  };

  /** Show nothing not found */
  if (isEmpty(data) || isEmpty(data.weeks)) {
    return (
      <div className="schedule row h-100">
        <div className={'not-found'}>
          <p>{t(props.lang, 'Schedules not found')}</p>
          <button type={'button'} className={'btn btn-type-2'} onClick={() => redirect('/search')}>
            {t(props.lang, 'To search')}
          </button>
        </div>
      </div>
    );
  }
  /** Main return */
  return <div className="schedule">{renderWeeks()}</div>;
}

const mapToProps = (state) => {
  return {
    lang: state.lang,
    loc: state.router.location,
  };
};

const matchDispatch = (dispatch) => {
  return bindActionCreators({push: push}, dispatch);
};

export default withRouter(connect(mapToProps, matchDispatch)(index));
