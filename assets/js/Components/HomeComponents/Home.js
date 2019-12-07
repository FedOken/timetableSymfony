import React, {Component} from 'react';
import axios from 'axios';
import {AsyncTypeahead} from 'react-bootstrap-typeahead';
import Select from 'react-select';
import ButtonOutlineType1 from "../LayoutComponents/Button/ButtonOutlineType1";
import Button from "react-bootstrap/Button";
import {Link} from "react-router-dom";

export default class Home extends Component {

    constructor(props) {
        super(props);
        this.state = {
            parties: [],
            isLoading: false,
            universities: [],
            selectPartyOptions: [],
            selectPartyDisable: true,
            selectPartyValue: '',
            searchBtnDisabled: 'disabled'
        };
        this.universityChange = this.universityChange.bind(this);
        this.partiesSearch = this.partiesSearch.bind(this);
    }
    componentDidMount() {
        axios.post(`/react/home/get-parties-all`)
            .then(res => {
                this.setState( {parties: res.data} );
            });
        axios.post(`/react/home/get-university`)
            .then(res => {
                this.setState( {universities: res.data} );
            });
    }

    universityChange(val) {
        axios.post('/react/home/get-parties/' + val.value)
            .then(res => {
                this.setState( {selectPartyOptions: res.data} );
                this.setState( {selectPartyDisable: res.data.length === 0 ? true : false } )
            });
    }

    partiesSearch(searchText) {
        this.setState( {isLoading: true} );
        axios.post(`/react/home/get-parties/`+searchText)
            .then(res => {
                this.setState( {isLoading: false} );
                this.setState( {parties: res.data} );
            });
    }

    render() {
        return (
            <div className="container block-center-container">
                <div className="col-xs-12 col-sm-6 col-md-4 col-lg-3 block-center">
                    <form action="">
                        <p>Enter group</p>
                        <AsyncTypeahead
                            id="asdasd"
                            isLoading={this.state.isLoading}
                            onSearch={query => {
                                this.partiesSearch(query)
                            }}
                            options={this.state.parties}
                            useCache={false}
                            promptText="Type to search..."
                            maxResults={10}
                            minLength={1}
                        />
                        <p className="row-delimiter">or</p>
                        <Select
                            name="group-select"
                            options={this.state.universities}
                            onChange={this.universityChange}
                        />
                        <Select
                            name="group-select"
                            className={'select-party'}
                            value={this.state.selectPartyValue}
                            options={this.state.selectPartyOptions}
                            isDisabled={this.state.selectPartyDisable}
                        />
                        <Button type="button" className={"w-100"} variant="outline-info">Search</Button>
                    </form>
                    <Link to={"/group/show"}>group</Link>
                </div>
            </div>

        );
    }
}

