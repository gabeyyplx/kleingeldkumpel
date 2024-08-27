const express = require('express')
const { Transaction, Account, Category } = require('../models')
const authenticate = require('../utils/auth')
const { Op } = require('sequelize')

const router = express.Router()

// Create
router.post('/', authenticate, async (req, res) => {
  try {
    const account = await Account.findByPk(req.body.AccountId)
    if (!account || account.UserId !== req.user.id) {
      return res.status(403).json({ error: 'Access denied' })
    }
    const transaction = await Transaction.create(req.body)
    res.status(201).json(transaction)
  } catch (error) {
    res.status(400).json({ error: error.message })
  }
})

// Read all
router.get('/', authenticate, async (req, res) => {
  try {
    const transactions = await Transaction.findAll({
      include: [Account, Category],
    })
    res.status(200).json(transactions)
  } catch (error) {
    res.status(400).json({ error: error.message })
  }
})

// Read by date range
router.get('/date/:startDate/:endDate', authenticate, async (req, res) => {
  try {
    const { startDate, endDate } = req.params
    const transactions = await Transaction.findAll({
      include: {
        model: Account,
        where: { UserId: req.user.id },
      },
      where: {
        timestamp: {
          [Op.between]: [new Date(startDate), new Date(endDate)],
        },
      },
    })
    res.status(200).json(transactions)
  } catch (error) {
    res.status(400).json({ error: error.message })
  }
})

// Get recurring transactions
router.get('/recurring', authenticate, async (req, res) => {
  try {
    const transactions = await Transaction.findAll({
      include: {
        model: Account,
        where: { UserId: req.user.id },
      },
      where: {
        recurrenceFrequency: {
          [Op.not]: null,
        },
      },
    })
    res.status(200).json(transactions)
  } catch (error) {
    res.status(400).json({ error: error.message })
  }
})

// Read one
router.get('/:id', authenticate, async (req, res) => {
  try {
    const transaction = await Transaction.findOne({
      where: { id: req.params.id },
      include: {
        model: Account,
        where: { UserId: req.user.id },
      },
    })
    if (transaction) {
      res.status(200).json(transaction)
    } else {
      res.status(404).json({ error: 'Transaction not found' })
    }
  } catch (error) {
    res.status(400).json({ error: error.message })
  }
})

// Update
router.put('/:id', authenticate, async (req, res) => {
  try {
    const transaction = await Transaction.findOne({
      where: { id: req.params.id },
      include: {
        model: Account,
        where: { UserId: req.user.id },
      },
    })
    if (transaction) {
      await transaction.update(req.body)
      res.status(200).json(transaction)
    } else {
      res.status(404).json({ error: 'Transaction not found' })
    }
  } catch (error) {
    res.status(400).json({ error: error.message })
  }
})

// Delete
router.delete('/:id', authenticate, async (req, res) => {
  try {
    const transaction = await Transaction.findOne({
      where: { id: req.params.id },
      include: {
        model: Account,
        where: { UserId: req.user.id },
      },
    })
    if (transaction) {
      await transaction.destroy()
      res.status(204).end()
    } else {
      res.status(404).json({ error: 'Transaction not found' })
    }
  } catch (error) {
    res.status(400).json({ error: error.message })
  }
})

module.exports = router
