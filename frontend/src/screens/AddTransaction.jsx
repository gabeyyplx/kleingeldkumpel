import { Heading } from '@chakra-ui/react'
import TransactionForm from '../components/TransactionForm'
import { backendUrl } from '../utils/backend'
import { useToast } from '@chakra-ui/react'
import { useState } from 'react'

const AddTransaction = () => {
  const [formSubmissions, setFormSubmissions] = useState(0) // To reset form on successful submission via key attribute
  const toast = useToast()
  const handleAddTransaction = async (transaction) => {
    try {
      const response = await fetch(`${backendUrl}/api/transactions`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Authorization: `Bearer ${localStorage.getItem('token')}`,
        },
        body: JSON.stringify(transaction),
      })
      if (!response.ok) {
        toast({
          title: 'Error',
          description: 'Error while adding transaction',
          status: 'error',
        })
      } else {
        toast({
          title: 'Transaction was added successfully',
          status: 'success',
        })
        setFormSubmissions(formSubmissions + 1)
      }
    } catch (error) {
      toast({
        title: 'Error',
        description: error.message,
        status: 'error',
      })
    }
  }

  return (
    <>
      <Heading mb={8}>Add transaction</Heading>
      <TransactionForm key={formSubmissions} onSubmit={handleAddTransaction} />
    </>
  )
}

export default AddTransaction
