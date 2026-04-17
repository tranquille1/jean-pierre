import React from 'react';
import { View, Text, TextInput, StyleSheet, TouchableOpacity } from 'react-native';
import { colors, spacing, borderRadius, fontSize, fontWeight, shadows } from '../utils/theme';

/**
 * Composant SearchBar - Barre de recherche principale
 */
const SearchBar = ({ 
  value, 
  onChangeText, 
  onSearch, 
  placeholder = "Rechercher un logement ou terrain...",
  showFilters = false,
  onFilterPress 
}) => {
  return (
    <View style={styles.container}>
      <View style={styles.searchRow}>
        <View style={styles.inputContainer}>
          <Text style={styles.searchIcon}>🔍</Text>
          <TextInput
            style={styles.input}
            placeholder={placeholder}
            placeholderTextColor={colors.textLight}
            value={value}
            onChangeText={onChangeText}
            onSubmitEditing={onSearch}
            returnKeyType="search"
          />
        </View>
        
        {showFilters && (
          <TouchableOpacity style={styles.filterButton} onPress={onFilterPress}>
            <Text style={styles.filterIcon}>⚙️</Text>
          </TouchableOpacity>
        )}
      </View>
    </View>
  );
};

/**
 * Composant FilterChip - Boutons de filtre rapides
 */
export const FilterChips = ({ selectedType, onSelectType }) => {
  const types = [
    { id: 'all', label: 'Tout' },
    { id: 'location', label: 'Location' },
    { id: 'achat', label: 'Achat' },
    { id: 'terrain', label: 'Terrain' },
  ];

  return (
    <View style={styles.chipsContainer}>
      {types.map((type) => (
        <TouchableOpacity
          key={type.id}
          style={[
            styles.chip,
            selectedType === type.id && styles.chipSelected,
          ]}
          onPress={() => onSelectType(type.id)}
        >
          <Text
            style={[
              styles.chipText,
              selectedType === type.id && styles.chipTextSelected,
            ]}
          >
            {type.label}
          </Text>
        </TouchableOpacity>
      ))}
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.sm,
  },
  searchRow: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  inputContainer: {
    flex: 1,
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: colors.white,
    borderRadius: borderRadius.lg,
    paddingHorizontal: spacing.md,
    ...shadows.sm,
  },
  searchIcon: {
    fontSize: fontSize.lg,
    marginRight: spacing.sm,
  },
  input: {
    flex: 1,
    fontSize: fontSize.md,
    color: colors.text,
    paddingVertical: spacing.md,
  },
  filterButton: {
    marginLeft: spacing.sm,
    backgroundColor: colors.white,
    borderRadius: borderRadius.lg,
    padding: spacing.md,
    ...shadows.sm,
  },
  filterIcon: {
    fontSize: fontSize.lg,
  },
  chipsContainer: {
    flexDirection: 'row',
    paddingHorizontal: spacing.md,
    marginBottom: spacing.md,
  },
  chip: {
    paddingHorizontal: spacing.lg,
    paddingVertical: spacing.sm,
    borderRadius: borderRadius.full,
    backgroundColor: colors.gray100,
    marginRight: spacing.sm,
    borderWidth: 1,
    borderColor: 'transparent',
  },
  chipSelected: {
    backgroundColor: colors.primary,
    borderColor: colors.primary,
  },
  chipText: {
    fontSize: fontSize.sm,
    color: colors.textSecondary,
    fontWeight: fontWeight.medium,
  },
  chipTextSelected: {
    color: colors.white,
  },
});

export default SearchBar;
