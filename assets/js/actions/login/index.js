export const change = (loginStatus) => {
    return {
        type: 'LOGIN',
        payload: loginStatus
    }
};