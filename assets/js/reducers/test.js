let initialDefault = [
    {
        message: 'Hello here I\'m!'
    }
];

export default function test(state = initialDefault, action) {
    switch (action.type) {
        case 'CHANGE':
            return [
                {
                    message: action.payload
                }
            ];
        default:
            return state;
    }
}