export const changeLoginStatus = (loginStatus) => {
    return {
        type: 'LOGIN',
        payload: loginStatus
    }
};