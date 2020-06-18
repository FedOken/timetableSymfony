import {generateUrl, baseAxios} from './axios_helper';

/**
 * API:
 * @param {object} params
 * @param {object} postData
 * @returns {Promise<[]>}
 */
export async function getUserCsrfToken(params = {}, postData = {}) {
  let url = generateUrl(`/api/user/get-csrf-token`, params);
  return await baseAxios(url);
}

/**
 * API:
 * @param {object} params
 * @param {object} postData
 * @param {boolean} fullResp
 * @returns {Promise<[]>}
 */
export async function postUserLogin(params = {}, postData = {}, fullResp = false) {
  let url = generateUrl(`/api/user/login-start`, params);
  return await baseAxios(url, true, 'POST', postData, fullResp);
}
