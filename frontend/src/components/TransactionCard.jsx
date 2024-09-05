import {
  Box,
  Button,
  Flex,
  Text,
  Badge,
  Link as ChakraLink,
} from '@chakra-ui/react'
import { Link as ReactRouterLink } from 'react-router-dom'
import { EditIcon, DeleteIcon } from '@chakra-ui/icons'

const TransactionCard = ({ transaction, onEdit, onDelete }) => {
  let badge = null
  if (transaction.Category) {
    badge = (
      <Badge mt={2} colorScheme='purple'>
        {transaction.Category.symbol} {transaction.Category.name}
      </Badge>
    )
  }
  return (
    <Box
      borderWidth='1px'
      borderRadius='lg'
      overflow='hidden'
      p={4}
      mb={4}
      boxShadow='md'
    >
      <Flex justify='space-between' align='center'>
        <Box>
          <Text fontSize='lg' fontWeight='bold'>
            {transaction.name}
          </Text>
          <Text
            fontSize='2xl'
            color={transaction.value < 0 ? 'red.500' : 'green.500'}
          >
            {transaction.value < 0
              ? `-${Math.abs(transaction.value)}`
              : `+${transaction.value}`}
          </Text>
          {badge}
          <Text fontSize='sm'>
            {new Date(transaction.timestamp).toLocaleString('de-DE', {
              dateStyle: 'medium',
              timeStyle: 'medium',
            })}
          </Text>
        </Box>
        <Flex direction='column' justify='space-between'>
          <ChakraLink
            as={ReactRouterLink}
            to={`/edit-transaction/${transaction.id}`}
          >
            <Button
              onClick={onEdit}
              size='sm'
              colorScheme='blue'
              leftIcon={<EditIcon />}
              mb={2}
            >
              Edit
            </Button>
          </ChakraLink>
          <Button
            onClick={onDelete}
            size='sm'
            colorScheme='red'
            leftIcon={<DeleteIcon />}
          >
            Delete
          </Button>
        </Flex>
      </Flex>
    </Box>
  )
}

export default TransactionCard
