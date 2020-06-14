/**
 * Transform all data to true or false
 * @param data
 * @returns {boolean}
 */
export function isEmpty(data) {
  if (typeof data === 'undefined' || data === null) return true;

  if (Array.isArray(data)) {
    if (data.length > 0) return false;
  }

  if (typeof data === 'object' && data !== null) {
    if (Object.entries(data).length === 0) return true;
    for (let prop in data) {
      if (Object.prototype.hasOwnProperty.call(data, prop)) {
        return false;
      }
    }
  }

  return false;
}

/**
 * Transform university data to select options
 * @param data
 * @returns {[]}
 */
export function unDataToOptions(data) {
  let unSel = [];
  data.forEach((un) => {
    unSel.push({label: un.name, value: un.id});
  });
  return unSel;
}

/**
 * Transform party data to select options
 * @param data
 * @returns {[]}
 */
export function partiesDataToOptions(data) {
  let partiesSel = [];
  data.forEach((party) => {
    partiesSel.push({label: party.name, value: party.id});
  });
  return partiesSel;
}
