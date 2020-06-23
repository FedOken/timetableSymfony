import axios from 'axios';
import {isEmpty} from '../helper';
import {alert, alertException} from '../Alert/Alert';
import {preloaderStart, preloaderEnd} from '../Preloader/Preloader';
import {t} from '../translate/translate';

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
 * @param {string} lang
 * @param {string} url
 * @param {boolean} usePreloader
 * @param {string} method
 * @param {object} postData
 * @param {object} fullResp
 * @param {boolean} showAlert
 * @returns {Promise<Array>}
 */
export async function baseAxios(
  lang,
  url,
  usePreloader = false,
  method = 'GET',
  postData = {},
  fullResp = false,
  showAlert = true,
) {
  if (usePreloader) preloaderStart();
  let resp = [];
  await axios({method: method, url: url, data: postData})
    .then((res) => {
      if (fullResp) resp = res.data;
      else {
        if (res.data.status) {
          resp = res.data.data;
        } else {
          if (showAlert) alert('error', t(lang, res.data.error));
        }
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
