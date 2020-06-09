import React, {useEffect, useState} from 'react'
import Tabs from '../../../src/Tabs/Tabs'
import TabsItem from '../../../src/Tabs/TabsItem'
import axios from 'axios'
import {alertException} from '../../../src/Alert/Alert'
import RegisterGroup from './src/RegisterGroup'
import RegisterTeacher from './src/RegisterTeacher'
import RegisterUniversity from './src/RegisterUniversity'
import {iconUser, iconTeacher, iconUniversity} from '../../../src/Icon'
import './style.scss'

function index(props) {
  const [selUnOpt, setSelUnOpt] = useState([])

  useEffect(() => {
    axios
      .post('/react/search/get-universities')
      .then((res) => {
        setSelUnOpt(res.data)
      })
      .catch((error) => {
        alertException(error.response.status)
      })
  }, [])

  return (
    <div className="container">
      <div className={'register row'}>
        <div className="col-xs-12 col-sm-4 block-center">
          <div className={'block-register'}>
            <span className={'block-name'}>Регистрация</span>

            <Tabs className={'tabs'} id={'register-tabs'}>
              <TabsItem group={'student'} title={'Студентам'} active={true} svg={iconUser}>
                <RegisterGroup selUnOpt={selUnOpt} />
              </TabsItem>
              <TabsItem group={'teacher'} title={'Преподавателям'} svg={iconTeacher}>
                <RegisterTeacher selUnOpt={selUnOpt} />
              </TabsItem>
              <TabsItem group={'university'} title={'Университетам'} svg={iconUniversity}>
                <RegisterUniversity />
              </TabsItem>
            </Tabs>
          </div>
        </div>
      </div>
    </div>
  )
}

export default index
