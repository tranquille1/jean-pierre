import React, { useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  SafeAreaView,
} from 'react-native';
import { colors, spacing, borderRadius, fontSize, fontWeight, shadows } from '../utils/theme';

/**
 * Écran de profil utilisateur - Profile Screen
 */
const ProfileScreen = ({ navigation }) => {
  const user = {
    name: 'Koné Ibrahim',
    email: 'ibrahim.kone@email.ci',
    phone: '+225 07 08 09 10 11',
    verified: true,
    memberSince: 'Janvier 2024',
  };

  const menuItems = [
    {
      id: 'favorites',
      title: '❤️ Mes favoris',
      subtitle: 'Voir mes biens enregistrés',
      icon: '❤️',
    },
    {
      id: 'messages',
      title: '💬 Mes messages',
      subtitle: 'Consulter mes conversations',
      icon: '💬',
    },
    {
      id: 'properties',
      title: '🏠 Mes propriétés',
      subtitle: 'Gérer mes annonces',
      icon: '🏠',
    },
    {
      id: 'visits',
      title: '📅 Mes visites',
      subtitle: 'Historique des visites',
      icon: '📅',
    },
    {
      id: 'documents',
      title: '📄 Mes documents',
      subtitle: 'Accéder à mes pièces justificatives',
      icon: '📄',
    },
    {
      id: 'settings',
      title: '⚙️ Paramètres',
      subtitle: 'Modifier mon profil et préférences',
      icon: '⚙️',
    },
  ];

  return (
    <SafeAreaView style={styles.container}>
      <ScrollView showsVerticalScrollIndicator={false}>
        {/* Header avec informations utilisateur */}
        <View style={styles.header}>
          <TouchableOpacity onPress={() => navigation.goBack()}>
            <Text style={styles.backIcon}>←</Text>
          </TouchableOpacity>
          <Text style={styles.headerTitle}>Mon Profil</Text>
          <View style={{ width: 24 }} />
        </View>

        {/* Carte de profil */}
        <View style={styles.profileCard}>
          <View style={styles.avatarContainer}>
            <Text style={styles.avatarText}>
              {user.name.split(' ').map(n => n[0]).join('')}
            </Text>
          </View>
          
          <Text style={styles.userName}>{user.name}</Text>
          
          {user.verified && (
            <View style={styles.verifiedBadge}>
              <Text style={styles.verifiedIcon}>✓</Text>
              <Text style={styles.verifiedText}>Compte vérifié</Text>
            </View>
          )}
          
          <Text style={styles.memberSince}>Membre depuis {user.memberSince}</Text>
          
          <View style={styles.contactInfo}>
            <View style={styles.contactItem}>
              <Text style={styles.contactIcon}>📧</Text>
              <Text style={styles.contactText}>{user.email}</Text>
            </View>
            <View style={styles.contactItem}>
              <Text style={styles.contactIcon}>📱</Text>
              <Text style={styles.contactText}>{user.phone}</Text>
            </View>
          </View>
        </View>

        {/* Menu options */}
        <View style={styles.menuContainer}>
          {menuItems.map((item) => (
            <TouchableOpacity
              key={item.id}
              style={styles.menuItem}
              onPress={() => console.log(`Navigate to ${item.id}`)}
            >
              <View style={styles.menuItemLeft}>
                <Text style={styles.menuItemIcon}>{item.icon}</Text>
                <View style={styles.menuItemTextContainer}>
                  <Text style={styles.menuItemTitle}>{item.title}</Text>
                  <Text style={styles.menuItemSubtitle}>{item.subtitle}</Text>
                </View>
              </View>
              <Text style={styles.menuItemArrow}>›</Text>
            </TouchableOpacity>
          ))}
        </View>

        {/* Bouton déconnexion */}
        <View style={styles.logoutContainer}>
          <TouchableOpacity style={styles.logoutButton}>
            <Text style={styles.logoutButtonText}>Se déconnecter</Text>
          </TouchableOpacity>
        </View>

        {/* Version de l'application */}
        <View style={styles.versionContainer}>
          <Text style={styles.versionText}>ImmoSecure CI v1.0.0</Text>
          <Text style={styles.copyrightText}>© 2024 - Côte d'Ivoire</Text>
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
  profileCard: {
    backgroundColor: colors.white,
    margin: spacing.md,
    padding: spacing.lg,
    borderRadius: borderRadius.xl,
    alignItems: 'center',
    ...shadows.md,
  },
  avatarContainer: {
    width: 80,
    height: 80,
    borderRadius: 40,
    backgroundColor: colors.primary,
    justifyContent: 'center',
    alignItems: 'center',
    marginBottom: spacing.md,
  },
  avatarText: {
    fontSize: fontSize.xxxl,
    fontWeight: fontWeight.bold,
    color: colors.white,
  },
  userName: {
    fontSize: fontSize.xl,
    fontWeight: fontWeight.bold,
    color: colors.text,
    marginBottom: spacing.sm,
  },
  verifiedBadge: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: colors.success + '15',
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.xs,
    borderRadius: borderRadius.full,
    marginBottom: spacing.sm,
  },
  verifiedIcon: {
    color: colors.success,
    fontSize: fontSize.sm,
    fontWeight: fontWeight.bold,
    marginRight: spacing.xs,
  },
  verifiedText: {
    color: colors.success,
    fontSize: fontSize.sm,
    fontWeight: fontWeight.medium,
  },
  memberSince: {
    fontSize: fontSize.sm,
    color: colors.textSecondary,
    marginBottom: spacing.lg,
  },
  contactInfo: {
    width: '100%',
  },
  contactItem: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingVertical: spacing.sm,
  },
  contactIcon: {
    fontSize: fontSize.md,
    marginRight: spacing.sm,
  },
  contactText: {
    fontSize: fontSize.sm,
    color: colors.textSecondary,
  },
  menuContainer: {
    backgroundColor: colors.white,
    marginHorizontal: spacing.md,
    borderRadius: borderRadius.xl,
    overflow: 'hidden',
    ...shadows.sm,
  },
  menuItem: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    padding: spacing.md,
    borderBottomWidth: 1,
    borderBottomColor: colors.gray50,
  },
  menuItemLeft: {
    flexDirection: 'row',
    alignItems: 'center',
    flex: 1,
  },
  menuItemIcon: {
    fontSize: fontSize.lg,
    marginRight: spacing.md,
  },
  menuItemTextContainer: {
    flex: 1,
  },
  menuItemTitle: {
    fontSize: fontSize.md,
    fontWeight: fontWeight.semibold,
    color: colors.text,
  },
  menuItemSubtitle: {
    fontSize: fontSize.xs,
    color: colors.textSecondary,
    marginTop: 2,
  },
  menuItemArrow: {
    fontSize: fontSize.xl,
    color: colors.textLight,
  },
  logoutContainer: {
    margin: spacing.md,
  },
  logoutButton: {
    backgroundColor: colors.white,
    paddingVertical: spacing.md,
    borderRadius: borderRadius.lg,
    alignItems: 'center',
    borderWidth: 1,
    borderColor: colors.danger,
  },
  logoutButtonText: {
    fontSize: fontSize.md,
    fontWeight: fontWeight.semibold,
    color: colors.danger,
  },
  versionContainer: {
    alignItems: 'center',
    paddingVertical: spacing.lg,
  },
  versionText: {
    fontSize: fontSize.sm,
    color: colors.textLight,
    marginBottom: spacing.xs,
  },
  copyrightText: {
    fontSize: fontSize.xs,
    color: colors.textLight,
  },
});

export default ProfileScreen;
