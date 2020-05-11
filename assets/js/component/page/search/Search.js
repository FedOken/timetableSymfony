import React, { useState } from 'react';
import Tabs from "react-bootstrap/Tabs";
import {Tab} from "react-bootstrap";
import Group from "./src/Group";

function index(props) {
    return (
        <div className="search container">
            <div className="col-xs-12 col-sm-6 col-md-4">
                <div className={'block-search'}>
                    <form>
                        <Tabs defaultActiveKey="group" id="group-tab">
                            <Tab eventKey="group" title="Группа" >
                                <Group />
                            </Tab>
                            <Tab eventKey="teacher" title="Преподаватель">

                            </Tab>
                            <Tab eventKey="cabinet" title="Кабинет">

                            </Tab>
                        </Tabs>

                    </form>
                </div>
            </div>
        </div>
    );
}

export default index;