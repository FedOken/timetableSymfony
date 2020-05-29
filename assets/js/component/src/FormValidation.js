export function validate(element) {
    let elementName = element.tagName.toLowerCase();

    switch (elementName) {
        case 'input':
            return validateInput(element);
        default:
            return {status: true};
    }
}

export function validateForm() {

}

function validateInput(element) {
    let name = element.name;
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
    if (value.length < 5) return 'Min password length 6 characters';
    if (value.length > 20) return 'Max password length 20 characters';
    return '';
}
