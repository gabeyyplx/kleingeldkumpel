import { backendUrl } from './backend'

export const checkAuth = async () => {
  try {
    const response = await fetch(`${backendUrl}/api/users/verify-token`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${getAuthToken()}`,
      },
    })
    if (response.status === 200) return true
  } catch (error) {
    console.log('Error trying to verify token:' + error)
  }
  return false
}

export const getAuthToken = () => {
  return localStorage.getItem('token')
}
