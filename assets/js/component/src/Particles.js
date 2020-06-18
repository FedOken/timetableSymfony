import React from 'react';
import Particles from 'react-particles-js';

const particlesOption = {
  particles: {
    number: {
      value: 150,
      density: {
        enable: true,
        value_area: 1000,
      },
    },
    color: {
      value: '#4a707a',
    },
    move: {
      speed: 2,
    },
    line_linked: {
      enable: true,
      distance: 100,
      color: '#4a707a',
      opacity: 0.4,
      width: 1,
    },
  },
};

export default function index(props) {
  return <Particles className={'div-particles'} params={particlesOption} />;
}
