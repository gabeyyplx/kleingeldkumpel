const jwt = require('jsonwebtoken')
const { User } = require('../models')

const secret = process.env.JWT_SECRET

const authenticate = async (req, res, next) => {
  const authHeader = req.headers['authorization']
  const token = authHeader && authHeader.split(' ')[1]

  if (!token) {
    return res.sendStatus(401)
  }

  try {
    const decoded = jwt.verify(token, secret)
    req.user = await User.findByPk(decoded.userId)
    if (!req.user) {
      return res.sendStatus(401)
    }
    next()
  } catch (error) {
    res.sendStatus(403)
  }
}

module.exports = authenticate
