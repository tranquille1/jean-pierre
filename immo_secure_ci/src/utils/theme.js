/**
 * Design System - ImmoSecure CI
 * Couleurs et styles pour l'application immobilière ivoirienne
 */

export const colors = {
  // Couleurs principales
  primary: '#2563EB',      // Bleu - Confiance
  primaryDark: '#1E40AF',
  primaryLight: '#3B82F6',
  
  secondary: '#10B981',    // Vert - Sécurité
  secondaryDark: '#059669',
  secondaryLight: '#34D399',
  
  // Couleurs neutres
  white: '#FFFFFF',
  black: '#000000',
  gray50: '#F9FAFB',
  gray100: '#F3F4F6',
  gray200: '#E5E7EB',
  gray300: '#D1D5DB',
  gray400: '#9CA3AF',
  gray500: '#6B7280',
  gray600: '#4B5563',
  gray700: '#374151',
  gray800: '#1F2937',
  gray900: '#111827',
  
  // Couleurs de statut
  success: '#10B981',      // Vert - Vérifié/Sûr
  warning: '#F59E0B',      // Orange - Moyen/Attention
  danger: '#EF4444',       // Rouge - Risqué/Non vérifié
  info: '#3B82F6',         // Bleu - Information
  
  // Couleurs spécifiques
  background: '#F9FAFB',
  cardBackground: '#FFFFFF',
  border: '#E5E7EB',
  text: '#1F2937',
  textSecondary: '#6B7280',
  textLight: '#9CA3AF',
  
  // Dégradés
  gradientPrimary: ['#2563EB', '#1E40AF'],
  gradientSuccess: ['#10B981', '#059669'],
  gradientWarning: ['#F59E0B', '#D97706'],
  gradientDanger: ['#EF4444', '#DC2626'],
};

export const spacing = {
  xs: 4,
  sm: 8,
  md: 16,
  lg: 24,
  xl: 32,
  xxl: 48,
};

export const borderRadius = {
  sm: 4,
  md: 8,
  lg: 12,
  xl: 16,
  full: 9999,
};

export const fontSize = {
  xs: 12,
  sm: 14,
  md: 16,
  lg: 18,
  xl: 20,
  xxl: 24,
  xxxl: 32,
};

export const fontWeight = {
  normal: '400',
  medium: '500',
  semibold: '600',
  bold: '700',
};

export const shadows = {
  sm: {
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 1 },
    shadowOpacity: 0.05,
    shadowRadius: 2,
    elevation: 1,
  },
  md: {
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 3,
  },
  lg: {
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.15,
    shadowRadius: 8,
    elevation: 5,
  },
};

export default {
  colors,
  spacing,
  borderRadius,
  fontSize,
  fontWeight,
  shadows,
};
