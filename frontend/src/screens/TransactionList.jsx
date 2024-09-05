import React, { useState, useEffect, useRef } from 'react'
import {
  Box,
  Text,
  Spinner,
  Button,
  Alert,
  AlertIcon,
  AlertDialog,
  AlertDialogContent,
  AlertDialogOverlay,
  AlertDialogHeader,
  AlertDialogBody,
  AlertDialogFooter,
  useDisclosure,
} from '@chakra-ui/react'

import TransactionCard from '../components/TransactionCard'
import { backendUrl } from '../utils/backend'

const TransactionsList = () => {
  const [transactions, setTransactions] = useState([])
  const [isLoading, setIsLoading] = useState(true)
  const [error, setError] = useState(null)
  const [selectedTransactionId, setSelectedTransactionId] = useState(null)
  const { isOpen, onOpen, onClose } = useDisclosure()

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
      } catch (err) {
        setError(err.message)
      } finally {
        setIsLoading(false)
      }
    }

    fetchTransactions()
  }, [])

  const handleEdit = (id) => {
    console.log(`Editing: ${id}`)
  }

  const handleDelete = (id) => {
    setSelectedTransactionId(id)
    onOpen()
  }

  const confirmDelete = async () => {
    try {
      const response = await fetch(
        `${backendUrl}/api/transactions/${selectedTransactionId}`,
        {
          method: 'DELETE',
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        }
      )
      if (response.ok) {
        setTransactions(
          transactions.filter(
            (transaction) => transaction.id !== selectedTransactionId
          )
        )
      }
    } catch (error) {
      console.error('Error deleting transaction:', error)
    } finally {
      onClose()
    }
  }

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
          transaction={transaction}
          onEdit={() => handleEdit(transaction.id)}
          onDelete={() => handleDelete(transaction.id)}
        />
      ))}

      <AlertDialog isOpen={isOpen} onClose={onClose}>
        <AlertDialogOverlay>
          <AlertDialogContent>
            <AlertDialogHeader>Delete transaction</AlertDialogHeader>
            <AlertDialogBody>
              Are you sure you want to delete this transaction?
            </AlertDialogBody>
            <AlertDialogFooter>
              <Button onClick={onClose}>Cancel</Button>
              <Button colorScheme='red' onClick={confirmDelete} ml={3}>
                Delete
              </Button>
            </AlertDialogFooter>
          </AlertDialogContent>
        </AlertDialogOverlay>
      </AlertDialog>
    </Box>
  )
}

export default TransactionsList
