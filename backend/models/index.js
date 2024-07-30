const sequelize = require('../utils/database')
const User = require('./user')
const Account = require('./account')
const Transaction = require('./transaction')
const Category = require('./category')

sequelize.sync()

module.exports = {
  User,
  Account,
  Transaction,
  Category,
}
