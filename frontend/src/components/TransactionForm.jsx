import {
  Box,
  Button,
  FormControl,
  FormLabel,
  Input,
  Switch,
} from '@chakra-ui/react'
import { useState } from 'react'

function TransactionForm({ onSubmit }) {
  const [name, setName] = useState('')
  const [amount, setAmount] = useState('')
  const [isExpense, setIsExpense] = useState(true) // Default to expense

  const handleSubmit = (e) => {
    e.preventDefault()
    const finalAmount = isExpense ? -Math.abs(amount) : Math.abs(amount)
    onSubmit({
      name: name,
      value: finalAmount,
      AccountId: 1,
    })
  }

  return (
    <Box as='form' onSubmit={handleSubmit}>
      <FormControl mb={4}>
        <FormLabel>Transaction name</FormLabel>
        <Input
          type='text'
          value={name}
          onChange={(e) => setName(e.target.value)}
        />
      </FormControl>
      <FormControl display='flex' alignItems='center' mb={4}>
        <FormLabel htmlFor='isExpense' mb='0'>
          {isExpense ? 'Expense' : 'Income'}
        </FormLabel>
        <Switch
          id='isExpense'
          colorScheme={isExpense ? 'red' : 'green'}
          isChecked={isExpense}
          onChange={() => setIsExpense(!isExpense)}
        />
      </FormControl>

      <FormControl id='amount' isRequired>
        <FormLabel>Amount</FormLabel>
        <Input
          type='number'
          value={amount}
          onChange={(e) => setAmount(e.target.value)}
          placeholder='Enter amount'
          step='0.01'
        />
      </FormControl>

      <Button mt={4} colorScheme={isExpense ? 'red' : 'green'} type='submit'>
        {isExpense ? 'Add Expense' : 'Add Income'}
      </Button>
    </Box>
  )
}

export default TransactionForm
