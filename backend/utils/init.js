const argon2 = require('argon2')
const { User, Account } = require('../models')

async function createDefaultUserAndAccount() {
  try {
    let userId

    const userCount = await User.count()
    if (userCount === 0) {
      const hashedPassword = await argon2.hash('changeme')
      const user = await User.create({
        name: 'user',
        password: hashedPassword,
      })
      userId = user.id
      console.log('Default user created')
    } else {
      console.log(
        `${userCount} user(s) found, skipping creation of default user`
      )
    }

    const accountCondition = userId ? { where: { UserId: userId } } : null // Check if user has an account or if there are any accounts at all
    const accountCount = await Account.count(accountCondition)
    if (accountCount === 0) {
      await Account.create({ name: 'Account', balance: 0, UserId: userId })
      console.log('Default account created.')
    } else {
      console.log('Valid account found, skipping creation of default account')
    }
  } catch (error) {
    console.error('Error creating default user and account:', error)
  }
}

const initFunctions = [createDefaultUserAndAccount]

async function initialize() {
  for (const initFunction of initFunctions) {
    await initFunction()
  }
}

module.exports = initialize
