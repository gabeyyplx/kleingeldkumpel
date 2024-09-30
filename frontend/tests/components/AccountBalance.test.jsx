import { render, screen } from '@testing-library/react'
import { ChakraProvider } from '@chakra-ui/react'
import { MemoryRouter, Routes } from 'react-router-dom'
import React from 'react'
import AccountBalance from '../../src/components/AccountBalance'

const balance = 9001

describe('Account balance', () => {
  it('displays the account balance', () => {
    render(
      <ChakraProvider>
        <MemoryRouter>
          <AccountBalance balance={balance} />
        </MemoryRouter>
      </ChakraProvider>
    )
    expect(screen.getByText('9001.00 €')).toBeInTheDocument()
  })
})
