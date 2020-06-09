import React, {useEffect} from 'react'
import {bindActionCreators} from 'redux'
import {push} from 'connected-react-router'
import {connect} from 'react-redux'
import {preloaderEnd} from '../../../src/Preloader/Preloader'
import './style.scss'
import Tabs from '../../../src/Tabs/Tabs'
import TabsItem from '../../../src/Tabs/TabsItem'
import {iconDoor, iconProfile, iconShield, iconTeacher} from '../../../src/Icon'
import ProfileProfile from './src/ProfileProfile'

function index(props) {
  return (
    <div className="profile container">
      <div className="col-xs-12 col-sm-6 block-center">
        <Tabs className={'tabs'} id={'profile-tabs'}>
          <TabsItem group={'student'} title={'Профиль'} active={true} svg={iconProfile}>
            <ProfileProfile />
          </TabsItem>
          <TabsItem group={'teacher'} title={'Преподаватели'} svg={iconTeacher}>

          </TabsItem>
          <TabsItem group={'teacher'} title={'Аудитории'} svg={iconDoor}>
            <p>asdassd</p>
          </TabsItem>
          <TabsItem group={'university'} title={'Безопасность'} svg={iconShield}>
            <p>asdsasdasasd</p>
          </TabsItem>
        </Tabs>

        {/*<form>*/}
        {/*  <div>*/}
        {/*    <p className={'title'}>Общая информация:</p>*/}
        {/*    <input className={'form-control input input-type-1 w-100'} placeholder={'Имя'} type="text" />*/}
        {/*    <input className={'form-control input input-type-1 w-100'} placeholder={'Фамилия'} type="text" />*/}
        {/*    <p>*/}
        {/*      Университет: <span>Национальный транспортный университет</span>*/}
        {/*    </p>*/}
        {/*    <p>*/}
        {/*      Группа: <span>УТ-1-1м</span>*/}
        {/*    </p>*/}
        {/*  </div>*/}
        {/*  <div>*/}
        {/*    <p className={'title'}>Контакты:</p>*/}
        {/*    <input className={'form-control input input-type-1 w-100'} placeholder={'Email'} type="text" />*/}
        {/*    <input className={'form-control input input-type-1 w-100'} placeholder={'Телефон'} type="email" />*/}
        {/*  </div>*/}
        {/*  <div>*/}
        {/*    <p className={'title'}>Безопасность:</p>*/}
        {/*    <input className={'form-control input input-type-1 w-100'} placeholder={'Старый пароль'} type="password" />*/}
        {/*    <input className={'form-control input input-type-1 w-100'} placeholder={'Новый пароль'} type="password" />*/}
        {/*    <input*/}
        {/*      className={'form-control input input-type-1 w-100'}*/}
        {/*      placeholder={'Еще раз новый пароль'}*/}
        {/*      type="password"*/}
        {/*    />*/}
        {/*  </div>*/}
        {/*  <div className={'buttons'}>*/}
        {/*    <button type={'button'} className={'btn btn-type-2'}>*/}
        {/*      Восстановить*/}
        {/*    </button>*/}
        {/*    <button type={'button'} className={'btn btn-type-1'} onClick={() => redirect('/logout')}>*/}
        {/*      Выйти из аккаунта*/}
        {/*    </button>*/}
        {/*  </div>*/}
        {/*</form>*/}
      </div>
    </div>
  )
}

function matchDispatchToProps(dispatch) {
  return bindActionCreators({push: push}, dispatch)
}

export default connect(null, matchDispatchToProps)(index)
