import { useEffect, useState } from 'react'
import { Spinner, Stack, Heading } from '@chakra-ui/react'
import AccountBalance from '../components/AccountBalance'
import { getAuthToken } from '../utils/auth'
import { backendUrl } from '../utils/backend'

function Dashboard() {
  const [account, setAccount] = useState(null)

  useEffect(() => {
    const fetchAccount = async () => {
      try {
        const response = await fetch(`${backendUrl}/api/accounts/1`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            Authorization: `Bearer ${getAuthToken()}`,
          },
        })
        const body = await response.json()
        setAccount(body)
      } catch (error) {
        console.log('Error trying to fetch account:' + error)
      }
    }
    fetchAccount()
  }, [])

  const DashboardContent = !account ? (
    <Spinner size='xl' />
  ) : (
    <>
      <Heading mb={6}>Dashboard</Heading>
      <AccountBalance balance={account.balance} />
    </>
  )

  return <Stack>{DashboardContent}</Stack>
}
export default Dashboard
