import React, {useEffect, useState} from 'react';
import DayBlock from "./DayBlock";
import TimeBlock from "./TimeBlock";
import ScheduleBlock from "./ScheduleBlock";
import {useParams} from "react-router";
import {preloaderEnd, preloaderStart} from "../../../src/Preloader";
import axios from "axios";
import {alertException} from "../../../src/Alert";
import HeaderLogo from "../../../layout/elements/HeaderLogo";
import HeaderItem from "../../../layout/elements/HeaderItem";

export default function Week(props) {
    const params = useParams();
    const [data, setData] = useState();

    useEffect(() => {
        preloaderStart();
        axios.post(`/react/schedule/get-data/${params.type}/${props.number}/${params.id}`)
            .then((res) => {
                setData(res.data);
                console.log(res.data);
            })
            .catch((error) => {alertException(error.response.status)})
            .then(() => { preloaderEnd() });
    }, []);


    const renderDays = () => {
        if (typeof data === 'undefined') return;

        return Object.keys(data.days).map((key) => {
            return <DayBlock key={key} name={data.days[key].name_full}/>
        });
    };

    const renderTimeAndScheduleRow = () => {
        if (typeof data === 'undefined') return;

        return Object.keys(data.times).map((timeKey) => {
            return (
                <div className={'row'} key={timeKey}>
                    <TimeBlock start={data.times[timeKey].timeFrom} end={data.times[timeKey].timeTo}/>
                    {renderScheduleRow(timeKey)}
                    <TimeBlock start={data.times[timeKey].timeFrom} end={data.times[timeKey].timeTo}/>
                </div>
            );
        });
    };

    const renderScheduleRow = (timeKey) => {
        return Object.keys(data.schedules).map((keySchedule) => {
            let schedule = data.schedules[keySchedule][timeKey];
            if (schedule) {
                return <ScheduleBlock
                    key={keySchedule}
                    isEmpty={false}
                    lesson={schedule.lesson}
                    teacher={schedule.teacher.name}
                    building={schedule.cabinet.building.name}
                    cabinet={schedule.cabinet.name}
                />
            } else {
                return <ScheduleBlock key={keySchedule} isEmpty={true}/>
            }
        });
    };



    return (
        <div className={'week ' + props.number}>
            <div className={'row'}>
                <div className={'col-1'}></div>
                <div className={'col-10'}>
                    <div className={'block-title'}>
                        <span>УТ-1-1м</span>
                        <span>Первая неделя</span>
                    </div>
                </div>
                <div className={'col-1'}></div>
            </div>
            <div className={'row block-day-container'}>
                <div className={'col-1'}></div>
                {renderDays()}
                <div className={'col-1'}></div>
            </div>

                {renderTimeAndScheduleRow()}

        </div>
    );
}

