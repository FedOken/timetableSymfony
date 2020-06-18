export function truncate(str, length = 5, strEnd = '...') {
  if (typeof str !== 'string') return '';
  str = str.trim();

  if (str.length <= length) return str;

  let strEndIndex = str.length - length;

  let newStr = str.substring(0, length);
  newStr = newStr.trim();
  return newStr + strEnd.substring(0, strEndIndex);
}
