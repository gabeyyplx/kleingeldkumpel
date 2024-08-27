import { Heading } from '@chakra-ui/react'
import TransactionForm from '../components/TransactionForm'
import { backendUrl } from '../utils/backend'

const AddTransaction = () => {
  const handleAddTransaction = async (transaction) => {
    const response = await fetch(`${backendUrl}/api/transactions`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
      body: JSON.stringify(transaction),
    })

    if (!response.ok) {
      throw new Error('Failed to add transaction.')
    }
  }

  return (
    <>
      <Heading mb={8}>Add transaction</Heading>
      <TransactionForm onSubmit={handleAddTransaction} />
    </>
  )
}

export default AddTransaction
