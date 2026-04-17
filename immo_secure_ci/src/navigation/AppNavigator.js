import React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';
import { View, Text, StyleSheet } from 'react-native';

// Import des écrans
import HomeScreen from './screens/HomeScreen';
import SearchScreen from './screens/SearchScreen';
import PropertyDetailScreen from './screens/PropertyDetailScreen';
import ChatScreen from './screens/ChatScreen';
import ProfileScreen from './screens/ProfileScreen';

const Stack = createStackNavigator();

/**
 * Configuration de navigation principale
 */
export default function AppNavigator() {
  return (
    <NavigationContainer>
      <Stack.Navigator
        screenOptions={{
          headerShown: false,
        }}
        initialRouteName="Home"
      >
        {/* Écran d'accueil */}
        <Stack.Screen 
          name="Home" 
          component={HomeScreen}
          options={{
            title: 'ImmoSecure CI',
          }}
        />
        
        {/* Écran de recherche */}
        <Stack.Screen 
          name="Search" 
          component={SearchScreen}
          options={{
            title: 'Recherche',
          }}
        />
        
        {/* Écran de détail d'un bien */}
        <Stack.Screen 
          name="PropertyDetail" 
          component={PropertyDetailScreen}
          options={{
            title: 'Détail du bien',
          }}
        />
        
        {/* Écran de messagerie */}
        <Stack.Screen 
          name="Chat" 
          component={ChatScreen}
          options={{
            title: 'Discussion',
          }}
        />
        
        {/* Écran de profil */}
        <Stack.Screen 
          name="Profile" 
          component={ProfileScreen}
          options={{
            title: 'Profil',
          }}
        />
      </Stack.Navigator>
    </NavigationContainer>
  );
}
