const { DataTypes } = require('sequelize')
const sequelize = require('../utils/database')
const User = require('./user')

const Account = sequelize.define('Account', {
  name: {
    type: DataTypes.STRING,
    allowNull: false,
  },
  balance: {
    type: DataTypes.FLOAT,
    allowNull: false,
  },
})

User.hasMany(Account, { as: 'Accounts' })
Account.belongsTo(User)

module.exports = Account
