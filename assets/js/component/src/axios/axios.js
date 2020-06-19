import {generateUrl, baseAxios} from './axios_helper';

/**
 * API:
 * @param {object} params
 * @param {object} postData
 * @param {boolean} fullResp
 * @returns {Promise<[]>}
 */
export async function getUserCsrfToken(params = {}, postData = {}, fullResp = false) {
  let url = generateUrl(`/api/user/get-csrf-token`, params);
  return await baseAxios(url, false, 'GET', fullResp);
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

/**
 * API:
 * @param {string} type
 * @param {int} week
 * @param {int} modelId
 * @returns {Promise<[]>}
 */
export async function getScheduleData(type, week, modelId) {
  let url = generateUrl(`/api/schedule/get-data/${type}/${week}/${modelId}`);
  return await baseAxios(url, true);
}

/**
 * API:
 * @param {string} type
 * @param {int} modelId
 * @returns {Promise<[]>}
 */
export async function getScheduleWeeks(type, modelId) {
  let url = generateUrl(`/api/schedule/get-weeks/${type}/${modelId}`);
  return await baseAxios(url, true);
}
