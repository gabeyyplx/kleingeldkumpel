import { useEffect, useState } from 'react'
import { Center, Container, Spinner, Stack } from '@chakra-ui/react'
import AccountBalance from '../components/AccountBalance'
import { backendUrl, getAuthToken } from '../utils/auth'

function Dashboard() {
  const [account, setAccount] = useState(null)

  useEffect(() => {
    const fetchAccount = async () => {
      try {
        const response = await fetch(`${backendUrl}/api/accounts/1`, {
          method: 'GET',
          headers: {
            'Content-Type': 'application/json',
            Authorization: `Bearer ${await getAuthToken()}`,
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
    <AccountBalance balance={account.balance} />
  )

  return (
    <Center w='100vw' h='100vh' p={3}>
      <Container>
        <Stack>{DashboardContent}</Stack>
      </Container>
    </Center>
  )
}
export default Dashboard
