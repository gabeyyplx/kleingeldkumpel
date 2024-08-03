export const checkAuth = async () => {
  // Todo: Verify token
  return localStorage.getItem('token') ? true : false
}
