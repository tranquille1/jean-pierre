import React from 'react';
import { StatusBar } from 'expo-status-bar';
import { View, StyleSheet, Text } from 'react-native';
import AppNavigator from './navigation/AppNavigator';
import { colors } from './utils/theme';

/**
 * Application principale - ImmoSecure CI
 * Application immobilière sécurisée pour la Côte d'Ivoire
 */
export default function App() {
  return (
    <View style={styles.container}>
      <StatusBar style="auto" />
      <AppNavigator />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: colors.background,
  },
});
