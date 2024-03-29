import React from 'react';
import {connect} from 'react-redux';
import HeaderItem from './src/HeaderItem';
import HeaderLogo from './src/HeaderLogo';
import {getRoleLabel} from '../../src/Auth';
import {
  iconHome,
  iconPanel,
  iconCalendar,
  iconSearch,
  iconLogo,
  iconContact,
  iconLogin,
  iconProfile,
} from '../../src/Icon';
import './style.scss';
import {isEmpty} from '../../src/Helper';
import {t} from '../../src/translate/translate';

function index(props) {
  const renderFirstElement = () => {
    if (!isEmpty(props.user.model.data)) {
      return (
        <HeaderItem url={'/admin'} icon={iconPanel} text={t(props.lang, 'Panel')} activeLinks={[]} isBlanc={true} />
      );
    }
    return <HeaderItem url={'/'} icon={iconHome} text={t(props.lang, 'Home')} activeLinks={[]} />;
  };

  const renderLastElement = () => {
    if (!isEmpty(props.user.model.data)) {
      return (
        <HeaderItem url={'/profile'} icon={iconProfile} text={t(props.lang, 'Profile')} activeLinks={['/profile']} />
      );
    }
    return (
      <HeaderItem
        url={'/login'}
        icon={iconLogin}
        text={t(props.lang, 'Log in')}
        activeLinks={['/login', '/register', '/reset-password', '/reset-password/email-send']}
      />
    );
  };

  if (props.pathname === '/') {
    return <header className={'header only_logo'}>{iconLogo}</header>;
  } else {
    return (
      <header className={'header'}>
        {renderFirstElement()}
        <HeaderItem url={'/search'} icon={iconSearch} text={t(props.lang, 'Search')} activeLinks={['/search']} />
        <HeaderLogo url={'/'} icon={iconLogo} activeLinks={['/']} />
        <HeaderItem
          url={'/contact'}
          icon={iconContact}
          text={t(props.lang, 'Contacts')}
          activeLinks={['/contact', '/contact/business', '/contact/technical']}
        />
        {renderLastElement()}
      </header>
    );
  }
}

const mapToProps = (state) => {
  return {
    user: state.user,
    pathname: state.router.location.pathname,
    lang: state.lang,
  };
};

export default connect(mapToProps)(index);
