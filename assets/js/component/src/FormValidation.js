import {isEmpty} from './Helper';

/**
 *
 * @param formClass Form class name
 * @param selObjs Where key - form-group id
 * @returns {boolean}
 */
export function validateForm(formClass, selObjs = {}) {
  let formHasError = false;

  //Validate inputs
  let formControls = ['input', 'textarea'];
  formControls.forEach((controlName) => {
    let controls = document.querySelectorAll(`form.${formClass} .form-group ${controlName}`);
    controls.forEach(function (control) {
      let valError = validate(control);
      if (!valError.status) {
        formHasError = true;
        control.closest('.form-group').classList.add('has-error');
        control.closest('.form-group').querySelector('span.error').innerHTML = valError.error;
      } else {
        control.closest('.form-group').classList.remove('has-error');
        control.closest('.form-group').querySelector('span.error').innerHTML = '';
      }
    });
  });

  //Validate selects
  for (let selId in selObjs) {
    if (!selObjs.hasOwnProperty(selId)) continue;

    let formGr = document.querySelector(`form.${formClass} .form-group#${selId}`);

    if (!selObjs[selId]) {
      formHasError = true;
      formGr.classList.add('has-error');
      formGr.querySelector('span.error').innerHTML = 'This field required';
    } else {
      formGr.classList.remove('has-error');
      formGr.querySelector('span.error').innerHTML = '';
    }
  }

  return !formHasError;
}

export function validate(element) {
  let elementName = element.tagName.toLowerCase();

  switch (elementName) {
    case 'input':
      return validateInput(element);
    case 'textarea':
      return validateTextarea(element);
    default:
      return {status: true};
  }
}

function validateInput(element) {
  let value = element.value;
  let type = element.type;
  let required = element.required;

  let resp = {status: true, error: ''};

  if (type === 'password' && isEmpty(resp.error)) {
    resp.error = checkPassword(value);
  }

  if (type === 'email' && !checkEmail(value) && isEmpty(resp.error)) {
    resp.error = 'Set valid email address';
  }

  if (type === 'number' && isEmpty(resp.error)) {
    resp.error = checkNumber(value);
  }

  if (required && !checkRequired(value) && isEmpty(resp.error)) {
    resp.error = 'This field required';
  }

  if (isEmpty(resp.error)) {
    resp.error = checkMaxLengthInput(value);
  }

  if (resp.error.length > 0) resp.status = false;
  return resp;
}

function validateTextarea(element) {
  let value = element.value;
  let required = element.required;

  let resp = {status: true, error: ''};

  if (required && !checkRequired(value)) {
    resp.error = 'This field required';
  }

  if (isEmpty(resp.error)) {
    resp.error = checkMaxLengthTextarea(value);
  }

  if (resp.error.length > 0) resp.status = false;
  return resp;
}

function checkRequired(value) {
  return !!value.length;
}

function checkEmail(value) {
  let reg = RegExp(/^([a-zA-Z0-9_\-.]+)@([a-zA-Z0-9_\-.]+)\.([a-zA-z]{2,5})$/);
  return reg.test(value);
}

function checkPassword(value) {
  if (value.length < 5) return 'Min password length - 6 characters';
  if (value.length > 20) return 'Max password length - 20 characters';
  return '';
}

function checkNumber(value) {
  value = Number(value);
  if (!Number.isInteger(value)) return 'Only numbers';
  if (value < 0) return "Сan't be less than 0";
  if (value > 2000000000) return 'Number is too big';
  return '';
}

function checkMaxLengthInput(value) {
  if (value.length > 255) return 'Field is too long';
  return '';
}

function checkMaxLengthTextarea(value) {
  if (value.length > 429496729) return 'Field is too long';
  return '';
}
