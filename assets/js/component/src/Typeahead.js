import React from 'react';
import {AsyncTypeahead} from 'react-bootstrap-typeahead';
import {t} from './translate/translate';
import {connect} from 'react-redux';

export function Typeahead(props) {
  return (
    <AsyncTypeahead
      id="home-autocomplete"
      className={'input typeahead'}
      isLoading={props.isLoading}
      onSearch={(query) => {
        props.onSearch(query);
      }}
      onChange={(query) => {
        props.onChange(query);
      }}
      onInputChange={(query) => {
        props.onInputChange(query);
      }}
      options={props.options}
      useCache={false}
      promptText={t(props.lang, 'Start typing to search') + '...'}
      searchText={t(props.lang, 'The search is underway') + '...'}
      emptyLabel={t(props.lang, 'Nothing not found')}
      paginationText={t(props.lang, 'Show more')}
      maxResults={6}
      minLength={1}
    />
  );
}

const mapToProps = (state) => {
  return {
    lang: state.lang,
  };
};

export default connect(mapToProps)(Typeahead);
