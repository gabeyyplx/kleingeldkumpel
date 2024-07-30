const { DataTypes } = require('sequelize')
const sequelize = require('../utils/database')
const Account = require('./account')
const Category = require('./category')

const Transaction = sequelize.define('Transaction', {
  name: {
    type: DataTypes.STRING,
    allowNull: false,
  },
  value: {
    type: DataTypes.FLOAT,
    allowNull: false,
  },
  recurrenceFrequency: {
    type: DataTypes.INTEGER,
    allowNull: true,
    defaultValue: null,
  },
  timestamp: {
    type: DataTypes.DATE,
    defaultValue: DataTypes.NOW,
  },
})

Account.hasMany(Transaction, { as: 'Transactions' })
Transaction.belongsTo(Account)

Category.hasMany(Transaction, { as: 'Transactions' })
Transaction.belongsTo(Category)

module.exports = Transaction
