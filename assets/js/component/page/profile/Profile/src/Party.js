import React, {useEffect, useState} from 'react';
import {connect} from 'react-redux';
import {withRouter} from 'react-router-dom';
import {isEmpty} from '../../../../src/Helper';
import BlockTemplate from './src/BlockTemplate';
import {getAllAlphabet} from './src/BlockOrder';

function index(props) {
  const [party, setParty] = useState({});

  useEffect(() => {
    if (!isEmpty(props.user.relation.data) && isEmpty(party)) {
      setParty(props.user.relation.data.parties);
    }
  });

  const renderRelations = () => {
    if (isEmpty(party)) return '';

    return getAllAlphabet().map((letter, key) => {
      let filterModels = party.filter((model) => {
        return model.name[0] === letter || model.name[0] === letter.toUpperCase();
      });
      if (!isEmpty(filterModels)) {
        return <BlockTemplate key={key} models={filterModels} letter={letter} type={'group'} />;
      }
    });
  };

  return <div className={'block_template_container group'}>{renderRelations()}</div>;
}

function mapStateToProps(state) {
  return {
    user: state.user,
  };
}

export default withRouter(connect(mapStateToProps)(index));
