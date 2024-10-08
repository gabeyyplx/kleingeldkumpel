import {
  Box,
  Button,
  FormControl,
  FormLabel,
  Input,
  Select,
  Switch,
} from '@chakra-ui/react'
import { useState, useEffect } from 'react'
import { backendUrl } from '../utils/backend'

const TransactionForm = ({ onSubmit, transaction, categories }) => {
  const [name, setName] = useState('')
  const [amount, setAmount] = useState('')
  const [category, setCategory] = useState(0) // Otherwise Chakra gets angery
  const [date, setDate] = useState(new Date().toISOString().slice(0, 10))
  const [categoriesLoaded, setCategoriesLoaded] = useState(false)
  const [isExpense, setIsExpense] = useState(true) // Default to expense
  const [availableCategories, setAvailableCategories] = useState([])

  useEffect(() => {
    if (transaction && categoriesLoaded) {
      setName(transaction.name)
      setAmount(transaction.value)
      setIsExpense(transaction.value < 0)
      setCategory(transaction.CategoryId)
      setDate(new Date().toISOString().slice(0, 10))
    }
  }, [transaction, categoriesLoaded])

  useEffect(() => {
    if (categories) {
      setAvailableCategories(categories)
      setCategoriesLoaded(true)
      return
    }

    const fetchCategories = async () => {
      try {
        const response = await fetch(`${backendUrl}/api/categories`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        })
        if (!response.ok) {
          throw new Error('Error while fetching categories')
        }
        const data = await response.json()
        setAvailableCategories(data)
        setCategoriesLoaded(true)
      } catch (error) {
        console.log(`Error while fetching categories: ${error.messages}`)
      }
    }
    fetchCategories()
  }, [])

  const handleSubmit = (e) => {
    e.preventDefault()
    const finalAmount = isExpense ? -Math.abs(amount) : Math.abs(amount)
    onSubmit({
      name: name,
      value: finalAmount,
      timestamp: date,
      AccountId: 1,
      CategoryId: category,
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

      <FormControl mb={4} id='amount' isRequired>
        <FormLabel>Amount</FormLabel>
        <Input
          type='number'
          value={amount}
          onChange={(e) => setAmount(e.target.value)}
          placeholder='Enter amount'
          step='0.01'
        />
      </FormControl>

      <FormControl mb={4} id='category' isRequired>
        <FormLabel>Category</FormLabel>
        <Select
          onChange={(e) => setCategory(e.target.value)}
          placeholder='Choose category'
          value={category}
        >
          {availableCategories.map((category) => (
            <option key={category.id} value={category.id}>
              {category.symbol} {category.name}
            </option>
          ))}
        </Select>
      </FormControl>

      <FormControl mb={4} id='timestamp' isRequired>
        <FormLabel>Date/Time</FormLabel>
        <Input
          type='date'
          onChange={(e) => setDate(e.target.value)}
          value={date}
        />
      </FormControl>

      <Button mt={4} colorScheme={isExpense ? 'red' : 'green'} type='submit'>
        {transaction ? 'Update ' : 'Add '}
        {isExpense ? 'Expense' : 'Income'}
      </Button>
    </Box>
  )
}

export default TransactionForm
