import { Heading, Spinner } from '@chakra-ui/react'
import TransactionForm from '../components/TransactionForm'
import { backendUrl } from '../utils/backend'
import { useToast } from '@chakra-ui/react'
import { useState, useEffect } from 'react'
import { useParams } from 'react-router-dom'

const EditTransaction = () => {
  const { id } = useParams()
  const toast = useToast()
  const [transaction, setTransaction] = useState(null)
  const [isLoading, setIsLoading] = useState(true)

  useEffect(() => {
    const fetchTransaction = async () => {
      try {
        const response = await fetch(`${backendUrl}/api/transactions/${id}`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        })
        if (!response.ok) {
          toast({
            title: 'Error',
            description: 'Error while fetching transaction',
            status: 'error',
          })
        } else {
          const data = await response.json()
          setTransaction(data)
          setIsLoading(false)
        }
      } catch (error) {
        toast({
          title: 'Error',
          description: error.message,
          status: 'error',
        })
      }
    }
    fetchTransaction()
  }, [])

  const handleEditTransaction = async (transaction) => {
    try {
      const response = await fetch(`${backendUrl}/api/transactions/${id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          Authorization: `Bearer ${localStorage.getItem('token')}`,
        },
        body: JSON.stringify(transaction),
      })
      if (!response.ok) {
        toast({
          title: 'Error',
          description: 'Error while updating transaction',
          status: 'error',
        })
      } else {
        toast({
          title: 'Transaction was updated successfully',
          status: 'success',
        })
      }
    } catch (error) {
      toast({
        title: 'Error',
        description: error.message,
        status: 'error',
      })
    }
  }

  if (isLoading) {
    return <Spinner />
  }

  return (
    <>
      <Heading mb={8}>Edit transaction</Heading>
      <TransactionForm
        transaction={transaction}
        onSubmit={handleEditTransaction}
      />
    </>
  )
}

export default EditTransaction
