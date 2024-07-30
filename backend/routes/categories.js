const express = require('express')
const { Category } = require('../models')

const router = express.Router()

// Create
router.post('/', async (req, res) => {
  try {
    const category = await Category.create(req.body)
    res.status(201).json(category)
  } catch (error) {
    res.status(400).json({ error: error.message })
  }
})

// Read all
router.get('/', async (req, res) => {
  try {
    const categorys = await Category.findAll()
    res.status(200).json(categorys)
  } catch (error) {
    res.status(400).json({ error: error.message })
  }
})

// Read one
router.get('/:id', async (req, res) => {
  try {
    const category = await Category.findByPk(req.params.id)
    if (category) {
      res.status(200).json(category)
    } else {
      res.status(404).json({ error: 'Category not found' })
    }
  } catch (error) {
    res.status(400).json({ error: error.message })
  }
})

// Update
router.put('/:id', async (req, res) => {
  try {
    const category = await Category.findByPk(req.params.id)
    if (category) {
      await category.update(req.body)
      res.status(200).json(category)
    } else {
      res.status(404).json({ error: 'Category not found' })
    }
  } catch (error) {
    res.status(400).json({ error: error.message })
  }
})

// Delete
router.delete('/:id', async (req, res) => {
  try {
    const category = await Category.findByPk(req.params.id)
    if (category) {
      await category.destroy()
      res.status(204).end()
    } else {
      res.status(404).json({ error: 'Category not found' })
    }
  } catch (error) {
    res.status(400).json({ error: error.message })
  }
})

module.exports = router
