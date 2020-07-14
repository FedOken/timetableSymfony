import React from 'react';
import {ru} from './source/ru';
import {uk} from './source/uk';
import {en} from './source/en';
import {isEmpty} from '../Helper';

/**
 * Translate message
 * @param {string} targetLang
 * @param {string} message
 * @param {boolean} globalSearch
 * @returns {*}
 */
export function t(targetLang, message, globalSearch = false) {
  if (globalSearch) {
    /** Search translate in each langs. Get translate key and trans to needed lang*/
    let transKey = null;
    if (isEmpty(transKey)) transKey = Object.keys(ru).find((key) => ru[key] === message);
    if (isEmpty(transKey)) transKey = Object.keys(uk).find((key) => uk[key] === message);
    if (isEmpty(transKey)) transKey = Object.keys(en).find((key) => en[key] === message);
    if (isEmpty(transKey)) return message;
    message = transKey;
  }

  /** Get sourse translation. Find message in keys, return translate */
  let source = getSource(targetLang);
  if (isEmpty(source) || isEmpty(source[message])) return message;

  return source[message];
}

/**
 * Return sourse for selected langs
 * @param targetLang
 */
function getSource(targetLang) {
  switch (targetLang) {
    case 'ru-RU':
      return ru;
    case 'uk-UA':
      return uk;
    case 'en-GB':
      return en;
    default:
      return null;
  }
}
