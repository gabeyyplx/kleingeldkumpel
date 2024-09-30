import { render, screen, fireEvent } from '@testing-library/react'
import TransactionForm from '../../src/components/TransactionForm'
import { ChakraProvider } from '@chakra-ui/react'
import { MemoryRouter } from 'react-router-dom'
import React from 'react'
import { expect } from 'vitest'

describe('Transaction Form', () => {
  it('renders', () => {
    render(
      <ChakraProvider>
        <MemoryRouter>
          <TransactionForm />
        </MemoryRouter>
      </ChakraProvider>
    )
    expect(screen.getByText('Transaction name')).toBeInTheDocument()
    expect(screen.getByText('Expense')).toBeInTheDocument()
    expect(screen.getByText('Amount')).toBeInTheDocument()
    expect(screen.getByText('Category')).toBeInTheDocument()
    expect(screen.getByText('Date/Time')).toBeInTheDocument()
  })

  it('submits correct data', () => {
    const mockSubmit = vi.fn()
    render(
      <ChakraProvider>
        <MemoryRouter>
          <TransactionForm
            onSubmit={mockSubmit}
            categories={[{ id: 1, name: 'Groceries', symbol: '🛒' }]}
          />
        </MemoryRouter>
      </ChakraProvider>
    )

    fireEvent.change(screen.getByLabelText(/Transaction name/), {
      target: { value: 'Aldi (still goated)' },
    })
    fireEvent.change(screen.getByLabelText(/Amount/), {
      target: { value: '74.1' },
    })
    fireEvent.change(screen.getByLabelText(/Category/), {
      target: { value: '1' },
    })
    const submitButton = screen.getByRole('button', { name: /Add Expense/ })
    fireEvent.click(submitButton)
    expect(mockSubmit).toHaveBeenCalled()
  })
})
