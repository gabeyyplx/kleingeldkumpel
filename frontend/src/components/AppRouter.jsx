import { Route, Routes, Navigate } from 'react-router-dom'
import LoginForm from '../screens/LoginForm'
import Dashboard from '../screens/Dashboard'
import AddTransaction from '../screens/AddTransaction'

const AppRouter = ({ isLoggedIn, setIsLoggedIn }) => {
  return (
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
        path='/add-transaction'
        element={isLoggedIn ? <AddTransaction /> : <Navigate to='/login' />}
      />
      <Route
        path='*'
        element={<Navigate to={isLoggedIn ? '/dashboard' : '/login'} />}
      />
    </Routes>
  )
}

export default AppRouter
