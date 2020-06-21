import React from 'react';
import {ru} from './source/ru';
import {ua} from './source/ua';
import {isEmpty} from '../Helper';

export function t(targetLang, message) {
  let source = getSource(targetLang);
  if (isEmpty(source) || isEmpty(source[message])) return message;

  return source[message];
}

function getSource(targetLang) {
  switch (targetLang) {
    case 'ru-RU':
      return ru;
    case 'ua-UA':
      return ua;
    default:
      return null;
  }
}
