import React, {useEffect, useState} from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {isEmpty} from '../../../../src/Helper';
import BlockTemplate from './src/BlockTemplate';
import {getAllAlphabet} from './src/BlockOrder';
import {t} from '../../../../src/translate/translate';

function index(props) {
  const [teachers, setTeachers] = useState({});

  useEffect(() => {
    if (!isEmpty(props.user.relation.data) && isEmpty(teachers)) {
      setTeachers(props.user.relation.data.teachers);
    }
  });

  const renderRelations = () => {
    if (isEmpty(teachers)) return <span className={'not-found'}>{t(props.lang, 'Nothing not found')}</span>;

    return getAllAlphabet().map((letter, key) => {
      let filterModels = teachers.filter((model) => {
        return model.name[0] === letter || model.name[0] === letter.toUpperCase();
      });
      if (!isEmpty(filterModels)) {
        return <BlockTemplate key={key} models={filterModels} letter={letter} type={'teacher'} />;
      }
    });
  };

  return <div className={'block_template_container teacher'}>{renderRelations()}</div>;
}

function mapStateToProps(state) {
  return {
    user: state.user,
    lang: state.lang,
  };
}

export default withRouter(connect(mapStateToProps)(index));
