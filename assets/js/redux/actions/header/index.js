export const changeLoginStatus = (loginStatus) => {
    return {
        type: 'LOGIN',
        payload: loginStatus
    }
};

export const changeActiveElement = (element) => {
    return {
        type: 'CHANGE_ACTIVE',
        payload: element
    }
};