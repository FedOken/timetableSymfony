import React from 'react'
import {NavLink} from 'react-router-dom'
import {bindActionCreators} from 'redux'
import {push} from 'connected-react-router'
import {connect} from 'react-redux'

const index = (props) => {
  const reduxRoute = (url) => {
    props.push(url)
  }

  return (
    <div className={'header_item_logo'}>
      <NavLink exact to={props.url} onClick={() => reduxRoute(props.url)}>
        {props.icon}
      </NavLink>
    </div>
  )
}

function matchDispatchToProps(dispatch) {
  return bindActionCreators({push: push}, dispatch)
}

export default connect(null, matchDispatchToProps)(index)
