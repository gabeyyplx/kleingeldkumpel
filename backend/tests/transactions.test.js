require('dotenv').config()

const request = require('supertest')
const express = require('express')
const sequelize = require('../utils/database')
const routes = require('../routes')
const { Account, Transaction } = require('../models')

const app = express()
app.use(express.json())
app.use('/api', routes)

let accountId
beforeAll(async () => {
  await sequelize.sync({ force: true })

  const userResponse = await request(app).post('/api/users/register').send({
    name: 'testuser',
    password: 'testpassword',
  })
  const userId = userResponse.body.id

  const account = await Account.create({
    name: 'Test',
    balance: 9000,
    UserId: userId,
  })
  accountId = account.id
})

afterAll(async () => {
  await sequelize.close()
})

describe('Transaction Endpoints', () => {
  let token

  beforeEach(async () => {
    const res = await request(app).post('/api/users/login').send({
      name: 'testuser',
      password: 'testpassword',
    })
    token = res.body.token
  })

  it('should create a new transaction', async () => {
    const res = await request(app)
      .post('/api/transactions')
      .set('Authorization', `Bearer ${token}`)
      .send({
        name: 'Groceries',
        value: 100,
        recurrenceFrequency: null,
        AccountId: accountId,
      })
    expect(res.statusCode).toEqual(201)
    expect(res.body).toHaveProperty('name', 'Groceries')
  })

  it('should fetch recurring transactions', async () => {
    await Transaction.create({
      name: 'Tipping the landlord',
      value: 1337,
      recurrenceFrequency: 1,
      AccountId: accountId,
    })
    const res = await request(app)
      .get('/api/transactions/recurring')
      .set('Authorization', `Bearer ${token}`)
    expect(res.statusCode).toEqual(200)
    expect(res.body).toHaveLength(1)
  })

  it('should fetch transactions by date range', async () => {
    await Transaction.create({
      name: 'Buying the right stocks',
      value: 9000,
      AccountId: accountId,
      timestamp: new Date('2000-01-01'),
    })
    const res = await request(app)
      .get('/api/transactions/date/1999-12-31/2000-01-02')
      .set('Authorization', `Bearer ${token}`)
    expect(res.statusCode).toEqual(200)
    expect(res.body).toHaveLength(1)
  })

  it('should fetch all transactions', async () => {
    const res = await request(app)
      .get('/api/transactions')
      .set('Authorization', `Bearer ${token}`)
    expect(res.statusCode).toEqual(200)
    expect(res.body).not.toHaveLength(0)
  })

  it('should fetch the first transaction', async () => {
    const res = await request(app)
      .get('/api/transactions/1')
      .set('Authorization', `Bearer ${token}`)
    expect(res.statusCode).toEqual(200)
    expect(res.body).toHaveProperty('name', 'Groceries')
  })
})
