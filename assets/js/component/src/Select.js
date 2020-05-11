import React, {useState} from 'react';
import Select from "react-select";

export default function index(props) {
    const customStyles = {
        option: (provided, state) => ({
            ...provided,
            backgroundColor: state.isSelected ? 'rgba(74, 112, 122, 0.6);' : '#ffffff',
            fontWeight: state.isSelected ? 'bold' : 'regular',
        }),
    };

    return (
        <Select
            name={props.name}
            options={props.options}
            placeholder={props.placeholder}
            className={props.className}
            styles={customStyles}
            onChange={props.onChange}
            value={props.value}
            isDisabled={props.isDisabled}
        />
    );
}


