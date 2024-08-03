import { Stat, StatLabel, StatNumber } from '@chakra-ui/react'

const AccountBalance = ({ balance }) => {
  return (
    <Stat boxShadow='base' p={3} borderRadius={10}>
      <StatLabel>Current account balance</StatLabel>
      <StatNumber>{balance} €</StatNumber>
    </Stat>
  )
}

export default AccountBalance
