let data = {
    isLogin: false,
    data: {}
};

export default function index(state = data, action) {
    console.log(action.payload);
    switch (action.type) {
        case 'CHANGE_USER_DATA':
            return {
                isLogin: action.payload.status,
                data: action.payload.data,
            };
        default:
            return state;
    }
}