const express = require('express')
const { Account } = require('../models')
const authenticate = require('../utils/auth')
const router = express.Router()

// Create
router.post('/', authenticate, async (req, res) => {
  try {
    const accountData = {
      ...req.body,
      UserId: req.user.id,
    }
    const item = await Account.create(accountData)
    res.status(201).json(item)
  } catch (error) {
    res.status(400).json({ error: error.message })
  }
})

// Read all
router.get('/', authenticate, async (req, res) => {
  try {
    const items = await Account.findAll({ where: { UserId: req.user.id } })
    res.status(200).json(items)
  } catch (error) {
    res.status(400).json({ error: error.message })
  }
})

// Read one
router.get('/:id', authenticate, async (req, res) => {
  try {
    const item = await Account.findOne({
      where: {
        id: req.params.id,
        UserId: req.user.id,
      },
    })
    if (item) {
      res.status(200).json(item)
    } else {
      res.status(404).json({ error: 'Account not found' })
    }
  } catch (error) {
    res.status(400).json({ error: error.message })
  }
})

// Update
router.put('/:id', authenticate, async (req, res) => {
  try {
    const item = await Account.findOne({
      where: {
        id: req.params.id,
        UserId: req.user.id,
      },
    })
    if (item) {
      await item.update(req.body)
      res.status(200).json(item)
    } else {
      res.status(404).json({ error: 'Account not found' })
    }
  } catch (error) {
    res.status(400).json({ error: error.message })
  }
})

// Delete
router.delete('/:id', authenticate, async (req, res) => {
  try {
    const item = await Account.findOne({
      where: {
        id: req.params.id,
        UserId: req.user.id,
      },
    })
    if (item) {
      await item.destroy()
      res.status(204).end()
    } else {
      res.status(404).json({ error: 'Account not found' })
    }
  } catch (error) {
    res.status(400).json({ error: error.message })
  }
})

module.exports = router
