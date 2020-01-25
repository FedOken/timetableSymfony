let initialDefault = {
    isGuest: true
};

export default function index(state = initialDefault, action) {
    switch (action.type) {
        case 'LOGIN':
            return{
                isGuest: action.payload
            };
        default:
            return state;
    }
}