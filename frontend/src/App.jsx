import { useState, useEffect } from 'react'
import {
  BrowserRouter as Router,
  Route,
  Routes,
  Navigate,
} from 'react-router-dom'
import { checkAuth } from './utils/auth'

import LoadingScreen from './components/LoadingScreen'
import LoginForm from './components/LoginForm'
import Dashboard from './components/Dashboard'

function App() {
  const [isLoggedIn, setIsLoggedIn] = useState('false')
  const [isLoading, setIsLoading] = useState(true)

  useEffect(() => {
    const authenticate = async () => {
      const loggedIn = await checkAuth()
      setIsLoggedIn(loggedIn)
      setIsLoading(false)
    }

    authenticate()
  }, [])

  if (isLoading) {
    return <LoadingScreen />
  }

  return (
    <Router>
      <Routes>
        <Route
          path='/login'
          element={
            !isLoggedIn ? (
              <LoginForm setIsLoggedIn={setIsLoggedIn} />
            ) : (
              <Navigate to='/dashboard' />
            )
          }
        />
        <Route
          path='/dashboard'
          element={isLoggedIn ? <Dashboard /> : <Navigate to='/login' />}
        />
        <Route
          path='*'
          element={<Navigate to={isLoggedIn ? '/dashboard' : '/login'} />}
        />
      </Routes>
    </Router>
  )
}

export default App
