import React from 'react'
import {connect} from 'react-redux'
import HeaderItem from './src/HeaderItem'
import HeaderLogo from './src/HeaderLogo'
import {getRoleLabel} from '../../src/Auth'
import {iconHome, iconPanel, iconCalendar, iconSearch, iconLogo, iconContact, iconLogin, iconProfile,} from '../../src/Icon'
import './style.scss'

function index(props) {
  const renderFirstElement = () => {
    if (props.user.isLogin) {
      let rolesForPanel = [getRoleLabel('admin'), getRoleLabel('university')]
      if (rolesForPanel.includes(props.user.data.role)) {
        return <HeaderItem url={'/admin'} icon={iconPanel} text={'Panel'} />
      }
      return <HeaderItem url={'/sch'} icon={iconCalendar} text={'Schedule'} />
    }
    return <HeaderItem url={'/welcome'} icon={iconHome} text={'Home'} />
  }

  const renderLastElement = () => {
    if (props.user.isLogin) {
      return <HeaderItem url={'/profile'} icon={iconProfile} text={'Profile'} />
    }
    return <HeaderItem url={'/login'} icon={iconLogin} text={'Login'} />
  }

  if (props.pathname === '/welcome') {
    return <header className={'header only_logo'}>{iconLogo}</header>
  } else {
    return (
      <header className={'header'}>
        {renderFirstElement()}
        <HeaderItem url={'/search'} icon={iconSearch} text={'Search'} />
        <HeaderLogo url={'/welcome'} icon={iconLogo} />
        <HeaderItem url={'/contact'} icon={iconContact} text={'Contact us'} />
        {renderLastElement()}
      </header>
    )
  }
}

function mapStateToProps(state) {
  return {
    user: state.user,
    pathname: state.router.location.pathname,
  }
}

export default connect(mapStateToProps)(index)
