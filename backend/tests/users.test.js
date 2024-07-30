require('dotenv').config()

const request = require('supertest')
const express = require('express')
const sequelize = require('../utils/database')
const routes = require('../routes')

const app = express()
app.use(express.json())
app.use('/api', routes)

beforeAll(async () => {
  await sequelize.sync({ force: true })
})

afterAll(async () => {
  await sequelize.close()
})

describe('User Endpoints', () => {
  it('should register a new user', async () => {
    const res = await request(app).post('/api/users/register').send({
      name: 'testuser',
      password: 'testpassword',
    })
    expect(res.statusCode).toEqual(201)
    expect(res.body).toHaveProperty('name', 'testuser')
  })

  it('should login an existing user', async () => {
    const res = await request(app).post('/api/users/login').send({
      name: 'testuser',
      password: 'testpassword',
    })
    expect(res.statusCode).toEqual(200)
    expect(res.body).toHaveProperty('token')
  })

  it('should fail login with incorrect credentials', async () => {
    const res = await request(app).post('/api/users/login').send({
      name: 'testuser',
      password: 'wrongpassword',
    })
    expect(res.statusCode).toEqual(401)
  })
})
