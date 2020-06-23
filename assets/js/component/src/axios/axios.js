import {generateUrl, baseAxios} from './axios_helper';

/**
 * API:
 * @param {string} lang
 * @returns {Promise<[]>}
 */
export async function getUserCsrfToken(lang) {
  let url = generateUrl(`/api/user/get-csrf-token`);
  return await baseAxios(lang, url, false, 'GET');
}

/**
 * API:
 * @param {string} lang
 * @param {object} params
 * @param {object} postData
 * @param {boolean} fullResp
 * @returns {Promise<[]>}
 */
export async function postUserLogin(lang, params = {}, postData = {}, fullResp = false) {
  let url = generateUrl(`/api/user/login-start`, params);
  return await baseAxios(lang, url, true, 'POST', postData, fullResp);
}

/**
 * API:
 * @param {string} lang
 * @param {string} type
 * @param {int} modelId
 * @returns {Promise<[]>}
 */
export async function getScheduleWeeks(lang, type, modelId) {
  let url = generateUrl(`/api/schedule/get-weeks/${type}/${modelId}`);
  return await baseAxios(lang, url, true, 'GET', {}, false, false);
}

/**
 * API:
 * @param {string} lang
 * @param {string} type
 * @param {int} week
 * @param {int} modelId
 * @returns {Promise<[]>}
 */
export async function getScheduleData(lang, type, week, modelId) {
  let url = generateUrl(`/api/schedule/get-data/${type}/${week}/${modelId}`);
  return await baseAxios(lang, url, true);
}

/**
 * API:
 * @param {string} lang
 * @param {object} postData
 * @returns {Promise<[]>}
 */
export async function sendContactLetter(lang, postData) {
  let url = generateUrl(`/api/contact/send-contact-letter`);
  return await baseAxios(lang, url, true, 'POST', postData);
}

/**
 * API:
 * @param {string} lang
 * @param {string} code
 * @returns {Promise<[]>}
 */
export async function sendConfirmLetter(lang, code) {
  let url = generateUrl(`/api/user/confirm-email-send/${code}`);
  return await baseAxios(lang, url, true, 'GET');
}

/**
 * API:
 * @param {string} lang
 * @param {object} postData
 * @returns {Promise<[]>}
 */
export async function createPartyUser(lang, postData) {
  let url = generateUrl(`/api/user/create-party-user`);
  return await baseAxios(lang, url, true, 'POST', postData);
}

/**
 * API:
 * @param {string} lang
 * @param {object} postData
 * @returns {Promise<[]>}
 */
export async function createTeacherUser(lang, postData) {
  let url = generateUrl(`/api/user/create-teacher-user`);
  return await baseAxios(lang, url, true, 'POST', postData);
}

/**
 * API:
 * @param {string} lang
 * @param {object} postData
 * @returns {Promise<[]>}
 */
export async function createUniversityUser(lang, postData) {
  let url = generateUrl(`/api/user/create-university-user`);
  return await baseAxios(lang, url, true, 'POST', postData, true);
}

/**
 * API:
 * @param {string} lang
 * @param {object} postData
 * @returns {Promise<[]>}
 */
export async function updateUserModel(lang, postData) {
  let url = generateUrl(`/api/user/update-model`);
  return await baseAxios(lang, url, true, 'POST', postData, true);
}

/**
 * API:
 * @param {string} lang
 * @returns {Promise<[]>}
 */
export async function userLogoutRequest(lang) {
  let url = generateUrl(`/api/user/logout-start`);
  return await baseAxios(lang, url, true, 'POST', {}, true);
}

/**
 * API:
 * @param {string} lang
 * @param {object} postData
 * @returns {Promise<[]>}
 */
export async function userResetPassword(lang, postData) {
  let url = generateUrl(`/api/user/reset-password`);
  return await baseAxios(lang, url, true, 'POST', postData, true);
}
