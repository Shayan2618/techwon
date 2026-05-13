const { Router } = require('express');
const { v4: uuidv4 } = require('uuid');
const router = Router();

const requests = [];

const SLOTS = [
  '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
  '13:00', '13:30', '14:00', '14:30', '15:00', '15:30',
];

router.get('/slots', (req, res) => {
  const today = new Date();
  const slots = [];
  for (let d = 1; d <= 7; d++) {
    const date = new Date(today);
    date.setDate(today.getDate() + d);
    const day = date.getDay();
    if (day === 0 || day === 6) continue;
    const dateStr = date.toISOString().split('T')[0];
    SLOTS.forEach(time => {
      const booked = requests.some(r => r.date === dateStr && r.time === time);
      slots.push({ date: dateStr, time, available: !booked });
    });
  }
  res.json({ success: true, data: slots });
});

router.post('/book', (req, res) => {
  const { name, email, company, phone, date, time, agents = [] } = req.body;

  if (!name || !email || !date || !time) {
    return res.status(400).json({ success: false, error: 'name, email, date, and time are required' });
  }
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    return res.status(400).json({ success: false, error: 'Invalid email address' });
  }

  const alreadyBooked = requests.some(r => r.date === date && r.time === time);
  if (alreadyBooked) {
    return res.status(409).json({ success: false, error: 'Slot no longer available, please choose another time.' });
  }

  const entry = {
    id: uuidv4(),
    name: name.trim().slice(0, 120),
    email: email.trim().toLowerCase(),
    company: (company || '').trim().slice(0, 120),
    phone: (phone || '').trim().slice(0, 30),
    date,
    time,
    agents: Array.isArray(agents) ? agents.slice(0, 5) : [],
    status: 'confirmed',
    createdAt: new Date().toISOString(),
  };

  requests.push(entry);
  console.log(`[demo] booked: ${entry.email} on ${entry.date} at ${entry.time}`);

  res.json({
    success: true,
    id: entry.id,
    message: `Demo confirmed for ${date} at ${time}. Calendar invite coming shortly.`,
    booking: { date, time, id: entry.id },
  });
});

module.exports = router;
