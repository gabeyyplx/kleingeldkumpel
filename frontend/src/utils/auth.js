export const checkAuth = async () => {
  return localStorage.getItem('token') ? true : false
}

export const getAuthToken = async () => {
  return localStorage.getItem('token')
}
