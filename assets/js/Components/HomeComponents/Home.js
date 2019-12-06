import React, {Component} from 'react';
import axios from 'axios';
import {Typeahead} from 'react-bootstrap-typeahead';
import Select from 'react-select';
import {Link} from "react-router-dom";

export default class Home extends Component {

    constructor(props) {
        super(props);
        this.state = {
            universities: [],
            selectPartyOptions: [],
            selectPartyDisable: true,
            test: ''
        };
        this.universityChange = this.universityChange.bind(this);
    }
    componentDidMount() {
        axios.post(`/react/home/get-university`)
            .then(res => {
                this.setState( {universities: res.data} );
            });
    }

    universityChange(val) {
        this.setState( {test: val.label} );

        let self = this;
        axios.post('/react/home/get-parties/' + val.value)
            .then(res => {
                this.setState( {selectPartyOptions: res.data} );
                this.setState( {selectPartyDisable: res.data.length === 0 ? true : false } )
            });
    }

    render() {
        return (
            <div className="container block-center-container">
                <div className="col-xs-12 col-sm-6 col-md-4 col-lg-3 block-center">
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
                        <p className="row-delimiter">or</p>

                        <Select
                            name="group-select"
                            //value="one"
                            options={this.state.universities}
                            onChange={this.universityChange}
                        />
                        <br/>
                        <Select
                            name="group-select"
                            options={this.state.selectPartyOptions}
                            isDisabled={this.state.selectPartyDisable}
                        />
                        <button type="button" className="btn btn-outline-info w-100">Info</button>
                    </form>
                    <Link to={"/group/show"}>group</Link>
                </div>
            </div>

        );
    }
}

