import React, {useEffect, useState} from 'react';
import Tabs from "../../../src/tabs/Tabs";
import TabsItem from "../../../src/tabs/TabsItem";
import axios from "axios";
import {alertException} from "../../../src/Alert";
import RegisterGroup from "./src/RegisterGroup";
import RegisterTeacher from "./src/RegisterTeacher";
import RegisterUniversity from "./src/RegisterUniversity";

function index(props) {
    const [selUnOpt, setSelUnOpt] = useState([]);

    useEffect(() => {
        axios.post('/react/search/get-universities')
            .then((res) => {
                setSelUnOpt(res.data);
            })
            .catch((error) => {alertException(error.response.status)});
    }, []);

    return (
        <div className="container">
            <div className={'register row'}>
                <div className="col-xs-12 col-sm-4 block-center">
                    <div className={'block-register'}>
                        <span className={'block-name'}>Регистрация</span>

                        <Tabs className={'tabs'} id={'register-tabs'}>
                            <TabsItem
                                group={'student'}
                                title={'Студентам'}
                                active={true}
                                svg={<svg xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" viewBox="0 0 286.39 328.34"><g><path d="M28.03,70.23c0,6.09-0.06,11.83,0.06,17.57c0.02,0.92,0.67,2.2,1.42,2.67c7.13,4.39,8.75,17.64,1.16,23.34 c-0.9,0.67-1.44,2.74-1.16,3.93c2.93,12.38,6.1,24.7,9.12,37.06c1.5,6.15-1.23,9.63-7.52,9.67c-7.11,0.05-14.22,0.05-21.33-0.02 c-6.18-0.06-9.13-3.79-7.67-9.74c2.93-12.01,5.83-24.02,9-35.96c0.68-2.55,0.44-4.23-1.51-5.89c-6.54-5.55-6.01-15.46,0-20.7 c2.33-2.03,2.97-4.23,2.86-7.17c-0.2-5.49-0.14-11-0.04-16.5c0.04-2.19-0.51-3.15-2.91-3.77C3.27,63.1,0,57.98,0.09,50.92 c0.09-7.06,3.25-11.04,9.88-13.01C33.15,31.04,56.29,24,79.47,17.14c18.43-5.45,36.85-10.93,55.39-16 c6.72-1.84,13.75-1.35,20.48,0.66c38.41,11.43,76.79,22.92,115.19,34.4c2.83,0.85,5.76,1.5,8.45,2.69 c6.28,2.77,8.06,6.88,7.23,15.74c-0.42,4.49-4.48,8.77-9.54,10.25c-14.67,4.28-29.3,8.69-44,12.88c-3.12,0.89-3.7,2.08-2.65,5.22 c11.21,33.36,5.11,63.56-17.29,90.41c-13.32,15.96-30.46,26.13-50.83,30.04c-28.29,5.42-54.18-0.55-76.73-18.79 c-16.97-13.73-27.8-31.56-32.19-53c-3.32-16.21-2.56-32.31,3.23-48.01c1.72-4.66,1.6-4.59-3.13-5.95 C44.8,75.29,36.55,72.77,28.03,70.23z M204.64,112.65c0.35-0.09,0.71-0.17,1.06-0.26c-1.82-7.27-3.62-14.54-5.45-21.8 c-0.57-2.27-1.73-2.75-4.1-2.01c-11.41,3.59-22.95,6.75-34.31,10.49c-9.96,3.28-19.88,4.9-30.14,1.87 c-13.7-4.04-27.41-8.04-41.06-12.27c-2.51-0.78-3.42-0.39-4.33,2.03c-6.6,17.6-5.89,34.86,3.06,51.35 c12.54,23.1,38.52,35.9,64.88,31.1C183.43,167.83,204.76,141.94,204.64,112.65z M74.8,50.95c0.92,0.69,1.18,1.01,1.5,1.11 c20.8,6.21,41.58,12.49,62.44,18.49c2.79,0.8,6.19,0.85,8.96,0.05c19.31-5.55,38.53-11.4,57.77-17.17c2.11-0.63,4.2-1.35,6.95-2.23 c-19.98-5.92-39.22-11.36-58.27-17.38c-7.11-2.25-13.78-3.11-20.79-0.15c-2.83,1.19-5.89,1.83-8.85,2.69 C108.08,41.19,91.65,46.01,74.8,50.95z"/><path d="M143.21,256.38c12.79-10.67,25.36-21.18,37.95-31.67c6.96-5.8,14.15-11.36,20.83-17.46c3.41-3.11,6.98-1.48,10.1-1.04 c18.62,2.63,35.12,10.31,48.55,23.55c13.57,13.39,22.64,29.49,24.74,48.76c0.91,8.35,1.46,16.92,0.56,25.22 c-0.95,8.72-6.46,15.41-13.91,20.15c-4.92,3.13-10.28,4.39-16.23,4.38c-75.45-0.12-150.91-0.23-226.36,0.06 c-13.71,0.05-28.73-13.68-29.31-27.73c-0.71-16.99,1.31-33.2,9.15-48.33c9.65-18.63,24.29-32.01,43.62-40.23 c8.84-3.76,18.11-5.63,27.6-6.54c0.96-0.09,2.19,0.36,2.95,0.99c13.21,10.93,26.38,21.91,39.54,32.9 C129.66,244.97,136.3,250.58,143.21,256.38z M255.23,297.27c3.49-23.36-11.75-48.28-34.3-56.96c-4.8-1.84-8.25-1.97-12.49,1.72 c-15.74,13.68-31.89,26.88-47.86,40.3c-0.69,0.58-1.56,1.47-1.59,2.24c-0.16,4.19-0.07,8.4-0.07,12.7 C191.33,297.27,223.3,297.27,255.23,297.27z M127.65,297.31c0-3.87,0.17-7.49-0.09-11.07c-0.1-1.37-0.86-3.06-1.89-3.93 c-16.98-14.38-34.04-28.66-51.16-42.88c-0.84-0.7-2.5-1.04-3.56-0.74c-11.67,3.31-21.43,9.62-28.77,19.36 c-8.72,11.57-12.47,24.6-11,39.25C63.28,297.31,95.17,297.31,127.65,297.31z"/></g></svg>}
                            >
                                <RegisterGroup selUnOpt={selUnOpt}/>
                            </TabsItem>
                            <TabsItem
                                group={'teacher'}
                                title={'Преподавателям'}
                                svg={<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 410.54 327.82"><g><path d="M225.48,267.17c0-6.51,0-12.49,0-18.47c0-13.88-0.05-27.75,0.02-41.63c0.05-10.82,6.17-19.24,15.7-21.49 c2.51-0.59,5.2-0.6,7.81-0.6c25.63-0.03,51.26,0.31,76.88-0.13c14.89-0.26,23.59,10.61,23.19,23.4 c-0.29,9.11-0.06,18.24-0.06,27.95c5.1,0,10.04,0,14.99,0c4.98,0,9.95,0,15.18,0c0-68.36,0-136.41,0-204.73 c-81.77,0-163.46,0-245.67,0c0,12.02,0,24.05,0,35.7c-10.39-2.05-20.35-4.02-31.07-6.14c0.48,0.61,0.2,0.42,0.2,0.23 c-0.03-10.62-0.52-21.27,0.08-31.86c0.88-15.62,14.3-29.53,32.73-29.39c43.88,0.33,87.76,0.11,131.63,0.11 c36.63,0,73.26-0.01,109.88,0c6.7,0,13.17,0.91,18.87,4.88c9.45,6.59,14.65,15.57,14.66,27.12c0.07,67.38,0.04,134.77,0.04,202.15 c0,19.28-13.35,32.82-32.66,32.87c-37.13,0.09-74.26,0.03-111.38,0.03C252.99,267.17,239.5,267.17,225.48,267.17z M257.03,216.08 c0,6.85,0,13.38,0,19.81c20.44,0,40.57,0,60.67,0c0-6.76,0-13.2,0-19.81C297.42,216.08,277.37,216.08,257.03,216.08z"/><path d="M102.59,328.77c-24.74,0-49.48-0.04-74.23,0.03c-9.06,0.03-16.84-2.59-22.78-9.79c-3.39-4.1-5.53-8.79-5.48-14.01 c0.13-12.7-0.88-25.68,1.42-38.02c5.2-27.86,25.8-46.64,56.06-47.37c9.8-0.24,18.94,2.49,28.29,4.52 c14.82,3.22,29.3,1.16,43.89-2.41c22.34-5.46,42.63-1.11,59.11,15.66c10.64,10.83,15.63,24.4,16.24,39.48 c0.32,7.73-0.27,15.51,0.12,23.24c0.82,16.11-9.83,28.89-28.44,28.71C152.08,328.59,127.33,328.76,102.59,328.77z M30.62,297.49 c48.53,0,96.06,0,144.15,0c-0.36-7.97-0.13-15.75-1.2-23.36c-1.46-10.41-6.92-18.39-17.3-21.98c-7.31-2.53-14.71-1.95-22.06,0.21 c-16.03,4.72-32.36,5.76-48.83,3.2c-7.48-1.16-14.75-3.89-22.24-4.72c-15.25-1.68-27.72,5.01-31.03,20.83 C30.37,279.96,31.04,288.73,30.62,297.49z"/><path d="M164.17,143.9c-0.07,34.42-28.57,64.08-66.34,61.49c-30.93-2.13-58.17-28.73-56.9-64.25 c1.13-31.53,29.03-61.34,66.22-58.72C137.59,84.56,163.98,109.93,164.17,143.9z M133.2,144.06c0-17.06-13.9-30.97-30.87-30.87 c-16.22,0.09-30.31,13.95-30.35,29.85c-0.05,17.82,13.48,31.7,30.86,31.66C119.37,174.65,133.2,160.7,133.2,144.06z"/></g></svg>}
                            >
                                <RegisterTeacher selUnOpt={selUnOpt}/>
                            </TabsItem>
                            <TabsItem
                                group={'university'}
                                title={'Университетам'}
                                svg={<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 409.68 327.75"><g><path d="M328.06,327.43c-10.59,0-20.55,0-31.11,0c0-1.53,0-3.08,0-4.64c0-74.48-0.03-148.95,0.08-223.43 c0.01-3.61-0.98-5.71-4.06-7.74c-28.46-18.78-56.82-37.73-85.14-56.72c-2.19-1.47-3.66-1.54-5.9-0.04 c-28.83,19.3-57.72,38.52-86.66,57.66c-2.24,1.48-2.58,3.16-2.58,5.55c0.05,74.85,0.04,149.7,0.04,224.55c0,1.48,0,2.96,0,4.69 c-10.37,0-20.52,0-31,0c0-57.68,0-115.28,0-173.16c-16.97,0-33.61,0-50.76,0c0,1.57,0,3.14,0,4.7c0,52.02,0.04,104.04-0.1,156.06 c-0.01,2.93-0.85,6.33-2.52,8.64c-1.43,1.98-4.48,3.41-7.03,3.84c-3.76,0.63-7.71,0.18-11.58,0.16c-5.05-0.03-8.85-3.22-9.3-8.23 c-0.39-4.46-0.44-8.95-0.44-13.43C-0.01,252.52,0,199.12,0.02,145.73c0-11.59,5.38-19.57,15.04-22.06c2.74-0.71,5.65-1,8.48-1.01 c17.85-0.09,35.69-0.04,53.54-0.04c1.35,0,2.69,0,4.57,0c0-1.79-0.01-3.24,0-4.68c0.11-10.22,0.11-20.44,0.4-30.66 c0.19-6.84,3.65-11.96,9.27-15.72c33.62-22.47,67.19-45,100.85-67.41c8.39-5.58,17.11-5.5,25.5,0.08 c33.49,22.25,66.92,44.59,100.38,66.9c7.18,4.79,10.04,11.71,9.98,20.11c-0.06,8.98-0.04,17.96-0.05,26.95c0,1.35,0,2.69,0,4.45 c1.75,0,3.09,0,4.43,0c18.22,0,36.44,0.02,54.66-0.01c8-0.01,14.51,2.95,19.27,9.46c2.87,3.91,3.31,8.52,3.31,13.12 c0.04,57.01-0.01,114.02,0.08,171.03c0.01,7.09-4.41,12.25-11.47,11.4c-2.58-0.31-5.24-0.05-7.86-0.05 c-7.53,0-11.66-4.07-11.67-11.74c-0.04-23.33-0.02-46.66-0.02-69.99c0-29.32,0.01-58.63,0-87.95c0-1.21-0.1-2.43-0.17-3.82 c-16.87,0-33.52,0-50.49,0C328.06,211.87,328.06,269.47,328.06,327.43z"/><path d="M261.3,133.23c-0.32,31.54-25.46,56.33-56.57,56.41c-29.99,0.07-56.27-24.43-56.27-56.62c0-30.56,25.14-56.06,55.57-56.21 C235.81,76.66,261.11,101.58,261.3,133.23z M214.94,133.28c0-1.68,0-2.79,0-3.9c0.02-6.73,0.1-13.46,0.03-20.19 c-0.05-5.06-1.45-6.43-6.42-6.58c-2.37-0.07-4.74-0.03-7.11,0.02c-5.37,0.13-6.66,1.33-6.68,6.64c-0.05,12.46-0.05,24.92,0,37.39 c0.02,5.36,1.47,6.77,6.97,6.83c6.98,0.08,13.96,0.08,20.94,0.07c12.96-0.02,12.96-0.04,12.87-13.08c-0.04-5.52-1.6-7.14-7.06-7.2 C224.15,133.25,219.81,133.28,214.94,133.28z"/><path d="M246,276.28c0,13.09,0.01,26.19-0.01,39.28c-0.01,8.38-3.68,12.01-12.04,12.01c-19.83,0-39.67,0.01-59.5,0 c-6.43,0-10.67-3.85-10.7-10.33c-0.1-27.18-0.09-54.37,0-81.55c0.02-5.56,3.55-9.31,9.04-10.18c1.35-0.21,2.73-0.25,4.1-0.25 c18.59-0.02,37.17-0.03,55.76-0.02c9.73,0,13.35,3.61,13.35,13.27C246,251.1,246,263.69,246,276.28z"/></g></svg>}
                            >
                                <RegisterUniversity />
                            </TabsItem>
                        </Tabs>

                    </div>
                </div>
            </div>
        </div>


    );
}

export default index;