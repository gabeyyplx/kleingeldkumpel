import { useState } from 'react'
import {
  Box,
  Flex,
  Button,
  FormControl,
  FormLabel,
  Input,
  Heading,
  useToast,
} from '@chakra-ui/react'

function LoginForm() {
  const [username, setUsername] = useState('')
  const [password, setPassword] = useState('')
  const [isLoading, setIsLoading] = useState(false)
  const toast = useToast()

  const handleSubmit = async (event) => {
    event.preventDefault()
    setIsLoading(true)

    try {
      const response = await fetch('http://localhost:3000/api/users/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name: username, password: password }),
      })

      const data = await response.json()
      if (response.ok) {
        // Speichern des Tokens und Weiterleitung zum Dashboard
        localStorage.setItem('token', data.token)
        toast({
          title: 'Login successful',
          description: 'You will be redirected (eventually)',
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
    } finally {
      setIsLoading(false)
    }
  }

  return (
    <Flex w='100%' minH='100vh' align='center' justify='center'>
      <Box maxW='sm' mx='auto' mt={5}>
        <Heading as='h1' mb={10}>
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
          <FormControl id='password' mt={4}>
            <FormLabel>Password</FormLabel>
            <Input
              type='password'
              value={password}
              onChange={(event) => setPassword(event.target.value)}
            />
          </FormControl>
          <Button mt={4} type='submit' isLoading={isLoading}>
            Login
          </Button>
        </form>
      </Box>
    </Flex>
  )
}

export default LoginForm
