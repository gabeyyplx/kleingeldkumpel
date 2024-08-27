import { Box, Button, Flex, Text, Badge } from '@chakra-ui/react'
import { EditIcon, DeleteIcon } from '@chakra-ui/icons'

const TransactionCard = ({ title, amount, category, onEdit, onDelete }) => {
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
            {title}
          </Text>
          <Text fontSize='2xl' color={amount < 0 ? 'red.500' : 'green.500'}>
            {amount < 0 ? `-${Math.abs(amount)}` : `${amount}`}
          </Text>
          <Badge mt={2} colorScheme='purple'>
            {category.symbol} {category.name}
          </Badge>
        </Box>
        <Flex direction='column' justify='space-between'>
          <Button
            onClick={onEdit}
            size='sm'
            colorScheme='blue'
            leftIcon={<EditIcon />}
            mb={2}
          >
            Edit
          </Button>
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
