require('dotenv').config()

const express = require('express')
const initialize = require('./utils/init')
const cors = require('cors')
const routes = require('./routes/index')

const app = express()
const port = process.env.PORT || 3000

app.use(cors())
app.use(express.json())
app.use('/api', routes)

const main = async () => {
  await initialize()
  app.listen(port, () => {
    console.log(`Server is running on port ${port}`)
  })
}

main()
