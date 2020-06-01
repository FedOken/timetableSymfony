import {isEmpty} from "./Helper";

/**
 *
 * @param formClass Form class name
 * @param selObjs Where key - form-group id
 * @returns {boolean}
 */
export function validateForm(formClass, selObjs = {}) {
    let formHasError = false;

    //Validate inputs
    let inputs = document.querySelectorAll(`form.${formClass} .form-group input`);
    inputs.forEach(function(input) {
        let valError = validate(input);
        if (!valError.status) {
            formHasError = true;
            input.closest('.form-group').classList.add('has-error');
            input.closest('.form-group').querySelector('span.error').innerHTML = valError.error;
        } else {
            input.closest('.form-group').classList.remove('has-error');
            input.closest('.form-group').querySelector('span.error').innerHTML = '';
        }
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
        default:
            return {status: true};
    }
}

function validateInput(element) {
    let value = element.value;
    let type = element.type;
    let required = element.required;

    let resp = {status: true, error: ''};

    if (type === 'password') {
        resp.error = checkPassword(value);
    }

    if (type === 'email' && !checkEmail(value)) {
        resp.error = 'Set valid email address';
    }

    if (type === 'number') {
        resp.error = checkNumber(value);
    }

    if (required && !checkRequired(value)) {
        resp.error = 'This field required';
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
    console.log(Number.isInteger(value));
    if (!Number.isInteger(value)) return 'Only numbers';
    if (value < 0) return 'Сan\'t be less than 0';
    if (value > 999999999999) return 'Number is too big';
    return '';
}
