import React, { useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  SafeAreaView,
  Image,
  Linking,
} from 'react-native';
import { LinearGradient } from 'expo-linear-gradient';
import { colors, spacing, borderRadius, fontSize, fontWeight, shadows } from '../utils/theme';
import SecurityBadge, { VerifiedBadge } from '../components/SecurityBadge';

/**
 * Écran de détail d'un bien - Property Detail Screen
 */
const PropertyDetailScreen = ({ route, navigation }) => {
  const { property } = route.params;
  const [currentImageIndex, setCurrentImageIndex] = useState(0);

  const formatPrice = (price, currency) => {
    return new Intl.NumberFormat('fr-CI').format(price) + ' ' + currency;
  };

  const handleCall = () => {
    Linking.openURL(`tel:${property.owner.phone}`);
  };

  const handleMessage = () => {
    navigation.navigate('Chat', { 
      propertyId: property.id, 
      contactName: property.owner.name,
      contactPhone: property.owner.phone 
    });
  };

  const getSecurityColor = (score) => {
    if (score >= 80) return colors.success;
    if (score >= 50) return colors.warning;
    return colors.danger;
  };

  return (
    <SafeAreaView style={styles.container}>
      {/* Header avec image */}
      <View style={styles.header}>
        <TouchableOpacity 
          style={styles.backButton}
          onPress={() => navigation.goBack()}
        >
          <Text style={styles.backIcon}>←</Text>
        </TouchableOpacity>
        
        <View style={styles.headerBadges}>
          <VerifiedBadge verified={property.verified} />
        </View>
      </View>

      <ScrollView style={styles.scrollView} showsVerticalScrollIndicator={false}>
        {/* Carousel d'images */}
        <View style={styles.imageContainer}>
          <View style={styles.imagePlaceholder}>
            <Text style={styles.imagePlaceholderText}>
              📷 {property.images?.length || 0} photos
            </Text>
          </View>
          
          {/* Indicateurs d'images */}
          {property.images && property.images.length > 1 && (
            <View style={styles.imageIndicators}>
              {property.images.map((_, index) => (
                <View
                  key={index}
                  style={[
                    styles.indicator,
                    index === currentImageIndex && styles.indicatorActive,
                  ]}
                />
              ))}
            </View>
          )}
        </View>

        {/* Informations principales */}
        <View style={styles.content}>
          {/* Titre et prix */}
          <View style={styles.titleRow}>
            <Text style={styles.title}>{property.title}</Text>
          </View>

          <View style={styles.priceRow}>
            <Text style={styles.price}>
              {formatPrice(property.price, property.currency)}
              {property.transactionType === 'location' && '/mois'}
            </Text>
            <SecurityBadge score={property.securityScore} size="large" />
          </View>

          {/* Localisation */}
          <View style={styles.locationRow}>
            <Text style={styles.locationIcon}>📍</Text>
            <Text style={styles.locationText}>{property.location.address}</Text>
          </View>

          {/* Détails du bien */}
          <View style={styles.detailsCard}>
            <Text style={styles.detailsTitle}>Caractéristiques</Text>
            <View style={styles.detailsGrid}>
              {property.details.rooms && (
                <View style={styles.detailItem}>
                  <Text style={styles.detailIcon}>🏠</Text>
                  <Text style={styles.detailLabel}>{property.details.rooms} pièces</Text>
                </View>
              )}
              {property.details.bedrooms && (
                <View style={styles.detailItem}>
                  <Text style={styles.detailIcon}>🛏️</Text>
                  <Text style={styles.detailLabel}>{property.details.bedrooms} chambres</Text>
                </View>
              )}
              {property.details.bathrooms && (
                <View style={styles.detailItem}>
                  <Text style={styles.detailIcon}>🚿</Text>
                  <Text style={styles.detailLabel}>{property.details.bathrooms} salles de bain</Text>
                </View>
              )}
              {property.details.surface && (
                <View style={styles.detailItem}>
                  <Text style={styles.detailIcon}>📐</Text>
                  <Text style={styles.detailLabel}>{property.details.surface} m²</Text>
                </View>
              )}
              {property.details.parking && (
                <View style={styles.detailItem}>
                  <Text style={styles.detailIcon}>🚗</Text>
                  <Text style={styles.detailLabel}>Parking</Text>
                </View>
              )}
              {property.details.balcony && (
                <View style={styles.detailItem}>
                  <Text style={styles.detailIcon}>🌿</Text>
                  <Text style={styles.detailLabel}>Balcon</Text>
                </View>
              )}
            </View>
          </View>

          {/* Documents disponibles */}
          {property.documents && property.documents.length > 0 && (
            <View style={styles.documentsCard}>
              <Text style={styles.sectionTitle}>📄 Documents disponibles</Text>
              <View style={styles.documentsList}>
                {property.documents.map((doc, index) => (
                  <View key={index} style={styles.documentItem}>
                    <Text style={styles.documentIcon}>✓</Text>
                    <Text style={styles.documentText}>{doc}</Text>
                  </View>
                ))}
              </View>
            </View>
          )}

          {/* Informations propriétaire */}
          <View style={styles.ownerCard}>
            <Text style={styles.sectionTitle}>👤 Propriétaire</Text>
            <View style={styles.ownerInfo}>
              <View style={styles.ownerAvatar}>
                <Text style={styles.ownerAvatarText}>
                  {property.owner.name.charAt(0)}
                </Text>
              </View>
              <View style={styles.ownerDetails}>
                <Text style={styles.ownerName}>{property.owner.name}</Text>
                <View style={styles.ownerRating}>
                  <Text style={styles.starIcon}>⭐</Text>
                  <Text style={styles.ratingText}>{property.owner.rating}/5</Text>
                  {property.owner.verified && (
                    <View style={styles.ownerVerified}>
                      <Text style={styles.verifiedCheck}>✓</Text>
                    </View>
                  )}
                </View>
              </View>
            </View>
          </View>

          {/* Score de sécurité détaillé */}
          <View style={styles.securityCard}>
            <Text style={styles.sectionTitle}>🛡️ Niveau de sécurité</Text>
            <View style={styles.securityProgress}>
              <View style={styles.progressBar}>
                <View 
                  style={[
                    styles.progressFill, 
                    { 
                      width: `${property.securityScore}%`,
                      backgroundColor: getSecurityColor(property.securityScore)
                    }
                  ]} 
                />
              </View>
              <Text style={[
                styles.securityScoreText,
                { color: getSecurityColor(property.securityScore) }
              ]}>
                {property.securityScore}/100 - {property.securityScore >= 80 ? 'Très sûr' : property.securityScore >= 50 ? 'Moyen' : 'Risqué'}
              </Text>
            </View>
            <View style={styles.securityCriteria}>
              <View style={styles.criteriaItem}>
                <Text style={styles.criteriaIcon}>📋</Text>
                <Text style={styles.criteriaText}>Documents validés</Text>
              </View>
              <View style={styles.criteriaItem}>
                <Text style={styles.criteriaIcon}>🆔</Text>
                <Text style={styles.criteriaText}>Identité vérifiée</Text>
              </View>
              <View style={styles.criteriaItem}>
                <Text style={styles.criteriaIcon}>📜</Text>
                <Text style={styles.criteriaText}>Historique disponible</Text>
              </View>
            </View>
          </View>
        </View>
      </ScrollView>

      {/* Boutons d'action */}
      <View style={styles.actions}>
        <TouchableOpacity style={styles.callButton} onPress={handleCall}>
          <Text style={styles.callButtonText}>📞 Appeler</Text>
        </TouchableOpacity>
        <TouchableOpacity 
          style={styles.messageButton} 
          onPress={handleMessage}
        >
          <LinearGradient
            colors={colors.gradientPrimary}
            start={{ x: 0, y: 0 }}
            end={{ x: 1, y: 0 }}
            style={styles.messageButtonGradient}
          >
            <Text style={styles.messageButtonText}>💬 Contacter</Text>
          </LinearGradient>
        </TouchableOpacity>
      </View>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: colors.background,
  },
  header: {
    position: 'absolute',
    top: 0,
    left: 0,
    right: 0,
    zIndex: 10,
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingHorizontal: spacing.md,
    paddingTop: spacing.md,
  },
  backButton: {
    width: 40,
    height: 40,
    borderRadius: borderRadius.full,
    backgroundColor: colors.white + 'E6',
    justifyContent: 'center',
    alignItems: 'center',
  },
  backIcon: {
    fontSize: fontSize.xl,
    color: colors.text,
  },
  headerBadges: {
    flexDirection: 'row',
    gap: spacing.sm,
  },
  scrollView: {
    flex: 1,
  },
  imageContainer: {
    height: 300,
    backgroundColor: colors.gray200,
  },
  imagePlaceholder: {
    width: '100%',
    height: '100%',
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: colors.gray300,
  },
  imagePlaceholderText: {
    fontSize: fontSize.lg,
    color: colors.textSecondary,
  },
  imageIndicators: {
    position: 'absolute',
    bottom: spacing.md,
    left: 0,
    right: 0,
    flexDirection: 'row',
    justifyContent: 'center',
    gap: spacing.xs,
  },
  indicator: {
    width: 8,
    height: 8,
    borderRadius: 4,
    backgroundColor: colors.white + '80',
  },
  indicatorActive: {
    backgroundColor: colors.white,
    width: 24,
  },
  content: {
    padding: spacing.md,
  },
  titleRow: {
    marginBottom: spacing.sm,
  },
  title: {
    fontSize: fontSize.xxl,
    fontWeight: fontWeight.bold,
    color: colors.text,
  },
  priceRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: spacing.md,
  },
  price: {
    fontSize: fontSize.xxl,
    fontWeight: fontWeight.bold,
    color: colors.primary,
  },
  locationRow: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: spacing.lg,
  },
  locationIcon: {
    fontSize: fontSize.lg,
    marginRight: spacing.xs,
  },
  locationText: {
    fontSize: fontSize.md,
    color: colors.textSecondary,
  },
  detailsCard: {
    backgroundColor: colors.white,
    borderRadius: borderRadius.lg,
    padding: spacing.md,
    marginBottom: spacing.md,
    ...shadows.sm,
  },
  detailsTitle: {
    fontSize: fontSize.lg,
    fontWeight: fontWeight.semibold,
    color: colors.text,
    marginBottom: spacing.md,
  },
  detailsGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
  },
  detailItem: {
    width: '50%',
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: spacing.md,
  },
  detailIcon: {
    fontSize: fontSize.lg,
    marginRight: spacing.sm,
  },
  detailLabel: {
    fontSize: fontSize.sm,
    color: colors.textSecondary,
  },
  documentsCard: {
    backgroundColor: colors.white,
    borderRadius: borderRadius.lg,
    padding: spacing.md,
    marginBottom: spacing.md,
    ...shadows.sm,
  },
  sectionTitle: {
    fontSize: fontSize.lg,
    fontWeight: fontWeight.semibold,
    color: colors.text,
    marginBottom: spacing.md,
  },
  documentsList: {
    gap: spacing.sm,
  },
  documentItem: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  documentIcon: {
    width: 24,
    height: 24,
    borderRadius: 12,
    backgroundColor: colors.success + '20',
    color: colors.success,
    textAlign: 'center',
    lineHeight: 24,
    marginRight: spacing.sm,
    fontSize: fontSize.sm,
    fontWeight: fontWeight.bold,
  },
  documentText: {
    fontSize: fontSize.sm,
    color: colors.text,
  },
  ownerCard: {
    backgroundColor: colors.white,
    borderRadius: borderRadius.lg,
    padding: spacing.md,
    marginBottom: spacing.md,
    ...shadows.sm,
  },
  ownerInfo: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  ownerAvatar: {
    width: 50,
    height: 50,
    borderRadius: 25,
    backgroundColor: colors.primary,
    justifyContent: 'center',
    alignItems: 'center',
    marginRight: spacing.md,
  },
  ownerAvatarText: {
    fontSize: fontSize.xl,
    fontWeight: fontWeight.bold,
    color: colors.white,
  },
  ownerDetails: {
    flex: 1,
  },
  ownerName: {
    fontSize: fontSize.md,
    fontWeight: fontWeight.semibold,
    color: colors.text,
    marginBottom: spacing.xs,
  },
  ownerRating: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  starIcon: {
    fontSize: fontSize.sm,
    marginRight: spacing.xs,
  },
  ratingText: {
    fontSize: fontSize.sm,
    color: colors.textSecondary,
    marginRight: spacing.sm,
  },
  ownerVerified: {
    width: 20,
    height: 20,
    borderRadius: 10,
    backgroundColor: colors.success,
    justifyContent: 'center',
    alignItems: 'center',
  },
  verifiedCheck: {
    color: colors.white,
    fontSize: fontSize.xs,
    fontWeight: fontWeight.bold,
  },
  securityCard: {
    backgroundColor: colors.white,
    borderRadius: borderRadius.lg,
    padding: spacing.md,
    marginBottom: spacing.xl,
    ...shadows.sm,
  },
  securityProgress: {
    marginBottom: spacing.md,
  },
  progressBar: {
    height: 8,
    backgroundColor: colors.gray200,
    borderRadius: 4,
    overflow: 'hidden',
    marginBottom: spacing.sm,
  },
  progressFill: {
    height: '100%',
    borderRadius: 4,
  },
  securityScoreText: {
    fontSize: fontSize.sm,
    fontWeight: fontWeight.semibold,
  },
  securityCriteria: {
    gap: spacing.sm,
  },
  criteriaItem: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  criteriaIcon: {
    fontSize: fontSize.md,
    marginRight: spacing.sm,
  },
  criteriaText: {
    fontSize: fontSize.sm,
    color: colors.textSecondary,
  },
  actions: {
    flexDirection: 'row',
    padding: spacing.md,
    paddingBottom: spacing.lg,
    gap: spacing.md,
    backgroundColor: colors.white,
    ...shadows.lg,
  },
  callButton: {
    flex: 1,
    paddingVertical: spacing.md,
    borderRadius: borderRadius.lg,
    backgroundColor: colors.white,
    borderWidth: 1,
    borderColor: colors.primary,
    alignItems: 'center',
  },
  callButtonText: {
    fontSize: fontSize.md,
    fontWeight: fontWeight.semibold,
    color: colors.primary,
  },
  messageButton: {
    flex: 1,
    borderRadius: borderRadius.lg,
    overflow: 'hidden',
  },
  messageButtonGradient: {
    paddingVertical: spacing.md,
    alignItems: 'center',
  },
  messageButtonText: {
    fontSize: fontSize.md,
    fontWeight: fontWeight.semibold,
    color: colors.white,
  },
});

export default PropertyDetailScreen;
