import React, {Component} from 'react';
import axios from 'axios';
import {Typeahead} from 'react-bootstrap-typeahead';
import Select from 'react-select';

export default class GroupShow extends Component {
    render() {
        return (
            <div className="container block-center-container group-show">

                <div className={'times'}>
                    <div className={'time border-box'}>10:00-12:00</div>
                    <div className={'time border-box'}>Вт</div>
                    <div className={'time border-box'}>Ср</div>
                    <div className={'time border-box'}>Чт</div>
                    <div className={'time border-box'}>Пт</div>
                    <div className={'time border-box'}>Сб</div>
                    <div className={'time border-box'}>Вс</div>
                </div>

                <div className={'content row'}>
                    <div className={'col-sm-4'}>
                        <div className={'day border-box'}>
                            Понедельник
                        </div>
                        <div className={'schedule border-box'}>
                            asdadas
                        </div>
                    </div>
                    <div className={'col-sm-4'}>
                        <div className={'day border-box'}>
                            Вторник
                        </div>
                    </div>
                    <div className={'col-sm-4'}>
                        <div className={'day border-box'}>
                            Среда
                        </div>
                    </div>
                    <div className={'col-sm-4'}>
                        <div className={'day border-box'}>
                            Четверг
                        </div>
                    </div>
                </div>


            </div>
        );
    }
}

