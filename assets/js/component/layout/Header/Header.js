import React from 'react';
import {connect} from 'react-redux';
import HeaderItem from './src/HeaderItem';
import HeaderLogo from './src/HeaderLogo';
import {getRoleLabel} from '../../src/Auth';
import {iconHome, iconPanel, iconCalendar, iconSearch, iconLogo, iconContact, iconLogin, iconProfile} from '../../src/Icon';
import './style.scss';
import {isEmpty} from '../../src/Helper';

function index(props) {
  const renderFirstElement = () => {
    if (!isEmpty(props.user.model.data)) {
      let rolesForPanel = [getRoleLabel('admin'), getRoleLabel('university')];
      if (rolesForPanel.includes(props.user.model.data.role)) {
        return <HeaderItem url={'/admin'} icon={iconPanel} text={'Panel'} activeLinks={[]} />;
      }
      return <HeaderItem url={'/sch'} icon={iconCalendar} text={'Schedule'} activeLinks={['/sch']} />;
    }
    return <HeaderItem url={'/welcome'} icon={iconHome} text={'Home'} activeLinks={[]} />;
  };

  const renderLastElement = () => {
    if (!isEmpty(props.user.model.data)) {
      return <HeaderItem url={'/profile'} icon={iconProfile} text={'Profile'} activeLinks={['/profile']} />;
    }
    return (
      <HeaderItem
        url={'/login'}
        icon={iconLogin}
        text={'Login'}
        activeLinks={['/login', '/register', '/reset-password', '/reset-password/email-send']}
      />
    );
  };

  if (props.pathname === '/welcome') {
    return <header className={'header only_logo'}>{iconLogo}</header>;
  } else {
    return (
      <header className={'header'}>
        {renderFirstElement()}
        <HeaderItem url={'/search'} icon={iconSearch} text={'Search'} activeLinks={['/search']} />
        <HeaderLogo url={'/welcome'} icon={iconLogo} activeLinks={['/welcome']} />
        <HeaderItem
          url={'/contact'}
          icon={iconContact}
          text={'Contact us'}
          activeLinks={['/contact', '/contact/business', '/contact/technical']}
        />
        {renderLastElement()}
      </header>
    );
  }
}

function mapStateToProps(state) {
  return {
    user: state.user,
    pathname: state.router.location.pathname,
  };
}

export default connect(mapStateToProps)(index);
