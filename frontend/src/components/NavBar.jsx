import React from 'react'
import { Link as ReactRouterLink } from 'react-router-dom'
import { Box, Button, Flex, Text, Link as ChakraLink } from '@chakra-ui/react'
import { AddIcon } from '@chakra-ui/icons'

const Navbar = ({ isLoggedIn }) => {
  if (!isLoggedIn) return <></>

  return (
    <Box shadow='base' p={4}>
      <Flex align='center' justify='space-between' wrap='wrap'>
        <ChakraLink
          _hover={{ textDecoration: 'none' }}
          as={ReactRouterLink}
          to='/'
        >
          <Text fontSize='xl' fontWeight='bold' mr={3}>
            💰
          </Text>
        </ChakraLink>
        <Flex align='center' gap={8}>
          <ChakraLink as={ReactRouterLink} to='/transactions'>
            <Text>All Transactions</Text>
          </ChakraLink>
          <ChakraLink as={ReactRouterLink} to='/add-transaction'>
            <Button>
              <AddIcon mr={6} boxSize={16} /> <Text>Add transaction</Text>
            </Button>
          </ChakraLink>
        </Flex>
      </Flex>
    </Box>
  )
}

export default Navbar
