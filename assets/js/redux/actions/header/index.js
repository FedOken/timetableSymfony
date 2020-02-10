export const changeLoginStatus = () => {
    return {
        type: 'LOGIN',
    }
};

export const changeActiveElement = (element) => {
    return {
        type: 'CHANGE_ACTIVE',
        payload: element
    }
};