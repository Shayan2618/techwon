const { Router } = require('express');
const router = Router();

const AGENTS = [
  {
    id: 'ranko',
    name: 'Ranko',
    role: 'SEO Intelligence',
    color: '#4FD2FF',
    description: 'Autonomous SEO agent that tracks rankings, identifies opportunities, and executes optimisations — 24/7.',
    capabilities: ['Keyword rank tracking', 'Competitor gap analysis', 'On-page optimisation', 'Backlink monitoring', 'SERP feature capture'],
    metrics: { keywords_tracked: 3847, avg_rank_improvement: 14.2, traffic_lift: '340%' },
    status: 'active',
  },
  {
    id: 'quill',
    name: 'Quill',
    role: 'Content Engine',
    color: '#7BB8FF',
    description: 'Brand-voice content at scale — blogs, ads, emails, product copy — researched and drafted in minutes.',
    capabilities: ['Long-form blog writing', 'Ad copy & A/B variants', 'Email sequences', 'Product descriptions', 'Social captions'],
    metrics: { pieces_published: 12400, avg_time_saved_hrs: 18, engagement_lift: '2.8×' },
    status: 'active',
  },
  {
    id: 'vega',
    name: 'Vega',
    role: 'Data & Analytics',
    color: '#2D9CFF',
    description: 'Ingests every data source, surfaces anomalies, and delivers board-ready insights before you ask.',
    capabilities: ['Real-time dashboard synthesis', 'Anomaly detection', 'Revenue attribution', 'Funnel analysis', 'Predictive forecasting'],
    metrics: { data_sources: 47, dashboards_auto_built: 320, avg_insight_delay: '< 2 min' },
    status: 'active',
  },
  {
    id: 'iris',
    name: 'Iris',
    role: 'AI Phone Agent',
    color: '#4FD2FF',
    description: 'Handles inbound and outbound calls with human-level conversation — never misses a lead, never sleeps.',
    capabilities: ['Inbound call handling', 'Lead qualification', 'Appointment booking', 'Call transcripts & CRM sync', 'Multilingual support'],
    metrics: { calls_handled: 28900, booking_rate: '67%', avg_handle_time: '3m 12s' },
    status: 'active',
  },
  {
    id: 'otto',
    name: 'Otto',
    role: 'Automotive AI',
    color: '#1E5BD6',
    description: 'Purpose-built for auto dealerships — inventory intelligence, trade-in valuation, and chat-to-finance.',
    capabilities: ['Inventory pricing AI', 'Trade-in valuation', 'Finance pre-qualification', 'Chat-to-test-drive booking', 'Service upsell sequences'],
    metrics: { vehicles_priced: 94000, avg_gross_lift: '$820', close_rate: '+28%' },
    status: 'active',
  },
];

router.get('/', (req, res) => {
  res.json({ success: true, data: AGENTS });
});

router.get('/:id', (req, res) => {
  const agent = AGENTS.find(a => a.id === req.params.id);
  if (!agent) return res.status(404).json({ success: false, error: 'Agent not found' });
  res.json({ success: true, data: agent });
});

router.get('/:id/metrics', (req, res) => {
  const agent = AGENTS.find(a => a.id === req.params.id);
  if (!agent) return res.status(404).json({ success: false, error: 'Agent not found' });
  res.json({ success: true, data: { agent: agent.id, metrics: agent.metrics, timestamp: new Date().toISOString() } });
});

module.exports = router;
