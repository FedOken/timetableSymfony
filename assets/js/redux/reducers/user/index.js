let data = {
    status: false,
    id: null,
    email: null,
    role: null,
};

export default function index(state = data, action) {
    switch (action.type) {
        case 'CHANGE_USER_DATA':
            if (!action.payload.status) {
                return data;
            }
            return {
                isLogin: action.payload.status,
                id: action.payload.id,
                email: action.payload.email,
                role: action.payload.role,
            };
        default:
            return state;
    }
}