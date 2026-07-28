import jwt from 'jsonwebtoken';

const JWT_ACCESS_SECRET = process.env.JWT_ACCESS_SECRET || 'dsl_node_access_k8x9m2nQ4vR7wP1jL6tY3bF0hC5sA8eU';
const BASE_URL = 'https://dsl-backend-uva3.onrender.com';

const token = jwt.sign(
  { id: 1, email: 'admin@dsl.com', role: 1 }, 
  JWT_ACCESS_SECRET,
  { expiresIn: '1h' }
);

const pageData = {
  defaultOptionId: 'prp-10',
  hero: {
    eyebrow: 'Hair Restoration',
    title: 'HAIR GROWTH',
    accentTitle: 'TREATMENTS',
    description: 'Exosomes for hair regrowth stimulate dormant hair follicles, boost scalp health, and promote natural, thicker hair growth.',
    image: 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=900',
    imageAlt: 'Hair growth treatment client',
    badgeText: '3 Clinics in London',
  },
  detail: {
    image: 'https://images.unsplash.com/photo-1519699047748-de8e457a634e?auto=format&fit=crop&q=80&w=900',
    imageAlt: 'Healthy long hair',
    badge: 'Non-surgical hair support',
    title: 'Hair Growth Treatments',
    description: `Our Hair Growth Treatment offers advanced hair loss solutions, formulated with proven ingredients to promote thicker, fuller hair.\n\nTreatments commonly include:\n• PRP (Platelet-Rich Plasma) Therapy\n• Sylfirm X Microneedling (RF)\n• Mesotherapy for Hair Growth\n• Scalp Micropigmentation\n• Exosomes or Stem Cell Therapy\n\nYour consultation will include:\n• Assessment of Hair Loss\n• Medical history review\n• Customised treatment plan`,
    footer: 'Clinician-led treatment plan',
  },
  pricing: {
    title: 'Select what works for you',
    description: 'Choose a session package for PRP or a small-area plan and book your consultation.',
    selectedLabel: 'Selected Package',
    options: [
      { id: 'prp-10', name: 'PRP', sessions: 'Select Number of Sessions - 10x', originalPrice: '£3000', total: '£1000 Total', popular: true },
      { id: 'prp-6', name: 'PRP', sessions: 'Select Number of Sessions - 6x', originalPrice: '£1800', total: '£700 Total' },
      { id: 'prp-3', name: 'PRP', sessions: 'Select Number of Sessions - 3x', originalPrice: '£900', total: '£350 Total' },
      { id: 'prp-1', name: 'PRP', sessions: 'Select Number of Occasions - 1x', total: 'Consultation Pricing' },
      { id: 'small-area', name: 'Small Area', sessions: 'Select Number of Sessions - 1x', total: 'Custom Quote' },
    ],
  },
  stats: [
    { icon: 'clock', label: 'Treatment Length', value: '15 mins' },
    { icon: 'sparkles', label: 'Number of Sessions', value: '6-10 Sessions' },
    { icon: 'rotate', label: 'Duration of Results', value: 'Permanent' },
    { icon: 'calendar', label: 'Session Frequency', value: 'Every 6-8 Weeks' },
  ],
  results: {
    eyebrow: 'Treatment Results',
    title: 'Hair Growth Treatments',
    items: [
      {
        label: 'Crown Density Improvement',
        before: 'https://images.unsplash.com/photo-1605497787865-e6d4762b3865?auto=format&fit=crop&q=80&w=900',
        after: 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?auto=format&fit=crop&q=80&w=900',
      },
      {
        label: 'Hairline Strengthening',
        before: 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&q=80&w=900',
        after: 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?auto=format&fit=crop&q=80&w=900',
      },
    ],
  },
  faqs: [
    {
      question: 'What is the Hair Growth Treatments?',
      answer: 'Hair Growth Treatments are non-surgical scalp and follicle stimulation treatments designed to support healthier hair growth, reduce thinning, and improve visible hair density over a planned course.',
    },
    {
      question: 'How many sessions are required for Hair Growth Treatments?',
      answer: 'Most clients need a course of 6 to 10 sessions. The exact number depends on the level of thinning, scalp condition, and the treatment plan recommended during consultation.',
    },
    {
      question: 'Is Hair Growth Treatments safe for all skin types?',
      answer: 'Yes, treatment plans can be adapted for all skin types. Your clinician will assess scalp health, medical history, and suitability before starting.',
    },
    {
      question: 'Are there any side effects of Hair Growth Treatments?',
      answer: 'Temporary redness, mild tenderness, or slight swelling can occur after scalp stimulation treatments. These effects are usually mild and settle quickly.',
    },
    {
      question: 'How long do results of Hair Growth Treatments last?',
      answer: 'Results vary by individual and maintenance routine. Many clients choose periodic maintenance sessions to support longer-term scalp and follicle health.',
    },
  ],
};

async function main() {
  const payload = {
    name: 'Hair Growth Treatments',
    slug: 'hair-growth-treatments',
    category_id: 1, // Optional, can be updated later in admin
    pageData
  };

  try {
    // 1. Try to create
    console.log(`Sending POST to ${BASE_URL}/api/v1/treatments/pages...`);
    let res = await fetch(`${BASE_URL}/api/v1/treatments/pages`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`
      },
      body: JSON.stringify(payload)
    });

    let data = await res.json();
    console.log('POST Response:', data);

    // If it already exists, try PUT
    if (res.status === 409 || (data.message && data.message.includes('exists'))) {
      console.log(`Sending PUT to ${BASE_URL}/api/v1/treatments/pages/hair-growth-treatments...`);
      res = await fetch(`${BASE_URL}/api/v1/treatments/pages/hair-growth-treatments`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify(payload)
      });
      data = await res.json();
      console.log('PUT Response:', data);
    }
    
    // Attempt to publish
    if (data && data.data && data.data.id) {
        console.log(`Publishing treatment ${data.data.id}...`);
        const pubRes = await fetch(`${BASE_URL}/api/v1/treatmentpage/${data.data.id}/publish`, {
            method: 'PATCH',
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });
        const pubData = await pubRes.json();
        console.log('Publish Response:', pubData);
    }

  } catch (err) {
    console.error('Error:', err);
  }
}

main();
