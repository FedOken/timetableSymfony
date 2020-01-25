import React from 'react';

let BaseIcon = function BaseIcon(_ref) {
    let color = _ref.color,
        _ref$pushRight = _ref.pushRight,
        pushRight = _ref$pushRight === undefined ? true : _ref$pushRight,
        children = _ref.children;
    let width = _ref.width ? _ref.width : 20;
    let height = _ref.height ? _ref.height : 20;
    return React.createElement(
        'svg',
        {
            xmlns: 'http://www.w3.org/2000/svg',
            width: width,
            height: height,
            viewBox: '0 0 24 24',
            fill: 'none',
            stroke: color,
            strokeWidth: '2',
            strokeLinecap: 'round',
            strokeLinejoin: 'round',
            style: { marginRight: pushRight ? '5px' : '0', minWidth: 24 }
        },
        children
    );
};

let InfoIcon = function InfoIcon() {
    return React.createElement(
        BaseIcon,
        { color: '#4A707A' },
        React.createElement('circle', { cx: '12', cy: '12', r: '10' }),
        React.createElement('line', { x1: '12', y1: '16', x2: '12', y2: '12' }),
        React.createElement('line', { x1: '12', y1: '8', x2: '12', y2: '8' })
    );
};

let SuccessIcon = function SuccessIcon() {
    return React.createElement(
        BaseIcon,
        { color: 'green' },
        React.createElement('path', { d: 'M22 11.08V12a10 10 0 1 1-5.93-9.14' }),
        React.createElement('polyline', { points: '22 4 12 14.01 9 11.01' })
    );
};

let ErrorIcon = function ErrorIcon() {
    return React.createElement(
        BaseIcon,
        { color: 'red' },
        React.createElement('circle', { cx: '12', cy: '12', r: '10' }),
        React.createElement('line', { x1: '12', y1: '8', x2: '12', y2: '12' }),
        React.createElement('line', { x1: '12', y1: '16', x2: '12', y2: '16' })
    );
};

let CloseIcon = function CloseIcon() {

    return React.createElement(
        'svg',
        {
            version: "1.0",
            xmlns: 'http://www.w3.org/2000/svg',
            width: '10px',
            height: '10px',
            viewBox: '0 0 274.000000 275.000000',
            preserveAspectRatio: "xMidYMid meet",
            fill: 'red'
        },
        React.createElement('g',
            { transform: "translate(0.000000,275.000000) scale(0.100000,-0.100000)", stroke: "none" },
            React.createElement('path', { d: 'M300 2729 c-31 -12 -256 -233 -276 -271 -18 -35 -18 -91 0 -126 8 -15 224 -236 480 -492 l466 -465 -477 -477 -476 -476 -5 -55 -4 -54 70 -79 c97 -111 191 -198 229 -213 78 -32 66 -41 586 477 l477 477 478 -477 c519 -518 507 -509 585 -477 38 15 132 102 228 212 61 68 69 82 69 118 0 22 -5 50 -11 62 -6 12 -222 234 -480 492 l-469 470 466 465 c256 256 472 477 480 492 18 34 18 91 0 126 -8 15 -70 82 -138 149 -129 128 -159 145 -225 128 -19 -4 -186 -164 -506 -483 l-477 -477 -473 472 c-259 259 -482 476 -494 482 -26 13 -69 13 -103 0z'})
        )
    );
};

let _extends = Object.assign || function (target) {
    for (let i = 1; i < arguments.length; i++) {
        let source = arguments[i];

        for (let key in source) {
            if (Object.prototype.hasOwnProperty.call(source, key)) {
                target[key] = source[key];
            }
        }
    }

    return target;
};

let alertStyle = {
    backgroundColor: '#ffffff',
    padding: '10px',
    borderRadius: '10px',
    display: 'flex',
    justifyContent: 'space-between',
    alignItems: 'center',
    boxShadow: '0px 2px 2px 2px rgba(0, 0, 0, 0.03)',
    fontWeight: 'bold',
    width: 'auto',
    maxWidth: '360px',
    boxSizing: 'border-box'
};

let styleError = {
    color: 'red',
    border: '2px solid red',
};

let styleSuccess = {
    color: 'green',
    border: '2px solid green',
};

let styleInfo = {
    color: '#4A707A',
    border: '2px solid #4A707A',
};

let buttonStyle = {
    marginLeft: '30px',
    border: 'none',
    backgroundColor: 'transparent',
    cursor: 'pointer',
};

let CustomAlertTemplate = function AlertTemplate(_ref) {
    let message = _ref.message,
        options = _ref.options,
        style = _ref.style,
        close = _ref.close;

    let alertStyleByType;
    switch (options.type) {
        case 'error':
            alertStyleByType = styleError;
            break;
        case 'success':
            alertStyleByType = styleSuccess;
            break;
        case 'info':
            alertStyleByType = styleInfo;
            break;
        default:
            alertStyleByType = {};
    }

    return React.createElement(
        'div',
        { style: _extends({}, alertStyleByType, alertStyle, style) },
        options.type === 'info' && React.createElement(InfoIcon, null),
        options.type === 'success' && React.createElement(SuccessIcon, null),
        options.type === 'error' && React.createElement(ErrorIcon, null),
        React.createElement(
            'span',
            { style: { flex: 2 } },
            message
        ),
        React.createElement(
            'button',
            { onClick: close, style: buttonStyle },
            React.createElement(CloseIcon, null)
        )
    );
};

export default CustomAlertTemplate;
