import React, {Component} from 'react';
import axios from 'axios';
import {Typeahead} from 'react-bootstrap-typeahead';
import Select from 'react-select';

export default class Home extends Component {

    logChange(val) {
        return console.log("Selected: " + val.label);
    }

    render() {
        var options = [
            { value: '', label: 'Select an option' },
            { value: 'one', label: 'One' },
            { value: 'two', label: 'Two' }
        ];

        return (
            <div className="container block-center-container">
                <div className="col-sm-3 block-center">
                    <form action="">
                        <p>Enter group</p>
                        <Typeahead
                            id="my-typeahead-id"
                            onChange={(selected) => {
                                // Handle selections...
                            }}
                            options={[
                                {id: 1, label: 'John'},
                                {id: 2, label: 'Miles'},
                                {id: 3, label: 'Charles'},
                                {id: 4, label: 'Herbie'},]}
                        />
                        <p>or</p>
                        <Select
                            name="form-field-name"
                            //value="one"
                            options={options}
                            onChange={this.logChange}
                        />

                    </form>
                </div>
            </div>

        );
    }
}

