import React from 'react';
import './style.scss';

export default function index(props) {
  return (
    <div className={'preloader_container'}>
      <div className="loader first"></div>
    </div>
  );
}

export function preloaderStart() {
  document.querySelector('.preloader_container').className += ' active';
}

export function preloaderEnd() {
  let str = document.querySelector('.preloader_container').className;
  let res = str.replace(' active', '');
  document.querySelector('.preloader_container').className = res;
}
