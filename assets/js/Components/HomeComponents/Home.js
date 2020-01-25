import React, {Component} from 'react';
import axios from 'axios';
import {AsyncTypeahead} from 'react-bootstrap-typeahead';
import Select from 'react-select';
import Button from "react-bootstrap/Button";
import {Link} from "react-router-dom";
import Tabs from "react-bootstrap/Tabs";
import {Tab} from "react-bootstrap";

export default class Home extends Component {

    constructor(props) {
        super(props);
        this.state = {
            groupToSearch: '',

            inputParties: [],
            inputValue: [],
            inputIsLoading: false,

            selectUniversityValue: '',
            selectUniversityOptions: [],
            selectUniversityDisable: true,

            selectPartyValue: '',
            selectPartyOptions: [],
            selectPartyDisable: true,

            searchBtnDisabled: true
        };
        this.universityChange = this.universityChange.bind(this);
        this.partyChange = this.partyChange.bind(this);
        this.autocompleteSearch = this.autocompleteSearch.bind(this);
        this.autocompleteChange = this.autocompleteChange.bind(this);
        this.autocompleteInputChange = this.autocompleteInputChange.bind(this);
    }
    componentDidMount() {
        axios.post(`/react/home/get-university`)
            .then(res => {
                this.setState( {selectUniversityOptions: res.data} );
                this.setState( {selectUniversityDisable: res.data.length === 0} );
            });
    }

    autocompleteSearch(searchText) {
        this.setState( {inputIsLoading: true} );
        axios.post(`/react/home/get-parties-autocomplete/` + searchText)
            .then(res => {
                this.setState( {inputIsLoading: false} );
                this.setState( {inputParties: res.data} );
            });
    }

    autocompleteChange(val) {
        if (val.length > 0) {
            this.setState( {inputValue: [{
                    id: val[0].id,
                    label: val[0].label,
                }]
            } );
            this.setState( {groupToSearch: val[0].id} );
            this.setState( {searchBtnDisabled: false} );
        }
    }

    autocompleteInputChange(val) {
        this.setState( {inputValue: [{
                id: 0,
                label: val,
            }]
        } );
        if ( val.length > 2) {
            this.setState( {groupToSearch: val} );
            this.setState( {searchBtnDisabled: false} );
        }
    }

    universityChange(val) {
        this.setState( {selectUniversityValue: val} );
        this.setState( {selectPartyDisable: true } );
        axios.post('/react/home/get-parties-select/' + val.value)
            .then(res => {
                this.setState( {selectPartyOptions: res.data} );
                this.setState( {selectPartyDisable: res.data.length === 0 } )
            });
    }

    partyChange(val) {
        this.setState( {selectPartyValue: val} );
        this.setState( {groupToSearch: val.value} );
        this.setState( {searchBtnDisabled: false} );
    }

    render() {
        return (
            <div className="container block-center-container">
                <div className="col-xs-12 col-sm-6 col-md-4 col-lg-3 block-center">
                    <form>
                        <Tabs defaultActiveKey="group" id="group-tab">
                            <Tab eventKey="group" title="Group" >
                                <p className={'enter-group'}>Enter group name</p>
                                <AsyncTypeahead
                                    id="home-autocomplete"
                                    isLoading={this.state.inputIsLoading}
                                    onSearch={query => {
                                        this.autocompleteSearch(query)
                                    }}
                                    onChange={val => {
                                        this.autocompleteChange(val)
                                    }}
                                    onInputChange={val => {
                                        this.autocompleteInputChange(val)
                                    }}
                                    options={this.state.inputParties}
                                    selected={this.state.inputValue}
                                    useCache={false}
                                    promptText="Type to search..."
                                    maxResults={7}
                                    minLength={2}
                                />

                                <p className="row-delimiter">or</p>

                                <Select
                                    name="group-select"
                                    options={this.state.selectUniversityOptions}
                                    onChange={this.universityChange}
                                    value={this.state.selectUniversityValue}
                                    isDisabled={this.state.selectUniversityDisable}
                                />
                                <Select
                                    name="group-select"
                                    className={'select-party'}
                                    options={this.state.selectPartyOptions}
                                    value={this.state.selectPartyValue}
                                    onChange={this.partyChange}
                                    isDisabled={this.state.selectPartyDisable}
                                />
                                <Link to={'group/show/'+ this.state.groupToSearch}>
                                    <Button type="button" className={"w-100"} variant="type-2" disabled={this.state.searchBtnDisabled}>Search</Button>
                                </Link>
                            </Tab>
                            <Tab eventKey="teacher" title="Teacher">

                            </Tab>
                            <Tab eventKey="cabinet" title="Cabinet">

                            </Tab>
                        </Tabs>

                    </form>
                </div>
            </div>

        );
    }
}

