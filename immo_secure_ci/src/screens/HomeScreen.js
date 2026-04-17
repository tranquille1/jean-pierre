import React, { useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  SafeAreaView,
  StatusBar,
} from 'react-native';
import { colors, spacing, borderRadius, fontSize, fontWeight, shadows } from '../utils/theme';
import SearchBar, { FilterChips } from '../components/SearchBar';
import PropertyCard from '../components/PropertyCard';
import { mockProperties } from '../data/mockData';

/**
 * Écran d'accueil - Home Screen
 */
const HomeScreen = ({ navigation }) => {
  const [searchQuery, setSearchQuery] = useState('');
  const [selectedType, setSelectedType] = useState('all');

  // Filtrer les propriétés
  const filteredProperties = mockProperties.filter((property) => {
    const matchesSearch = property.title.toLowerCase().includes(searchQuery.toLowerCase()) ||
      property.location.district.toLowerCase().includes(searchQuery.toLowerCase());
    
    const matchesType = selectedType === 'all' || 
      (selectedType === 'terrain' && property.type === 'terrain') ||
      (selectedType !== 'terrain' && property.transactionType === selectedType);
    
    return matchesSearch && matchesType;
  });

  // Propriétés recommandées (featured)
  const featuredProperties = mockProperties.filter(p => p.featured);
  
  // Propriétés certifiées
  const verifiedProperties = mockProperties.filter(p => p.verified && p.securityScore >= 80);

  const renderSection = (title, properties, showAll = false) => (
    <View style={styles.section}>
      <View style={styles.sectionHeader}>
        <Text style={styles.sectionTitle}>{title}</Text>
        {showAll && (
          <TouchableOpacity>
            <Text style={styles.seeAllText}>Voir tout</Text>
          </TouchableOpacity>
        )}
      </View>
      
      <ScrollView
        horizontal
        showsHorizontalScrollIndicator={false}
        contentContainerStyle={styles.horizontalScroll}
      >
        {properties.map((property) => (
          <View key={property.id} style={styles.horizontalCard}>
            <PropertyCard
              property={property}
              onPress={() => navigation.navigate('PropertyDetail', { property })}
            />
          </View>
        ))}
      </ScrollView>
    </View>
  );

  return (
    <SafeAreaView style={styles.container}>
      <StatusBar barStyle="dark-content" backgroundColor={colors.background} />
      
      {/* Header */}
      <View style={styles.header}>
        <View>
          <Text style={styles.greeting}>Bonjour 👋</Text>
          <Text style={styles.location}>Abidjan, Côte d'Ivoire</Text>
        </View>
        <TouchableOpacity 
          style={styles.profileButton}
          onPress={() => navigation.navigate('Profile')}
        >
          <Text style={styles.profileIcon}>👤</Text>
        </TouchableOpacity>
      </View>

      {/* Barre de recherche */}
      <SearchBar
        value={searchQuery}
        onChangeText={setSearchQuery}
        showFilters={true}
        onFilterPress={() => navigation.navigate('Search')}
      />

      {/* Filtres rapides */}
      <FilterChips selectedType={selectedType} onSelectType={setSelectedType} />

      {/* Contenu principal */}
      <ScrollView 
        style={styles.scrollView}
        showsVerticalScrollIndicator={false}
        contentContainerStyle={styles.scrollContent}
      >
        {/* Biens recommandés */}
        {renderSection('🔥 Biens recommandés', featuredProperties, true)}

        {/* Biens certifiés */}
        {renderSection('✅ Biens certifiés', verifiedProperties, true)}

        {/* Tous les biens */}
        <View style={styles.section}>
          <Text style={styles.sectionTitle}>📍 Biens proches de vous</Text>
          {filteredProperties.map((property) => (
            <PropertyCard
              key={property.id}
              property={property}
              onPress={() => navigation.navigate('PropertyDetail', { property })}
            />
          ))}
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
  greeting: {
    fontSize: fontSize.xl,
    fontWeight: fontWeight.bold,
    color: colors.text,
  },
  location: {
    fontSize: fontSize.sm,
    color: colors.textSecondary,
    marginTop: spacing.xs,
  },
  profileButton: {
    width: 40,
    height: 40,
    borderRadius: borderRadius.full,
    backgroundColor: colors.white,
    justifyContent: 'center',
    alignItems: 'center',
    ...shadows.sm,
  },
  profileIcon: {
    fontSize: fontSize.xl,
  },
  scrollView: {
    flex: 1,
  },
  scrollContent: {
    paddingBottom: spacing.xxl,
  },
  section: {
    marginBottom: spacing.lg,
  },
  sectionHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingHorizontal: spacing.md,
    marginBottom: spacing.sm,
  },
  sectionTitle: {
    fontSize: fontSize.lg,
    fontWeight: fontWeight.bold,
    color: colors.text,
  },
  seeAllText: {
    fontSize: fontSize.sm,
    color: colors.primary,
    fontWeight: fontWeight.medium,
  },
  horizontalScroll: {
    paddingHorizontal: spacing.md,
  },
  horizontalCard: {
    width: 320,
    marginRight: spacing.md,
  },
});

export default HomeScreen;
