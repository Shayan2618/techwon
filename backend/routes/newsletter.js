const { Router } = require('express');
const { v4: uuidv4 } = require('uuid');
const router = Router();

const subscribers = new Map();

router.post('/subscribe', (req, res) => {
  const { email } = req.body;
  if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    return res.status(400).json({ success: false, error: 'Valid email required' });
  }
  const addr = email.trim().toLowerCase();
  if (subscribers.has(addr)) {
    return res.json({ success: true, message: 'You\'re already subscribed!' });
  }
  subscribers.set(addr, { id: uuidv4(), email: addr, subscribedAt: new Date().toISOString() });
  console.log(`[newsletter] new subscriber: ${addr}`);
  res.json({ success: true, message: 'You\'re in! Expect AI insights weekly.' });
});

module.exports = router;
