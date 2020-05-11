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

export const changeHeaderType = (newType) => {
    return {
        type: 'CHANGE_HEADER_TYPE',
        payload: newType
    }
};