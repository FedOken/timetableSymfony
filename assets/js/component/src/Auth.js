export function getRoles() {
  return ['ROLE_ADMIN', 'ROLE_UNIVERSITY_MANAGER', 'ROLE_FACULTY_MANAGER', 'ROLE_PARTY_MANAGER', 'ROLE_TEACHER']
}

export function getRoleLabel(label) {
  switch (label) {
    case 'admin':
      return 'ROLE_ADMIN'
    case 'university':
      return 'ROLE_UNIVERSITY_MANAGER'
    case 'faculty':
      return 'ROLE_FACULTY_MANAGER'
    case 'party':
      return 'ROLE_PARTY_MANAGER'
    case 'teacher':
      return 'ROLE_TEACHER'
    default:
      return ''
  }
}
