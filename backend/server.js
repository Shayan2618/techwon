require('dotenv').config();
const express = require('express');
const cors = require('cors');
const helmet = require('helmet');
const rateLimit = require('express-rate-limit');
const path = require('path');

const agentsRouter = require('./routes/agents');
const contactRouter = require('./routes/contact');
const demoRouter = require('./routes/demo');
const newsletterRouter = require('./routes/newsletter');

const app = express();
const PORT = process.env.PORT || 3001;

app.set('trust proxy', 1);

app.use(helmet({
  contentSecurityPolicy: false,
  crossOriginResourcePolicy: false,
}));

app.use(cors({
  origin: [
    process.env.FRONTEND_URL || 'http://localhost:3002',
    'https://techwon.co',
    'https://www.techwon.co',
    'http://techwon.co',
    'http://www.techwon.co',
    'http://localhost:3002',
    'http://127.0.0.1:3002',
    'http://localhost:3001',
    'http://127.0.0.1:3001',
    'http://localhost:3000',
    'http://127.0.0.1:3000',
    'http://localhost:5500',
    'http://127.0.0.1:5500',
  ],
  credentials: true,
}));

app.use(express.json({ limit: '10kb' }));
app.use(express.urlencoded({ extended: true, limit: '10kb' }));

const apiLimiter = rateLimit({
  windowMs: 15 * 60 * 1000,
  max: 100,
  standardHeaders: true,
  legacyHeaders: false,
  message: { success: false, error: 'Too many requests, please try again later.' },
});

const formLimiter = rateLimit({
  windowMs: 60 * 60 * 1000,
  max: 10,
  standardHeaders: true,
  legacyHeaders: false,
  message: { success: false, error: 'Submission limit reached. Please wait an hour.' },
});

app.use('/api', apiLimiter);

app.use('/api/agents', agentsRouter);
app.use('/api/contact', formLimiter, contactRouter);
app.use('/api/demo', formLimiter, demoRouter);
app.use('/api/newsletter', formLimiter, newsletterRouter);

app.get('/api/health', (req, res) => {
  res.json({
    success: true,
    status: 'online',
    timestamp: new Date().toISOString(),
    version: '1.0.0',
    agents: 5,
  });
});

const frontendPath = path.join(__dirname, '../frontend');
app.use(express.static(frontendPath));

app.get('*', (req, res) => {
  res.sendFile(path.join(frontendPath, 'index.html'));
});

app.use((err, req, res, _next) => {
  console.error('[error]', err.message);
  res.status(500).json({ success: false, error: 'Internal server error' });
});

app.listen(PORT, () => {
  console.log(`\n🚀 TechWon API running on http://localhost:${PORT}`);
  console.log(`   Frontend served at http://localhost:${PORT}`);
  console.log(`   API health:   http://localhost:${PORT}/api/health`);
  console.log(`   Agents:       http://localhost:${PORT}/api/agents\n`);
});
