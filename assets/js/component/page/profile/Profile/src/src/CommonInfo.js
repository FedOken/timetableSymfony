export function commonInfo(type, name) {
  let cont = document.querySelector('.profile-info');
  let p = document.createElement('p');
  p.innerHTML = name;

  let span = document.createElement('span');
  span.innerHTML = type + ':';
  p.prepend(span);

  cont.appendChild(p);
}
