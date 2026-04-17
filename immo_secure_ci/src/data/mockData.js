/**
 * Données factices pour l'application ImmoSecure CI
 */

export const propertyTypes = [
  { id: 'studio', label: 'Studio', icon: 'home' },
  { id: 'appartement', label: 'Appartement', icon: 'building' },
  { id: 'villa', label: 'Villa', icon: 'circle-help' },
  { id: 'terrain', label: 'Terrain', icon: 'map' },
  { id: 'commerce', label: 'Local commercial', icon: 'store' },
];

export const zones = [
  { id: 'abidjan', label: 'Abidjan', districts: ['Cocody', 'Plateau', 'Marcory', 'Treichville', 'Yopougon', 'Adjamé', 'Koumassi', 'Port-Bouët'] },
  { id: 'bingerville', label: 'Bingerville', districts: [] },
  { id: 'songon', label: 'Songon', districts: [] },
  { id: 'anyama', label: 'Anyama', districts: [] },
  { id: 'grand-bassam', label: 'Grand-Bassam', districts: [] },
];

export const mockProperties = [
  {
    id: '1',
    title: 'Villa moderne 4 pièces',
    type: 'villa',
    transactionType: 'location', // location, achat, terrain
    price: 750000,
    currency: 'FCFA',
    location: {
      zone: 'abidjan',
      district: 'Cocody',
      address: 'Riviera 2, Abidjan',
      latitude: 5.3599517,
      longitude: -3.9810131,
    },
    details: {
      rooms: 4,
      bedrooms: 3,
      bathrooms: 2,
      surface: 180,
      floor: null,
      furnished: false,
      parking: true,
      balcony: true,
    },
    images: [
      'https://images.unsplash.com/photo-1600596542815-e32c8ec049b5?w=800',
      'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800',
      'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=800',
    ],
    verified: true,
    securityScore: 92,
    documents: ['ACD', 'Permis de construire'],
    owner: {
      id: 'owner1',
      name: 'M. Kouamé Jean',
      phone: '+225 07 07 07 07 07',
      verified: true,
      rating: 4.8,
    },
    featured: true,
    createdAt: '2024-01-15',
  },
  {
    id: '2',
    title: 'Studio meublé centre-ville',
    type: 'studio',
    transactionType: 'location',
    price: 150000,
    currency: 'FCFA',
    location: {
      zone: 'abidjan',
      district: 'Plateau',
      address: 'Avenue Lamblin, Plateau',
      latitude: 5.3247,
      longitude: -4.0156,
    },
    details: {
      rooms: 1,
      bedrooms: 1,
      bathrooms: 1,
      surface: 35,
      floor: 3,
      furnished: true,
      parking: false,
      balcony: false,
    },
    images: [
      'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=800',
      'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=800',
    ],
    verified: true,
    securityScore: 88,
    documents: ['Attestation de propriété'],
    owner: {
      id: 'owner2',
      name: 'Mme. Traoré Aminata',
      phone: '+225 05 05 05 05 05',
      verified: true,
      rating: 4.5,
    },
    featured: false,
    createdAt: '2024-01-18',
  },
  {
    id: '3',
    title: 'Terrain à bâtir 500m²',
    type: 'terrain',
    transactionType: 'achat',
    price: 15000000,
    currency: 'FCFA',
    location: {
      zone: 'bingerville',
      district: '',
      address: 'Route de Bingerville',
      latitude: 5.3550,
      longitude: -3.8950,
    },
    details: {
      rooms: null,
      bedrooms: null,
      bathrooms: null,
      surface: 500,
      floor: null,
      furnished: null,
      parking: null,
      balcony: null,
    },
    images: [
      'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=800',
      'https://images.unsplash.com/photo-1500076656116-558758c991c1?w=800',
    ],
    verified: false,
    securityScore: 45,
    documents: ['Attestation villageoise'],
    owner: {
      id: 'owner3',
      name: 'M. Yao Patrick',
      phone: '+225 01 01 01 01 01',
      verified: false,
      rating: 3.2,
    },
    featured: false,
    createdAt: '2024-01-20',
  },
  {
    id: '4',
    title: 'Appartement standing 3 pièces',
    type: 'appartement',
    transactionType: 'location',
    price: 500000,
    currency: 'FCFA',
    location: {
      zone: 'abidjan',
      district: 'Marcory',
      address: 'Zone 4, Marcory',
      latitude: 5.2975,
      longitude: -3.9875,
    },
    details: {
      rooms: 3,
      bedrooms: 2,
      bathrooms: 1,
      surface: 95,
      floor: 2,
      furnished: false,
      parking: true,
      balcony: true,
    },
    images: [
      'https://images.unsplash.com/photo-1502672023488-70e25813eb80?w=800',
      'https://images.unsplash.com/photo-1484154218962-a1c002085d2f?w=800',
    ],
    verified: true,
    securityScore: 95,
    documents: ['ACD', 'Titre foncier'],
    owner: {
      id: 'owner4',
      name: 'SCI Les Palmiers',
      phone: '+225 27 27 27 27 27',
      verified: true,
      rating: 4.9,
    },
    featured: true,
    createdAt: '2024-01-12',
  },
  {
    id: '5',
    title: 'Villa luxe avec piscine',
    type: 'villa',
    transactionType: 'achat',
    price: 180000000,
    currency: 'FCFA',
    location: {
      zone: 'abidjan',
      district: 'Cocody',
      address: 'Ambassades, Cocody',
      latitude: 5.3650,
      longitude: -3.9750,
    },
    details: {
      rooms: 6,
      bedrooms: 5,
      bathrooms: 4,
      surface: 450,
      floor: null,
      furnished: true,
      parking: true,
      balcony: true,
      pool: true,
      garden: true,
    },
    images: [
      'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800',
      'https://images.unsplash.com/photo-1613977257363-707ba9348227?w=800',
    ],
    verified: true,
    securityScore: 98,
    documents: ['ACD', 'Titre foncier', 'Permis de construire'],
    owner: {
      id: 'owner5',
      name: 'M. Diarrasso Mamadou',
      phone: '+225 03 03 03 03 03',
      verified: true,
      rating: 5.0,
    },
    featured: true,
    createdAt: '2024-01-10',
  },
];

export const mockMessages = [
  {
    id: '1',
    propertyId: '1',
    propertyTitle: 'Villa moderne 4 pièces',
    contactName: 'M. Kouamé Jean',
    lastMessage: 'Bonjour, je suis intéressé par votre bien...',
    timestamp: '2024-01-20T10:30:00Z',
    unread: true,
  },
  {
    id: '2',
    propertyId: '4',
    propertyTitle: 'Appartement standing 3 pièces',
    contactName: 'SCI Les Palmiers',
    lastMessage: 'La visite est prévue demain à 15h',
    timestamp: '2024-01-19T14:20:00Z',
    unread: false,
  },
];

export const mockUser = {
  id: 'user1',
  name: 'Koné Ibrahim',
  email: 'ibrahim.kone@email.ci',
  phone: '+225 07 08 09 10 11',
  avatar: null,
  verified: true,
  role: 'buyer', // buyer, seller, agent
  favorites: ['1', '4', '5'],
  properties: [],
};

export const getSecurityScoreColor = (score) => {
  if (score >= 80) return '#10B981'; // Vert
  if (score >= 50) return '#F59E0B'; // Orange
  return '#EF4444'; // Rouge
};

export const getSecurityScoreLabel = (score) => {
  if (score >= 80) return 'Très sûr';
  if (score >= 50) return 'Moyen';
  return 'Risqué';
};

export default {
  propertyTypes,
  zones,
  mockProperties,
  mockMessages,
  mockUser,
  getSecurityScoreColor,
  getSecurityScoreLabel,
};
