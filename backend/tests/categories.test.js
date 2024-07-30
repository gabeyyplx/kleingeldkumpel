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

  await request(app).post('/api/users/register').send({
    name: 'testuser',
    password: 'testpassword',
  })
})

afterAll(async () => {
  await sequelize.close()
})

describe('Category Endpoints', () => {
  let token

  beforeEach(async () => {
    const res = await request(app).post('/api/users/login').send({
      name: 'testuser',
      password: 'testpassword',
    })
    token = res.body.token
  })

  it('should create a new category', async () => {
    const res = await request(app)
      .post('/api/categories')
      .set('Authorization', `Bearer ${token}`)
      .send({
        name: 'Food',
        symbol: '🍔',
      })
    expect(res.statusCode).toEqual(201)
    expect(res.body).toHaveProperty('name', 'Food')
  })

  it('should fetch all categories', async () => {
    const res = await request(app)
      .get('/api/categories')
      .set('Authorization', `Bearer ${token}`)
    expect(res.statusCode).toEqual(200)
    expect(res.body).toHaveLength(1)
  })

  it('should fetch the first category', async () => {
    const res = await request(app)
      .get('/api/categories/1')
      .set('Authorization', `Bearer ${token}`)
    expect(res.statusCode).toEqual(200)
    expect(res.body).toHaveProperty('symbol', '🍔')
  })
})
