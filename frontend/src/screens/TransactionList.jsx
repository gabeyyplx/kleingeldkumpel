import React, { useState, useEffect } from 'react'
import { Box, Text, Spinner, Alert, AlertIcon } from '@chakra-ui/react'
import TransactionCard from '../components/TransactionCard'
import { backendUrl } from '../utils/backend'

const TransactionsList = () => {
  const [transactions, setTransactions] = useState([])
  const [isLoading, setIsLoading] = useState(true)
  const [error, setError] = useState(null)

  useEffect(() => {
    const fetchTransactions = async () => {
      try {
        const response = await fetch(`${backendUrl}/api/transactions`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        })

        if (!response.ok) {
          throw new Error('Error while fetching transactions')
        }

        const data = await response.json()
        setTransactions(data)
        console.log(data)
      } catch (err) {
        setError(err.message)
      } finally {
        setIsLoading(false)
      }
    }

    fetchTransactions()
  }, [])

  if (isLoading) {
    return <Spinner size='xl' color='blue.500' />
  }

  if (error) {
    return (
      <Alert status='error'>
        <AlertIcon />
        {error}
      </Alert>
    )
  }

  if (transactions.length === 0) {
    return <Text>No transactions found</Text>
  }

  return (
    <Box>
      {transactions.map((transaction) => (
        <TransactionCard
          key={transaction.id}
          title={transaction.name}
          amount={transaction.value}
          category={transaction.Category}
          onEdit={() => handleEdit(transaction.id)}
          onDelete={() => handleDelete(transaction.id)}
        />
      ))}
    </Box>
  )
}

const handleEdit = (id) => {
  console.log(`Editing: ${id}`)
}

const handleDelete = (id) => {
  console.log(`Deleting: ${id}`)
}

export default TransactionsList
