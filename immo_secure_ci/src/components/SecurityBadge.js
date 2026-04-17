import React from 'react';
import { View, Text, StyleSheet, TouchableOpacity } from 'react-native';
import { colors, spacing, borderRadius, shadows, fontSize, fontWeight } from '../utils/theme';

/**
 * Composant SecurityBadge - Affiche le niveau de sécurité d'un bien
 */
const SecurityBadge = ({ score, size = 'medium' }) => {
  const getSecurityColor = (score) => {
    if (score >= 80) return colors.success;
    if (score >= 50) return colors.warning;
    return colors.danger;
  };

  const getSecurityLabel = (score) => {
    if (score >= 80) return 'Très sûr';
    if (score >= 50) return 'Moyen';
    return 'Risqué';
  };

  const getSizeStyles = () => {
    switch (size) {
      case 'small':
        return { container: { paddingVertical: 4, paddingHorizontal: 8 }, text: 10 };
      case 'large':
        return { container: { paddingVertical: 12, paddingHorizontal: 16 }, text: 16 };
      default:
        return { container: { paddingVertical: 8, paddingHorizontal: 12 }, text: 12 };
    }
  };

  const sizeStyles = getSizeStyles();
  const color = getSecurityColor(score);

  return (
    <View style={[styles.container, sizeStyles.container, { backgroundColor: color + '15' }]}>
      <View style={[styles.dot, { backgroundColor: color }]} />
      <Text style={[styles.score, { color, fontSize: sizeStyles.text }]}>
        {score}/100
      </Text>
      <Text style={[styles.label, { color, fontSize: sizeStyles.text - 2 }]}>
        {getSecurityLabel(score)}
      </Text>
    </View>
  );
};

/**
 * Composant VerifiedBadge - Badge de vérification
 */
export const VerifiedBadge = ({ verified = true }) => {
  if (!verified) return null;

  return (
    <View style={styles.verifiedBadge}>
      <Text style={styles.verifiedIcon}>✓</Text>
      <Text style={styles.verifiedText}>Vérifié</Text>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flexDirection: 'row',
    alignItems: 'center',
    borderRadius: borderRadius.full,
    alignSelf: 'flex-start',
  },
  dot: {
    width: 8,
    height: 8,
    borderRadius: 4,
    marginRight: spacing.xs,
  },
  score: {
    fontWeight: fontWeight.semibold,
    marginRight: spacing.sm,
  },
  label: {
    fontWeight: fontWeight.normal,
  },
  verifiedBadge: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: colors.success,
    paddingHorizontal: spacing.sm,
    paddingVertical: spacing.xs,
    borderRadius: borderRadius.full,
  },
  verifiedIcon: {
    color: colors.white,
    fontSize: fontSize.xs,
    fontWeight: fontWeight.bold,
    marginRight: 4,
  },
  verifiedText: {
    color: colors.white,
    fontSize: fontSize.xs,
    fontWeight: fontWeight.medium,
  },
});

export default SecurityBadge;
