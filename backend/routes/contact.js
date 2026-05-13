const { Router } = require('express');
const { v4: uuidv4 } = require('uuid');
const router = Router();

const submissions = [];

router.post('/', (req, res) => {
  const { name, email, company, message, type = 'contact' } = req.body;

  if (!name || !email || !message) {
    return res.status(400).json({ success: false, error: 'name, email, and message are required' });
  }
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    return res.status(400).json({ success: false, error: 'Invalid email address' });
  }

  const entry = {
    id: uuidv4(),
    name: name.trim().slice(0, 120),
    email: email.trim().toLowerCase(),
    company: (company || '').trim().slice(0, 120),
    message: message.trim().slice(0, 2000),
    type,
    createdAt: new Date().toISOString(),
    ip: req.ip,
  };

  submissions.push(entry);
  console.log(`[contact] new submission from ${entry.email}`);

  res.json({ success: true, id: entry.id, message: 'Thanks! We\'ll be in touch within one business day.' });
});

router.get('/', (req, res) => {
  const apiKey = req.headers['x-api-key'];
  if (apiKey !== process.env.ADMIN_KEY) {
    return res.status(401).json({ success: false, error: 'Unauthorized' });
  }
  res.json({ success: true, count: submissions.length, data: submissions });
});

module.exports = router;
