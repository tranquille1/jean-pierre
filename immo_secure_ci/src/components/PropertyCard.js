import React from 'react';
import { View, Text, StyleSheet, TouchableOpacity } from 'react-native';
import { colors, spacing, borderRadius, shadows } from '../utils/theme';

/**
 * Composant PropertyCard - Affiche une carte de bien immobilier
 */
const PropertyCard = ({ property, onPress }) => {
  const formatPrice = (price, currency) => {
    return new Intl.NumberFormat('fr-CI').format(price) + ' ' + currency;
  };

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

  return (
    <TouchableOpacity 
      style={[styles.card, shadows.md]} 
      onPress={onPress}
      activeOpacity={0.7}
    >
      {/* Image du bien */}
      <View style={styles.imageContainer}>
        {property.images && property.images.length > 0 ? (
          <View style={styles.image} />
        ) : (
          <View style={[styles.image, styles.placeholderImage]} />
        )}
        
        {/* Badge vérifié */}
        {property.verified && (
          <View style={styles.verifiedBadge}>
            <Text style={styles.verifiedIcon}>✓</Text>
            <Text style={styles.verifiedText}>Vérifié</Text>
          </View>
        )}
        
        {/* Type de transaction */}
        <View style={styles.transactionBadge}>
          <Text style={styles.transactionText}>
            {property.transactionType === 'location' ? 'À louer' : 
             property.transactionType === 'achat' ? 'À vendre' : 'Terrain'}
          </Text>
        </View>
      </View>

      {/* Contenu de la carte */}
      <View style={styles.content}>
        {/* Titre */}
        <Text style={styles.title} numberOfLines={2}>
          {property.title}
        </Text>

        {/* Localisation */}
        <View style={styles.locationRow}>
          <Text style={styles.locationIcon}>📍</Text>
          <Text style={styles.locationText} numberOfLines={1}>
            {property.location.district || property.location.zone}, {property.location.address.split(',')[0]}
          </Text>
        </View>

        {/* Détails */}
        <View style={styles.detailsRow}>
          {property.details.rooms && (
            <View style={styles.detailItem}>
              <Text style={styles.detailIcon}>🏠</Text>
              <Text style={styles.detailText}>{property.details.rooms} p.</Text>
            </View>
          )}
          {property.details.surface && (
            <View style={styles.detailItem}>
              <Text style={styles.detailIcon}>📐</Text>
              <Text style={styles.detailText}>{property.details.surface} m²</Text>
            </View>
          )}
          {property.details.bedrooms && (
            <View style={styles.detailItem}>
              <Text style={styles.detailIcon}>🛏️</Text>
              <Text style={styles.detailText}>{property.details.bedrooms} ch.</Text>
            </View>
          )}
        </View>

        {/* Prix et score de sécurité */}
        <View style={styles.footer}>
          <Text style={styles.price}>
            {formatPrice(property.price, property.currency)}
            {property.transactionType === 'location' && '/mois'}
          </Text>
          
          <View style={[styles.securityScore, { backgroundColor: getSecurityColor(property.securityScore) + '20' }]}>
            <View style={[styles.securityDot, { backgroundColor: getSecurityColor(property.securityScore) }]} />
            <Text style={[styles.securityText, { color: getSecurityColor(property.securityScore) }]}>
              {property.securityScore}/100
            </Text>
          </View>
        </View>
      </View>
    </TouchableOpacity>
  );
};

const styles = StyleSheet.create({
  card: {
    backgroundColor: colors.cardBackground,
    borderRadius: borderRadius.lg,
    overflow: 'hidden',
    marginVertical: spacing.sm,
    marginHorizontal: spacing.md,
  },
  imageContainer: {
    position: 'relative',
    height: 180,
  },
  image: {
    width: '100%',
    height: '100%',
    backgroundColor: colors.gray200,
  },
  placeholderImage: {
    justifyContent: 'center',
    alignItems: 'center',
  },
  verifiedBadge: {
    position: 'absolute',
    top: spacing.sm,
    left: spacing.sm,
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
  transactionBadge: {
    position: 'absolute',
    top: spacing.sm,
    right: spacing.sm,
    backgroundColor: colors.primary,
    paddingHorizontal: spacing.sm,
    paddingVertical: spacing.xs,
    borderRadius: borderRadius.md,
  },
  transactionText: {
    color: colors.white,
    fontSize: fontSize.xs,
    fontWeight: fontWeight.semibold,
  },
  content: {
    padding: spacing.md,
  },
  title: {
    fontSize: fontSize.lg,
    fontWeight: fontWeight.semibold,
    color: colors.text,
    marginBottom: spacing.xs,
  },
  locationRow: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: spacing.sm,
  },
  locationIcon: {
    fontSize: fontSize.sm,
    marginRight: spacing.xs,
  },
  locationText: {
    fontSize: fontSize.sm,
    color: colors.textSecondary,
    flex: 1,
  },
  detailsRow: {
    flexDirection: 'row',
    marginBottom: spacing.md,
  },
  detailItem: {
    flexDirection: 'row',
    alignItems: 'center',
    marginRight: spacing.lg,
  },
  detailIcon: {
    fontSize: fontSize.sm,
    marginRight: spacing.xs,
  },
  detailText: {
    fontSize: fontSize.sm,
    color: colors.textSecondary,
  },
  footer: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
  },
  price: {
    fontSize: fontSize.xl,
    fontWeight: fontWeight.bold,
    color: colors.primary,
  },
  securityScore: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingHorizontal: spacing.sm,
    paddingVertical: spacing.xs,
    borderRadius: borderRadius.full,
  },
  securityDot: {
    width: 8,
    height: 8,
    borderRadius: 4,
    marginRight: spacing.xs,
  },
  securityText: {
    fontSize: fontSize.xs,
    fontWeight: fontWeight.semibold,
  },
});

// Import des variables manquantes
const fontSize = {
  xs: 12,
  sm: 14,
  md: 16,
  lg: 18,
  xl: 20,
  xxl: 24,
};

const fontWeight = {
  normal: '400',
  medium: '500',
  semibold: '600',
  bold: '700',
};

export default PropertyCard;
