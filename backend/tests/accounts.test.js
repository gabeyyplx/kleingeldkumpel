require('dotenv').config() // Lade die Umgebungsvariablen aus .env

const request = require('supertest')
const express = require('express')
const sequelize = require('../utils/database')
const routes = require('../routes')

const app = express()
app.use(express.json())
app.use('/api', routes)

beforeAll(async () => {
  await sequelize.sync({ force: true })

  await request(app).post('/api/users/register').send({
    name: 'testuser',
    password: 'testpassword',
  })
})

afterAll(async () => {
  await sequelize.close()
})

describe('Account Endpoints', () => {
  let token

  beforeEach(async () => {
    const res = await request(app).post('/api/users/login').send({
      name: 'testuser',
      password: 'testpassword',
    })
    token = res.body.token
  })

  it('should create a new account', async () => {
    const res = await request(app)
      .post('/api/accounts')
      .set('Authorization', `Bearer ${token}`)
      .send({
        name: 'Main Account',
        balance: 1000,
        UserId: 1,
      })
    expect(res.statusCode).toEqual(201)
    expect(res.body).toHaveProperty('name', 'Main Account')
  })

  it('should fetch all accounts', async () => {
    const res = await request(app)
      .get('/api/accounts')
      .set('Authorization', `Bearer ${token}`)
    expect(res.statusCode).toEqual(200)
    expect(res.body).toHaveLength(1)
  })

  it('should fetch the first account', async () => {
    const res = await request(app)
      .get('/api/accounts/1')
      .set('Authorization', `Bearer ${token}`)
    expect(res.statusCode).toEqual(200)
    expect(res.body).toHaveProperty('name', 'Main Account')
  })
})
