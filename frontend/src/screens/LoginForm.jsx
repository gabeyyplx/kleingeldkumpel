import { useState } from 'react'
import {
  Box,
  Center,
  Button,
  FormControl,
  FormLabel,
  Input,
  Heading,
  useToast,
} from '@chakra-ui/react'
import { backendUrl } from '../utils/backend'

const LoginForm = ({ setIsLoggedIn }) => {
  const [username, setUsername] = useState('')
  const [password, setPassword] = useState('')
  const [isLoading, setIsLoading] = useState(false)
  const toast = useToast()

  const handleSubmit = async (event) => {
    event.preventDefault()
    setIsLoading(true)

    try {
      const response = await fetch(`${backendUrl}/api/users/login`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name: username, password: password }),
      })

      const data = await response.json()
      if (response.ok) {
        localStorage.setItem('token', data.token)
        setIsLoggedIn(true)
        toast({
          title: 'Login successful',
          status: 'success',
          duration: 3000,
          isClosable: true,
        })
      } else {
        toast({
          title: 'Login failed',
          description: data.error,
          status: 'error',
          duration: 3000,
          isClosable: true,
        })
      }
    } catch (error) {
      toast({
        title: 'Error',
        description: 'Something unexpected happened :(',
        status: 'error',
        duration: 3000,
        isClosable: true,
      })
      console.log(error)
    } finally {
      setIsLoading(false)
    }
  }

  return (
    <Box maxW='sm' mx='auto' mt={6}>
      <Heading as='h1' mb={9}>
        💰 kleingeldkumpel
      </Heading>
      <form onSubmit={handleSubmit}>
        <FormControl id='username'>
          <FormLabel>Username</FormLabel>
          <Input
            type='text'
            value={username}
            onChange={(event) => setUsername(event.target.value)}
          />
        </FormControl>
        <FormControl id='password' mt={3}>
          <FormLabel>Password</FormLabel>
          <Input
            type='password'
            value={password}
            onChange={(event) => setPassword(event.target.value)}
          />
        </FormControl>
        <Button mt={3} type='submit' isLoading={isLoading}>
          Login
        </Button>
      </form>
    </Box>
  )
}

export default LoginForm
