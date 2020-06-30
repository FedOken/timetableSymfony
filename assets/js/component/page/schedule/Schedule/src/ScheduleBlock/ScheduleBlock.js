import React, {useEffect, useState} from 'react';
import {truncate} from '../../../../../src/Truncate';
import {bindActionCreators} from 'redux';
import {push} from 'connected-react-router';
import {withRouter} from 'react-router';
import {connect} from 'react-redux';
import {preloaderStart} from '../../../../../src/Preloader/Preloader';
import {t} from '../../../../../src/translate/translate';
import './style.scss';
import {isEmpty} from '../../../../../src/Helper';

const showAdditionalInfo = (e, infoName) => {
  let className = '.' + infoName + '_info';
  let infoBlock = e.target.closest('.block-schedule-container').querySelector(className);
  infoBlock.classList.toggle('active');
};

function ScheduleBlock(props) {
  const [type] = useState(props.type);
  const [lesson] = useState(props.data.lesson_name);
  const [teacher] = useState(props.data.teacher);
  const [party] = useState(props.data.party);
  const [cabinet] = useState(props.data.cabinet);
  const [building] = useState(props.data.cabinet.building);
  const [buildings] = useState(props.buildings);
  const [lessonType] = useState(props.data.lesson_type);

  const [teacherFullName, setTeacherFullName] = useState();

  useEffect(() => {
    setTeacherFullNameFunc();
  }, []);

  /** Set teacher full name. With full name and position*/
  const setTeacherFullNameFunc = () => {
    let teacherPos = t(props.lang, teacher.position, true);
    if (!teacher.name_full) {
      setTeacherFullName(`${teacherPos ? teacherPos.name : ''} ${teacher.name}`);
    } else {
      setTeacherFullName(`${teacherPos ? teacherPos.name : ''} ${teacher.name_full}`);
    }
  };

  /** Render block with teacher or party name */
  const renderTeacherGroupBlock = () => {
    switch (type) {
      case 'teacher':
        return truncate(party.name, 9);
      default:
        return truncate(teacher.name, 11);
    }
  };

  /** Render block with teacher or party full name */
  const renderTeacherGroupBlockFull = () => {
    switch (type) {
      case 'teacher':
        return party.name;
      default:
        return teacherFullName;
    }
  };

  /** Render block with cabinet or party name */
  const renderCabinetGroupBlock = () => {
    if (type === 'cabinet') {
      return truncate(party.name, 4);
    }
    return truncate(cabinet.name, 4);
  };

  /** Render block with cabinet or party full name */
  const renderCabinetGroupBlockFull = () => {
    if (type === 'cabinet') {
      return party.name;
    }
    if (isEmpty(building.name_full)) {
      return (
        <span>
          ауд. {cabinet.name} ({building.name})<br />
          {building.address}
        </span>
      );
    } else {
      return (
        <span>
          ауд. {cabinet.name}<br />
          {building.name_full} ({building.name})<br />
          {building.address}
        </span>
      );
    }
  };

  const redirect = (url) => {
    preloaderStart();
    setTimeout(() => {
      props.push(url);
      props.history.push(url);
    }, 300);
  };

  return (
    <div className={`col-2 block-schedule-container`}>
      <div className={`block-schedule-main`}>
        <div className={'block-lesson'}>
          <p>{truncate(lesson, 36)}</p>
        </div>
        <div className={'delimiter'}></div>
        <div className={'block-additional'}>
          <span
            className={'teacher group'}
            onMouseEnter={(e) => {
              showAdditionalInfo(e, 'teacher');
            }}
            onMouseLeave={(e) => {
              showAdditionalInfo(e, 'teacher');
            }}
            onClick={() => {
              redirect(type === 'teacher' ? `/schedule/group/${party.id}` : `/schedule/teacher/${teacher.id}`);
            }}>
            {renderTeacherGroupBlock()}
          </span>
          <span
            className={`block cabinet type-${buildings[building.id]}`}
            onMouseEnter={(e) => {
              showAdditionalInfo(e, 'cabinet');
            }}
            onMouseLeave={(e) => {
              showAdditionalInfo(e, 'cabinet');
            }}
            onClick={() => {
              redirect(type === 'cabinet' ? `/schedule/group/${party.id}` : `/schedule/cabinet/${cabinet.id}`);
            }}>
            {renderCabinetGroupBlock()}
          </span>
          <span
            className={`block lesson_type type-${lessonType.id}`}
            onMouseEnter={(e) => {
              showAdditionalInfo(e, 'lesson_type');
            }}
            onMouseLeave={(e) => {
              showAdditionalInfo(e, 'lesson_type');
            }}>
            {lessonType.name}
          </span>
        </div>
      </div>
      <div className={'info teacher_info group_info'}>
        <p>{renderTeacherGroupBlockFull()}</p>
      </div>
      <div className={'info cabinet_info group_info'}>
        <p>{renderCabinetGroupBlockFull()}</p>
        {/*<p>s</p>*/}
      </div>
      <div className={'info lesson_type_info'}>
        <p>{t(props.lang, lessonType.name_full, true)}</p>
      </div>
    </div>
  );
}

const mapToProps = (state) => {
  return {
    lang: state.lang,
  };
};

const matchDispatch = (dispatch) => {
  return bindActionCreators({push: push}, dispatch);
};

export default withRouter(connect(mapToProps, matchDispatch)(ScheduleBlock));
