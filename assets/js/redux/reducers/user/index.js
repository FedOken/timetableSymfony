let data = {
    isLogin: false,
    isStatusChecked: false,
    data: {}
};

export default function index(state = data, action) {
    switch (action.type) {
        case 'CHANGE_USER_DATA':
            return {
                isLogin: action.payload.status,
                isStatusChecked: true,
                data: action.payload.data,
            };
        default:
            return state;
    }
}