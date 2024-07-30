const express = require('express')
const authenticate = require('../utils/auth')
const userRoutes = require('./users')
const accountRoutes = require('./accounts')
const transactionRoutes = require('./transactions')
const categoryRoutes = require('./categories')

const router = express.Router()

router.use('/users', userRoutes)
router.use('/accounts', authenticate, accountRoutes)
router.use('/transactions', authenticate, transactionRoutes)
router.use('/categories', authenticate, categoryRoutes)

module.exports = router
