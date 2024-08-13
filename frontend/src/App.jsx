import { useState, useEffect } from 'react'
import { Container } from '@chakra-ui/react'
import { BrowserRouter as Router } from 'react-router-dom'

import { checkAuth } from './utils/auth'
import LoadingScreen from './screens/LoadingScreen'
import AppRouter from './components/AppRouter'
import Navbar from './components/NavBar'

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
      <Navbar isLoggedIn={isLoggedIn} />
      <Container p={12}>
        <AppRouter isLoggedIn={isLoggedIn} setIsLoggedIn={setIsLoggedIn} />
      </Container>
    </Router>
  )
}

export default App
