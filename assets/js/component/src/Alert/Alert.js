import React from 'react';
import './style.scss';
import {isEmpty} from '../Helper';

const left = 20;
const showDuration = 8000;

export default function index(props) {
  return <div className={'alert_container'}></div>;
}

export function alert(type, message) {
  //Icons
  let successIcon =
    '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 318 318.75"><g><path d="M148.5,0c7.25,0,14.5,0,21.75,0c2.97,0.5,5.93,1.14,8.92,1.47c22.57,2.5,43.41,10.12,62.67,21.91 c22.25,13.61,40.07,31.72,53.67,54.05c10.34,16.97,16.98,35.23,20.24,54.77c0.7,4.19,1.49,8.36,2.24,12.54c0,9.5,0,19,0,28.5 c-0.74,4.31-1.53,8.61-2.23,12.92c-4.95,30.63-18.29,57.26-38.97,80.17c-13.53,14.99-29.44,27.1-47.7,35.87 c-19.66,9.45-40.29,15.23-62.23,15.81c-0.88,0.02-1.75,0.47-2.63,0.72c-3.75,0-7.5,0-11.25,0c-4.22-0.5-8.44-1.04-12.67-1.49 c-18.32-1.95-35.72-7.17-52.15-15.37c-21.1-10.53-39.01-25.11-53.73-43.61c-16.04-20.15-26.79-42.72-31.46-68.11 C2,184.78,1,179.39,0,174c0-9.75,0-19.5,0-29.25c0.49-2.34,1.15-4.65,1.46-7.01C4,117.86,10.03,99.15,19.99,81.73 C38.31,49.68,64.34,26.3,98.44,12.08c13.19-5.5,26.83-9.45,41.17-10.63C142.59,1.21,145.54,0.5,148.5,0z M159.21,31.27 c-70.97-0.3-129.43,57-128.31,130.36c1.05,68.73,57.44,128.46,133.91,125.53c65.6-2.51,123.84-56.45,122.21-131.08 C285.51,86.74,229.82,31.47,159.21,31.27z"/><path d="M132.81,189.32c0.96-0.88,1.8-1.58,2.58-2.35c28.74-28.49,57.47-56.98,86.19-85.48c2.85-2.83,6.58-5.99,10.06-3.07 c6.89,5.77,13.25,12.29,19.08,19.14c2.02,2.38,0.2,6.09-2.35,8.61c-29.74,29.43-59.44,58.89-89.15,88.36 c-6.56,6.51-13.1,13.05-19.68,19.55c-5.12,5.06-9.6,4.77-14.18-0.83c-0.79-0.96-1.63-1.88-2.51-2.76 c-17.73-17.78-35.47-35.56-53.2-53.34c-3.82-3.83-3.95-8.24-0.2-12.08c4.45-4.56,8.94-9.08,13.52-13.51 c4.01-3.87,8.16-3.79,12.06,0.1c11.58,11.57,23.13,23.16,34.7,34.74C130.69,187.36,131.69,188.26,132.81,189.32z"/></g></svg>';
  let infoIcon =
    '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 318 318.75"><g><path d="M0,174c0-9.75,0-19.5,0-29.25c0.26-0.49,0.66-0.96,0.75-1.48c1.06-6.46,1.74-13.01,3.14-19.39 c6.28-28.49,19.74-53.19,39.92-74.23c11.21-11.69,23.66-21.82,37.96-29.56c17.78-9.63,36.51-16.34,56.72-18.56 c3.1-0.34,6.17-1.01,9.26-1.53c7.5,0,15,0,22.5,0c0.62,0.26,1.23,0.72,1.86,0.76c13.05,0.76,25.72,3.49,38.04,7.72 c21.47,7.38,40.6,18.75,57.16,34.34c10.53,9.92,19.67,20.93,27.35,33.25c10.83,17.35,17.7,36.08,21.06,56.19 c0.66,3.93,1.51,7.83,2.27,11.74c0,10,0,20,0,30c-0.26,0.49-0.65,0.96-0.76,1.48c-2.27,10.88-3.66,22.02-6.9,32.6 c-9.43,30.76-27.43,55.89-52.58,75.86c-26.5,21.04-56.65,32.54-90.53,34.07c-0.76,0.03-1.49,0.49-2.24,0.75c-4.25,0-8.5,0-12.75,0 c-0.74-0.26-1.47-0.67-2.24-0.76c-6.64-0.8-13.35-1.2-19.93-2.36c-30.98-5.46-57.73-19.41-80.57-40.93 c-15.73-14.82-27.87-32.22-36.62-51.97c-5.08-11.48-8.37-23.5-10.56-35.85C1.56,182.59,0.78,178.3,0,174z M159.33,31.04 C87.18,31.39,29.96,88.85,30.89,161.28c0.91,70.52,59.07,128.6,133.22,125.97c65.99-2.34,124.34-56.47,122.95-130.58 C285.74,86.31,229.46,31.76,159.33,31.04z"/><path d="M138.17,169.5c-2.55,0-4.9,0.04-7.25-0.01c-4.72-0.09-7.75-2.91-7.88-7.62c-0.14-5.12-0.12-10.24-0.01-15.36 c0.1-4.57,3.26-7.72,7.8-7.74c13.61-0.06,27.23-0.06,40.84,0c4.99,0.02,7.93,3.31,7.94,8.81c0.03,19.23,0,38.47,0,57.7 c0,1.49,0,2.98,0,4.85c2.99,0.21,5.81,0.29,8.6,0.64c4.23,0.52,6.7,3.25,6.78,7.5c0.09,5.12,0.1,10.24,0,15.36 c-0.09,4.47-3.29,7.78-7.84,7.8c-18.73,0.09-37.47,0.09-56.2,0c-4.64-0.02-7.85-3.51-7.92-8.18c-0.07-4.74-0.04-9.49-0.01-14.24 c0.04-5.16,2.29-7.74,7.51-8.38c2.45-0.3,4.95-0.29,7.64-0.43C138.17,196.65,138.17,183.23,138.17,169.5z"/><path d="M159.15,124.72c-14.57,0.12-27.02-12.13-27.14-26.71c-0.13-14.84,12.19-27.43,26.86-27.45 c14.57-0.02,27.01,12.28,27.13,26.82C186.12,112.25,174.01,124.59,159.15,124.72z"/></g></svg>';
  let errorIcon =
    '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 318 318.75"><g><path d="M148.15,0c6.98,0,13.97,0,20.95,0c0.63,0.25,1.23,0.63,1.88,0.72c7.3,1.04,14.71,1.58,21.91,3.11 c27.35,5.8,51.3,18.49,71.99,37.14c16.22,14.62,28.96,31.91,38.23,51.82c8,17.18,12.36,35.28,13.91,53.96 c1.09,13.08,0.42,26.25-1.95,39.28c-3.84,21.03-11.14,40.62-22.81,58.61c-8.28,12.76-18.15,24.01-29.54,34.1 c-11,9.74-23.12,17.78-36.34,23.87c-23.93,11.03-49.12,16.74-75.63,14.55c-10.03-0.83-20.16-1.84-29.94-4.11 c-27.2-6.31-50.78-19.67-71.17-38.69c-10.83-10.11-19.91-21.64-27.55-34.32C11.94,223.22,5.31,205.1,2.23,185.69 c-0.68-4.29-1.48-8.57-2.23-12.85c0-9.23,0-18.46,0-27.68c0.25-0.63,0.64-1.23,0.72-1.88c0.59-4.64,0.76-9.38,1.74-13.93 c3.37-15.63,8.23-30.7,15.85-44.92c10.14-18.93,23.62-35,40.01-48.65c12.85-10.69,27.22-18.98,42.86-24.94 c12.3-4.68,24.86-8.43,38.1-9.4C142.26,1.23,145.2,0.5,148.15,0z M158.24,286.58c71.34,0.15,127.95-56.78,128.12-126.77 c0.17-72.24-55.65-128.38-127.33-128.67C87,30.85,31.2,87.47,30.89,158.58C30.58,229.74,87.49,286.24,158.24,286.58z"/><path d="M158.68,77.07c5.74,0,11.47-0.01,17.21,0c4.74,0.01,8.34,3.34,8.12,8.1c-0.57,12.37-1.44,24.72-2.15,37.08 c-0.3,5.2-0.54,10.4-0.78,15.6c-0.52,11.4-0.99,22.8-1.52,34.2c-0.19,4.14-3.53,7.44-7.75,7.48c-8.6,0.1-17.21,0.12-25.81,0 c-5.12-0.07-8.12-3.41-8.34-8.44c-0.69-15.85-1.46-31.71-2.24-47.56c-0.46-9.41-0.97-18.81-1.49-28.21 c-0.18-3.21-0.64-6.41-0.7-9.62c-0.09-5.55,3.09-8.63,8.62-8.64C147.46,77.06,153.07,77.07,158.68,77.07z"/><path d="M158.58,247.14c-16.18,0.03-28.69-13.92-26.79-29.64c1.79-14.79,12.71-24.32,26.74-24.18 c16.63,0.17,28.59,13.42,26.91,29.97C184.08,236.81,172.88,247.28,158.58,247.14z"/></g></svg>';
  let closeIcon =
    '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 205.5 206.25"><g><path d="M24.75,0c1.25,0,2.5,0,3.75,0c2.76,2.15,5.77,4.04,8.23,6.49C57.81,27.42,78.8,48.45,99.76,69.51 c0.94,0.94,1.34,2.41,2.3,4.23c2.12-2.47,2.95-3.56,3.91-4.53c21-21.02,41.98-42.06,63.06-63c2.37-2.36,5.3-4.16,7.96-6.22 c1.25,0,2.5,0,3.75,0c3.19,2.33,6.75,4.28,9.49,7.06c5.33,5.41,10.2,11.27,15.26,16.94c0,1.75,0,3.5,0,5.25 c-2.15,2.76-4.03,5.77-6.48,8.23c-20.84,20.99-41.79,41.87-62.7,62.79c-0.93,0.93-1.83,1.91-2.8,2.92 c21.94,21.94,43.77,43.71,65.49,65.58c2.44,2.46,4.33,5.47,6.48,8.23c0,1.5,0,3,0,4.5c-6.93,10.18-14.3,19.89-26.25,24.75 c-0.25,0-0.5,0-0.75,0c-5.07-1.09-8.21-4.86-11.63-8.28c-20.39-20.41-40.81-40.79-61.16-61.25c-0.93-0.94-1.3-2.44-1.93-3.69 c-2.56,1.9-3.32,3.06-4.29,4.03c-21.88,21.92-43.79,43.82-65.69,65.72c-2.86,2.86-9.38,4.07-12.28,1.77 C13.21,197.96,5.55,190.69,0,181.5c0-1.5,0-3,0-4.5c2.15-2.76,4.04-5.77,6.48-8.23c20.84-20.98,41.79-41.87,62.7-62.79 c0.93-0.93,1.83-1.91,2.8-2.93C50.04,81.12,28.21,59.35,6.48,37.49C4.04,35.02,2.15,32.01,0,29.25c0-1.75,0-3.5,0-5.25 c0.71-1.07,1.29-2.26,2.16-3.19c4.39-4.73,8.68-9.58,13.36-14.02C18.26,4.17,21.65,2.24,24.75,0z"/></g></svg>';

  //Find container, create div
  let container = document.querySelector('.alert_container');
  let div = document.createElement('div');
  div.classList.add('alert_block', type);
  //Set div top position
  div.style.top = document.querySelectorAll('.alert_block').length * 50 + 'px';

  let svg = '';
  switch (type) {
    case 'success':
      svg = successIcon;
      break;
    case 'error':
      svg = errorIcon;
      break;
    case 'info':
      svg = infoIcon;
      break;
    default:
      svg = '';
  }
  let span = '<span>' + message + '</span>';

  //Create content, insert, style
  div.innerHTML = svg + span + closeIcon;
  container.append(div);
  addAlertStyle(div);

  //Add close listener
  document.querySelectorAll('.alert_block:last-child svg:last-child').forEach((svg) => {
    svg.addEventListener('click', function () {
      let div = svg.closest('.alert_block');
      removeAlertStyle(div);
    });
  });

  //Close alert
  setTimeout(() => {
    removeAlertStyle(div);
  }, showDuration);
}

export function alertException(error) {
  let message = 'Упс, что-то пошло не так... Мы уже работаем над проблеммой)';
  if (!isEmpty(error.response) && error.response.status) {
    switch (error.response.status) {
      case 404:
        message = 'Упс, запрашиваесой страницы не существует... Мы уже работаем над созданием)';
        break;
      case 500:
        message = 'Упс, на сервере какая-то ошибка... Мы уже работаем над проблеммой)';
        break;
    }
  } else if (!isEmpty(error.message)) {
    message = error.message;
  }

  alert('error', message);
}

function addAlertStyle(div) {
  div.style.left = -div.offsetWidth - left + 'px';
  setTimeout(() => {
    div.style.left = left + 'px';
  }, 100);
}

function removeAlertStyle(div) {
  div.style.left = -div.offsetWidth - left + 'px';
  setTimeout(() => {
    div.remove();
  }, 500);
}
