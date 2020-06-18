import axios from 'axios';
import {isEmpty} from '../helper';
import {alert, alertException} from '../Alert/Alert';
import {preloaderStart, preloaderEnd} from '../Preloader/Preloader';

/**
 * @param {string} baseUrl
 * @param {object} params
 * @returns {string}
 */
export function generateUrl(baseUrl, params = {}) {
  let url = '';
  if (!isEmpty(params)) {
    let paramsStr = '';
    for (let prop in params) {
      paramsStr += `${prop}=${params[prop]}&`;
    }
    url = `${baseUrl}?${paramsStr}`;
  } else {
    url = baseUrl;
  }
  url = encodeURI(url);
  return url;
}

/**
 * @param {string} url
 * @param {boolean} usePreloader
 * @param {string} method
 * @param {object} postData
 * @param {object} fullResp
 * @returns {Promise<Array>}
 */
export async function baseAxios(url, usePreloader = false, method = 'GET', postData, fullResp) {
  if (usePreloader) preloaderStart();
  let resp = [];
  await axios({method: method, url: url, data: postData})
    .then((res) => {
      if (fullResp) resp = res.data;
      else {
        if (res.data.status) resp = res.data;
        else alert('error', res.data.error);
      }
    })
    .catch((error) => {
      alertException(error.response.status);
    })
    .then(() => {
      if (usePreloader) preloaderEnd();
    });
  return resp;
}
