export function isEmpty(data) {
    if (typeof data === 'object') {
        for(let prop in data) {
            if(Object.prototype.hasOwnProperty.call(data, prop)) {
                return false;
            }
        }
    }
    if (Array.isArray(data)) {
        if (data.length > 0) return false;
    }

    return true
}

