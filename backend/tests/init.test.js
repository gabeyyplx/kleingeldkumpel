require('dotenv').config()

const request = require('supertest')
const express = require('express')
const sequelize = require('../utils/database')
const routes = require('../routes')
const initialize = require('../utils/init')

const app = express()
app.use(express.json())
app.use('/api', routes)

let token
beforeAll(async () => {
  await sequelize.sync({ force: true })
  await initialize()
})

afterAll(async () => {
  await sequelize.close()
})

describe('Initialization', () => {
  it('should have created a user', async () => {
    const res = await request(app).post('/api/users/login').send({
      name: 'user',
      password: 'changeme',
    })
    expect(res.statusCode).toEqual(200)
    expect(res.body).toHaveProperty('token')
    token = res.body.token
  })

  it('should find the default account', async () => {
    const res = await request(app)
      .get('/api/accounts/')
      .set('Authorization', `Bearer ${token}`)
    expect(res.statusCode).toEqual(200)
    expect(res.body).toHaveLength(1)
  })
})
