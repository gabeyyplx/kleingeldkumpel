const express = require('express')
const argon2 = require('argon2')
const jwt = require('jsonwebtoken')
const { User } = require('../models')
const router = express.Router()

const secret = process.env.JWT_SECRET

router.post('/register', async (req, res) => {
  try {
    const { name, password } = req.body
    const hashedPassword = await argon2.hash(password)
    const user = await User.create({ name, password: hashedPassword })
    res.status(201).json({ name: user.name, id: user.id })
  } catch (error) {
    res.status(400).json({ error: error.message })
  }
})

router.post('/login', async (req, res) => {
  const { name, password } = req.body
  try {
    const user = await User.findOne({ where: { name } })
    if (!user) {
      return res.status(401).json({ error: 'Invalid credentials' })
    }
    const isPasswordValid = await argon2.verify(user.password, password)
    if (!isPasswordValid) {
      return res.status(401).json({ error: 'Invalid credentials' })
    }
    const token = jwt.sign({ userId: user.id }, secret, { expiresIn: '1h' })
    res.status(200).json({ token })
  } catch (error) {
    res.status(500).json({ error: error.message })
  }
})

module.exports = router
