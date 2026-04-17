import React, { useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  SafeAreaView,
  TextInput,
} from 'react-native';
import { colors, spacing, borderRadius, fontSize, fontWeight, shadows } from '../utils/theme';
import SearchBar from '../components/SearchBar';

/**
 * Écran de recherche - Search Screen avec filtres avancés
 */
const SearchScreen = ({ navigation }) => {
  const [searchQuery, setSearchQuery] = useState('');
  const [filters, setFilters] = useState({
    transactionType: 'all', // all, location, achat, terrain
    zone: 'all',
    district: 'all',
    type: 'all',
    minPrice: '',
    maxPrice: '',
    rooms: 'all',
    certifiedOnly: false,
  });

  const zones = [
    { id: 'all', label: 'Toutes les zones' },
    { id: 'abidjan', label: 'Abidjan' },
    { id: 'bingerville', label: 'Bingerville' },
    { id: 'songon', label: 'Songon' },
    { id: 'anyama', label: 'Anyama' },
  ];

  const propertyTypes = [
    { id: 'all', label: 'Tous types' },
    { id: 'studio', label: 'Studio' },
    { id: 'appartement', label: 'Appartement' },
    { id: 'villa', label: 'Villa' },
    { id: 'terrain', label: 'Terrain' },
  ];

  const roomsOptions = [
    { id: 'all', label: 'Tous' },
    { id: '1', label: '1 pièce' },
    { id: '2', label: '2 pièces' },
    { id: '3', label: '3 pièces' },
    { id: '4', label: '4+ pièces' },
  ];

  const handleApplyFilters = () => {
    // Logique de filtrage ici
    console.log('Filtres appliqués:', filters);
  };

  const handleResetFilters = () => {
    setFilters({
      transactionType: 'all',
      zone: 'all',
      district: 'all',
      type: 'all',
      minPrice: '',
      maxPrice: '',
      rooms: 'all',
      certifiedOnly: false,
    });
  };

  return (
    <SafeAreaView style={styles.container}>
      {/* Header */}
      <View style={styles.header}>
        <TouchableOpacity onPress={() => navigation.goBack()}>
          <Text style={styles.backIcon}>←</Text>
        </TouchableOpacity>
        <Text style={styles.headerTitle}>Recherche avancée</Text>
        <TouchableOpacity onPress={handleResetFilters}>
          <Text style={styles.resetText}>Réinitialiser</Text>
        </TouchableOpacity>
      </View>

      {/* Barre de recherche */}
      <SearchBar
        value={searchQuery}
        onChangeText={setSearchQuery}
        placeholder="Localisation, nom du bien..."
      />

      <ScrollView style={styles.scrollView} showsVerticalScrollIndicator={false}>
        {/* Type de transaction */}
        <View style={styles.section}>
          <Text style={styles.sectionTitle}>Type de transaction</Text>
          <View style={styles.optionsRow}>
            {[
              { id: 'all', label: 'Tout' },
              { id: 'location', label: 'Location' },
              { id: 'achat', label: 'Achat' },
              { id: 'terrain', label: 'Terrain' },
            ].map((option) => (
              <TouchableOpacity
                key={option.id}
                style={[
                  styles.optionButton,
                  filters.transactionType === option.id && styles.optionButtonActive,
                ]}
                onPress={() => setFilters({ ...filters, transactionType: option.id })}
              >
                <Text
                  style={[
                    styles.optionButtonText,
                    filters.transactionType === option.id && styles.optionButtonTextActive,
                  ]}
                >
                  {option.label}
                </Text>
              </TouchableOpacity>
            ))}
          </View>
        </View>

        {/* Zone géographique */}
        <View style={styles.section}>
          <Text style={styles.sectionTitle}>Zone géographique</Text>
          <View style={styles.dropdown}>
            <Text style={styles.dropdownText}>{zones.find(z => z.id === filters.zone)?.label || 'Sélectionner'}</Text>
            <Text style={styles.dropdownIcon}>▼</Text>
          </View>
        </View>

        {/* Type de bien */}
        <View style={styles.section}>
          <Text style={styles.sectionTitle}>Type de bien</Text>
          <View style={styles.optionsGrid}>
            {propertyTypes.map((type) => (
              <TouchableOpacity
                key={type.id}
                style={[
                  styles.optionCard,
                  filters.type === type.id && styles.optionCardActive,
                ]}
                onPress={() => setFilters({ ...filters, type: type.id })}
              >
                <Text style={styles.optionCardEmoji}>
                  {type.id === 'studio' ? '🏠' : type.id === 'appartement' ? '🏢' : type.id === 'villa' ? '🏡' : type.id === 'terrain' ? '🗺️' : '📋'}
                </Text>
                <Text
                  style={[
                    styles.optionCardText,
                    filters.type === type.id && styles.optionCardTextActive,
                  ]}
                >
                  {type.label}
                </Text>
              </TouchableOpacity>
            ))}
          </View>
        </View>

        {/* Budget */}
        <View style={styles.section}>
          <Text style={styles.sectionTitle}>Budget (FCFA)</Text>
          <View style={styles.priceRow}>
            <View style={styles.priceInput}>
              <Text style={styles.priceLabel}>Min</Text>
              <TextInput
                style={styles.input}
                placeholder="0"
                keyboardType="numeric"
                value={filters.minPrice}
                onChangeText={(text) => setFilters({ ...filters, minPrice: text })}
              />
            </View>
            <Text style={styles.priceSeparator}>-</Text>
            <View style={styles.priceInput}>
              <Text style={styles.priceLabel}>Max</Text>
              <TextInput
                style={styles.input}
                placeholder="Illimité"
                keyboardType="numeric"
                value={filters.maxPrice}
                onChangeText={(text) => setFilters({ ...filters, maxPrice: text })}
              />
            </View>
          </View>
        </View>

        {/* Nombre de pièces */}
        <View style={styles.section}>
          <Text style={styles.sectionTitle}>Nombre de pièces</Text>
          <View style={styles.optionsRow}>
            {roomsOptions.map((option) => (
              <TouchableOpacity
                key={option.id}
                style={[
                  styles.optionButtonSmall,
                  filters.rooms === option.id && styles.optionButtonSmallActive,
                ]}
                onPress={() => setFilters({ ...filters, rooms: option.id })}
              >
                <Text
                  style={[
                    styles.optionButtonSmallText,
                    filters.rooms === option.id && styles.optionButtonSmallTextActive,
                  ]}
                >
                  {option.label}
                </Text>
              </TouchableOpacity>
            ))}
          </View>
        </View>

        {/* Filtre certifié uniquement */}
        <View style={styles.section}>
          <TouchableOpacity
            style={styles.toggleRow}
            onPress={() => setFilters({ ...filters, certifiedOnly: !filters.certifiedOnly })}
          >
            <View style={styles.toggleInfo}>
              <Text style={styles.toggleTitle}>✅ Biens certifiés uniquement</Text>
              <Text style={styles.toggleDescription}>Afficher seulement les biens vérifiés et sécurisés</Text>
            </View>
            <View
              style={[
                styles.toggleSwitch,
                filters.certifiedOnly && styles.toggleSwitchActive,
              ]}
            >
              <View
                style={[
                  styles.toggleKnob,
                  filters.certifiedOnly && styles.toggleKnobActive,
                ]}
              />
            </View>
          </TouchableOpacity>
        </View>

        {/* Bouton appliquer */}
        <View style={styles.applyButtonContainer}>
          <TouchableOpacity style={styles.applyButton} onPress={handleApplyFilters}>
            <Text style={styles.applyButtonText}>Appliquer les filtres</Text>
          </TouchableOpacity>
        </View>
      </ScrollView>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: colors.background,
  },
  header: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.md,
  },
  backIcon: {
    fontSize: fontSize.xl,
    color: colors.text,
  },
  headerTitle: {
    fontSize: fontSize.lg,
    fontWeight: fontWeight.bold,
    color: colors.text,
  },
  resetText: {
    fontSize: fontSize.sm,
    color: colors.primary,
    fontWeight: fontWeight.medium,
  },
  scrollView: {
    flex: 1,
  },
  section: {
    backgroundColor: colors.white,
    padding: spacing.md,
    marginBottom: spacing.sm,
  },
  sectionTitle: {
    fontSize: fontSize.md,
    fontWeight: fontWeight.semibold,
    color: colors.text,
    marginBottom: spacing.md,
  },
  optionsRow: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: spacing.sm,
  },
  optionButton: {
    paddingHorizontal: spacing.lg,
    paddingVertical: spacing.sm,
    borderRadius: borderRadius.full,
    backgroundColor: colors.gray100,
    borderWidth: 1,
    borderColor: 'transparent',
  },
  optionButtonActive: {
    backgroundColor: colors.primary,
    borderColor: colors.primary,
  },
  optionButtonText: {
    fontSize: fontSize.sm,
    color: colors.textSecondary,
    fontWeight: fontWeight.medium,
  },
  optionButtonTextActive: {
    color: colors.white,
  },
  optionButtonSmall: {
    flex: 1,
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.sm,
    borderRadius: borderRadius.md,
    backgroundColor: colors.gray100,
    borderWidth: 1,
    borderColor: 'transparent',
    alignItems: 'center',
  },
  optionButtonSmallActive: {
    backgroundColor: colors.primary,
    borderColor: colors.primary,
  },
  optionButtonSmallText: {
    fontSize: fontSize.sm,
    color: colors.textSecondary,
    fontWeight: fontWeight.medium,
  },
  optionButtonSmallTextActive: {
    color: colors.white,
  },
  dropdown: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    padding: spacing.md,
    borderRadius: borderRadius.lg,
    backgroundColor: colors.gray50,
    borderWidth: 1,
    borderColor: colors.border,
  },
  dropdownText: {
    fontSize: fontSize.md,
    color: colors.text,
  },
  dropdownIcon: {
    fontSize: fontSize.sm,
    color: colors.textSecondary,
  },
  optionsGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: spacing.sm,
  },
  optionCard: {
    width: '48%',
    padding: spacing.md,
    borderRadius: borderRadius.lg,
    backgroundColor: colors.gray50,
    borderWidth: 1,
    borderColor: colors.border,
    alignItems: 'center',
  },
  optionCardActive: {
    backgroundColor: colors.primary + '10',
    borderColor: colors.primary,
  },
  optionCardEmoji: {
    fontSize: 24,
    marginBottom: spacing.xs,
  },
  optionCardText: {
    fontSize: fontSize.sm,
    color: colors.textSecondary,
    fontWeight: fontWeight.medium,
  },
  optionCardTextActive: {
    color: colors.primary,
    fontWeight: fontWeight.semibold,
  },
  priceRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: spacing.md,
  },
  priceInput: {
    flex: 1,
  },
  priceLabel: {
    fontSize: fontSize.xs,
    color: colors.textSecondary,
    marginBottom: spacing.xs,
  },
  input: {
    padding: spacing.md,
    borderRadius: borderRadius.lg,
    backgroundColor: colors.gray50,
    borderWidth: 1,
    borderColor: colors.border,
    fontSize: fontSize.md,
    color: colors.text,
  },
  priceSeparator: {
    fontSize: fontSize.lg,
    color: colors.textSecondary,
  },
  toggleRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
  },
  toggleInfo: {
    flex: 1,
  },
  toggleTitle: {
    fontSize: fontSize.md,
    fontWeight: fontWeight.semibold,
    color: colors.text,
  },
  toggleDescription: {
    fontSize: fontSize.xs,
    color: colors.textSecondary,
    marginTop: spacing.xs,
  },
  toggleSwitch: {
    width: 50,
    height: 28,
    borderRadius: 14,
    backgroundColor: colors.gray300,
    justifyContent: 'center',
    padding: 2,
  },
  toggleSwitchActive: {
    backgroundColor: colors.success,
  },
  toggleKnob: {
    width: 24,
    height: 24,
    borderRadius: 12,
    backgroundColor: colors.white,
  },
  toggleKnobActive: {
    alignSelf: 'flex-end',
  },
  applyButtonContainer: {
    padding: spacing.md,
    paddingBottom: spacing.xl,
  },
  applyButton: {
    backgroundColor: colors.primary,
    paddingVertical: spacing.md,
    borderRadius: borderRadius.lg,
    alignItems: 'center',
    ...shadows.md,
  },
  applyButtonText: {
    fontSize: fontSize.md,
    fontWeight: fontWeight.semibold,
    color: colors.white,
  },
});

export default SearchScreen;
