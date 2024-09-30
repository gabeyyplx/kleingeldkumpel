import { render, screen } from '@testing-library/react'
import TransactionCard from '../../src/components/TransactionCard'
import { ChakraProvider } from '@chakra-ui/react'
import { MemoryRouter } from 'react-router-dom'
import React from 'react'

const transaction = {
  id: 1,
  name: 'Aldi (goated)',
  value: -100,
  Category: {
    symbol: '🛒',
    name: 'Groceries',
  },
  timestamp: new Date().toISOString(),
}

describe('Transaction Card', () => {
  it('displays transaction data in the card', () => {
    render(
      <ChakraProvider>
        <MemoryRouter>
          <TransactionCard transaction={transaction} />
        </MemoryRouter>
      </ChakraProvider>
    )
    expect(screen.getByText('Aldi (goated)')).toBeInTheDocument()
    expect(screen.getByText('-100')).toBeInTheDocument()
    expect(screen.getByText('🛒 Groceries')).toBeInTheDocument()
  })
})
