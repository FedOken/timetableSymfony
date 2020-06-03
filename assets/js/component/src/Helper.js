export function isEmpty(data) {
    if (typeof data === 'object') {
        if (Object.entries(data).length === 0) return true;
        for(let prop in data) {
            if(Object.prototype.hasOwnProperty.call(data, prop)) {
                return false;
            }
        }
    }
    if (Array.isArray(data)) {
        if (data.length > 0) return false;
    }
    if (typeof data === 'undefined') return true;

    return false
}

