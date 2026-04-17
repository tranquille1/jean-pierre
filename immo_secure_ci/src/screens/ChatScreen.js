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

/**
 * Écran de messagerie - Chat Screen
 */
const ChatScreen = ({ route, navigation }) => {
  const { propertyId, contactName, contactPhone } = route.params || {};
  const [message, setMessage] = useState('');
  
  // Messages factices
  const [messages, setMessages] = useState([
    {
      id: '1',
      text: 'Bonjour, je suis intéressé par votre bien immobilier.',
      sender: 'user',
      timestamp: new Date(Date.now() - 3600000),
    },
    {
      id: '2',
      text: 'Bonjour ! Je vous remercie pour l\'intérêt. Quand souhaitez-vous visiter ?',
      sender: 'owner',
      timestamp: new Date(Date.now() - 1800000),
    },
  ]);

  const handleSendMessage = () => {
    if (message.trim()) {
      const newMessage = {
        id: Date.now().toString(),
        text: message,
        sender: 'user',
        timestamp: new Date(),
      };
      setMessages([...messages, newMessage]);
      setMessage('');
    }
  };

  const formatTime = (date) => {
    return date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
  };

  return (
    <SafeAreaView style={styles.container}>
      {/* Header */}
      <View style={styles.header}>
        <TouchableOpacity onPress={() => navigation.goBack()}>
          <Text style={styles.backIcon}>←</Text>
        </TouchableOpacity>
        <View style={styles.headerInfo}>
          <Text style={styles.contactName}>{contactName || 'Propriétaire'}</Text>
          <Text style={styles.propertyTitle}>
            {propertyId ? 'Bien immobilier' : 'Discussion'}
          </Text>
        </View>
        <TouchableOpacity>
          <Text style={styles.callIcon}>📞</Text>
        </TouchableOpacity>
      </View>

      {/* Liste des messages */}
      <ScrollView 
        style={styles.messagesContainer}
        contentContainerStyle={styles.messagesContent}
      >
        {messages.map((msg) => (
          <View
            key={msg.id}
            style={[
              styles.messageBubble,
              msg.sender === 'user' ? styles.userBubble : styles.ownerBubble,
            ]}
          >
            <Text
              style={[
                styles.messageText,
                msg.sender === 'user' ? styles.userText : styles.ownerText,
              ]}
            >
              {msg.text}
            </Text>
            <Text
              style={[
                styles.timestamp,
                msg.sender === 'user' ? styles.userTimestamp : styles.ownerTimestamp,
              ]}
            >
              {formatTime(msg.timestamp)}
            </Text>
          </View>
        ))}
      </ScrollView>

      {/* Zone de saisie */}
      <View style={styles.inputContainer}>
        <TextInput
          style={styles.input}
          placeholder="Écrivez votre message..."
          placeholderTextColor={colors.textLight}
          value={message}
          onChangeText={setMessage}
          multiline
          maxLength={500}
        />
        <TouchableOpacity 
          style={[styles.sendButton, !message.trim() && styles.sendButtonDisabled]}
          onPress={handleSendMessage}
          disabled={!message.trim()}
        >
          <Text style={styles.sendButtonText}>➤</Text>
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
    flexDirection: 'row',
    alignItems: 'center',
    paddingHorizontal: spacing.md,
    paddingVertical: spacing.md,
    backgroundColor: colors.white,
    borderBottomWidth: 1,
    borderBottomColor: colors.border,
  },
  backIcon: {
    fontSize: fontSize.xl,
    color: colors.text,
  },
  headerInfo: {
    flex: 1,
    marginLeft: spacing.md,
  },
  contactName: {
    fontSize: fontSize.md,
    fontWeight: fontWeight.semibold,
    color: colors.text,
  },
  propertyTitle: {
    fontSize: fontSize.xs,
    color: colors.textSecondary,
    marginTop: 2,
  },
  callIcon: {
    fontSize: fontSize.lg,
  },
  messagesContainer: {
    flex: 1,
  },
  messagesContent: {
    padding: spacing.md,
  },
  messageBubble: {
    maxWidth: '80%',
    padding: spacing.md,
    borderRadius: borderRadius.lg,
    marginBottom: spacing.sm,
  },
  userBubble: {
    alignSelf: 'flex-end',
    backgroundColor: colors.primary,
    borderBottomRightRadius: 4,
  },
  ownerBubble: {
    alignSelf: 'flex-start',
    backgroundColor: colors.white,
    borderBottomLeftRadius: 4,
    ...shadows.sm,
  },
  messageText: {
    fontSize: fontSize.md,
    lineHeight: 20,
  },
  userText: {
    color: colors.white,
  },
  ownerText: {
    color: colors.text,
  },
  timestamp: {
    fontSize: fontSize.xs,
    marginTop: spacing.xs,
  },
  userTimestamp: {
    color: colors.white + 'CC',
    textAlign: 'right',
  },
  ownerTimestamp: {
    color: colors.textSecondary,
  },
  inputContainer: {
    flexDirection: 'row',
    padding: spacing.md,
    backgroundColor: colors.white,
    borderTopWidth: 1,
    borderTopColor: colors.border,
  },
  input: {
    flex: 1,
    backgroundColor: colors.gray50,
    borderRadius: borderRadius.full,
    paddingHorizontal: spacing.lg,
    paddingVertical: spacing.sm,
    fontSize: fontSize.md,
    color: colors.text,
    maxHeight: 100,
  },
  sendButton: {
    width: 44,
    height: 44,
    borderRadius: 22,
    backgroundColor: colors.primary,
    justifyContent: 'center',
    alignItems: 'center',
    marginLeft: spacing.sm,
  },
  sendButtonDisabled: {
    backgroundColor: colors.gray300,
  },
  sendButtonText: {
    fontSize: fontSize.lg,
    color: colors.white,
  },
});

export default ChatScreen;
