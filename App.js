import React, { useRef, useEffect, useState, useCallback  } from 'react';
import { StyleSheet, Text, View, Pressable, Modal, Platform, ImageBackground, Dimensions } from 'react-native';
import { NavigationContainer, useRoute } from '@react-navigation/native';
import AsyncStorage from '@react-native-async-storage/async-storage';

import { createNativeStackNavigator } from '@react-navigation/native-stack';
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';


import { StatusBar } from 'expo-status-bar';
import * as NavigationBar from 'expo-navigation-bar';
import AccueilScreen from './screens/AccueilScreen';

import { Ionicons } from '@expo/vector-icons';
import PlanningScreen from './screens/PlanningScreen';
import PlanningGmsScreen from './screens/PlanningGmsScreen';
import LoginScreen from './screens/LoginScreen';
import ClientScreen from './screens/ClientScreen';
import * as LocalAuthentication from 'expo-local-authentication';
import JimmyCalendar from './components/JimmyCalendar/JimmyCalendar';
import RapportScreen from './screens/RapportScreen';

import TestScreen from './screens/TestScreen';
import InterventionGmsScreen from './components/new/gms/planning/InterventionScreen';
import InterventionSolaireScreen from './components/new/solaire/planning/InterventionScreen';
import axios from 'axios';
import ParametresScreen from './screens/ParametresScreen';
import PlanningSolaireScreen from './screens/PlanningSolaireScreen';
import GestionGms from './components/new/gms/clients/gestion';
import GestionSolaire from './components/new/solaire/clients/gestion';
import FormGestionClientGms from './components/new/gms/clients/Form';
import FormGestionClientSolaire from './components/new/solaire/clients/Form';

import { BottomNavigation } from 'react-native-paper';

const Tab = createBottomTabNavigator();
const Stack = createNativeStackNavigator();


const windowWidth = Dimensions.get('window').width;

const CapVertTheme = {
  colors: {
    background: '#1b4369',
    card: '#a0c951',
    text: 'white'
  },
};

const PlanningStack = createNativeStackNavigator();

function PlanningStackScreen() {
  return (
    <PlanningStack.Navigator>
    <PlanningStack.Screen name="Planning" component={PlanningScreen} options={{ title: `Planning` }} />
      <PlanningStack.Screen name="Rapport" component={RapportScreen} options={{ headerShown: true }} />
      <PlanningStack.Screen name="Intervention Gms" component={InterventionGmsScreen} options={{ headerShown: true }} />
      <PlanningStack.Screen name="planning Gms" component={PlanningGmsScreen} options={{ headerShown: true }} />
        <PlanningStack.Screen name="planning Solaire" component={PlanningSolaireScreen} options={{ headerShown: true }} />
      <PlanningStack.Screen name="Intervention Solaire" component={InterventionSolaireScreen} options={{ headerShown: true }} />
    </PlanningStack.Navigator>
  );
}

const ClientStack = createNativeStackNavigator();

function ClientStackScreen() {
  return (
    <ClientStack.Navigator>
    <ClientStack.Screen name="client" component={ClientScreen} options={{ title: `Client` }} />
    <Stack.Screen name="Client Gms" component={GestionGms} options={{ headerShown: true }} />
    <Stack.Screen name="Fiche Client Gms" component={FormGestionClientGms} options={{ headerShown: true }} />
    <Stack.Screen name="Client Solaire" component={GestionSolaire} options={{ headerShown: true }} />
    <Stack.Screen name="Fiche Client Solaire" component={FormGestionClientSolaire} options={{ headerShown: true }} />
   
    </ClientStack.Navigator>
  );
}

function TabScreen() {
  const [user, setUser] = useState('');
  const [role, setRole] = useState('');
  const [equipe, setEquipe] = useState('');
  const [branche, setBranche] = useState('');

  const [jsonData, setJsonData] = useState({ items: [] });

  


  useEffect(() => {
    const fetchUser = async () => {
        try {
            const username = await AsyncStorage.getItem('user');
            const role = await AsyncStorage.getItem('role');
            const equipe = await AsyncStorage.getItem('equipe');
            const branche = await AsyncStorage.getItem('branche');
           
            if (username !== null) {
                setUser(username);
                setRole(role);
                setEquipe(equipe);
                setBranche(branche);
             
            }
          
        } catch (error) {
            console.log(error);
        }
    };
  
    fetchUser();
  }, []);



  function LogoTitle() {
    return (
      <ImageBackground
         style={{ width: windowWidth,flex:1,marginLeft:-15,padding:0,difplay:'flex',alignItems:'center',justifyContent:'center' }}
        source={require('./assets/bck-header.jpg')}
      >
      <Text>Accueil {user}</Text>
     
      </ImageBackground>
    );
  }



  return (
    <Tab.Navigator
    screenOptions={{
      tabBarStyle: { height: 70, display:'flex',justifyContent:'center' },
      activeTintColor: 'black',
      inactiveTintColor: 'white',
       labelPosition: 'below-icon',
      labelStyle: {
        fontSize: 18,
        fontWeight: 'bold',
      },
    }}
    >
    
      <Tab.Screen
        name="Accueil"
        component={AccueilScreen}
         options={{
         
          headerShown: false,
          tabBarLabel: ({ focused, color, size }) => (
           <Text style={{fontSize: focused ? 15 : 12, color: focused ? "black" : "white"}}>Accueil</Text>
           ),
           tabBarIcon: ({ focused, color, size }) => (
            <Ionicons name="leaf" size={focused ? 36 : 30} color={focused ? "black" : "white"} />
          
          ),
          // headerTitle: (props) => <LogoTitle {...props} />
        //   headerShown: false
         }}
      />

      <Tab.Screen
      name="Planning global"
      component={PlanningStackScreen}
      user={user}
    
      options={{
        headerShown: false,
       
        tabBarLabel: ({ focused, color, size }) => (
          <Text style={{fontSize: focused ? 15 : 12, color: focused ? "black" : "white", textAlign:'center'}}>Planning</Text>
          ),
          tabBarIcon: ({ focused, color, size }) => (
           <Ionicons name="calendar-outline" size={focused ? 36 : 30} color={focused ? "black" : "white"} />
         
         )
      }}
    />
    <Tab.Screen
    name="Client"
    component={ClientStackScreen}
    options={{
      title:`Client ${branche}`,
      tabBarLabel: ({ focused, color, size }) => (
        <Text style={{fontSize: focused ? 15 : 12, color: focused ? "black" : "white"}}>Client</Text>
        ),
        tabBarIcon: ({ focused, color, size }) => (
         <Ionicons name="people-outline" size={focused ? 36 : 30} color={focused ? "black" : "white"} />
       
       ),
      headerShown: false
    }}
  />
  <Tab.Screen
  name="Déconnexion"
  component={ParametresScreen}
  options={{
    tabBarLabel: ({ focused, color, size }) => (
      <Text style={{fontSize: focused ? 15 : 12, color: focused ? "black" : "white"}}>Déconnexion</Text>
      ),
      tabBarIcon: ({ focused, color, size }) => (
       <Ionicons name="log-out-outline" size={focused ? 36 : 30} color={focused ? "black" : "white"} />
     
     ),
    headerShown: false
  }}
/>
    </Tab.Navigator>

  )
} 
export default function App() {

  if (Platform.OS === 'android') {
    NavigationBar.setBackgroundColorAsync("#a0c951");
  } else {}
  // NavigationBar.setVisibilityAsync("hidden");
  // NavigationBar.setBehaviorAsync("overlay-swipe");

  // useEffect(() => {
  //   authenticateUser();
  // }, []);

  // const authenticateUser = async () => {
  //   const isSupported = await LocalAuthentication.hasHardwareAsync();
  //   if (isSupported) {
  //     const isEnrolled = await LocalAuthentication.isEnrolledAsync();
  //     if (isEnrolled) {
  //       const result = await LocalAuthentication.authenticateAsync();
  //       if (result.success) {
  //         console.log('User authenticated successfully');
  //       } else {
  //         console.log('User authentication failed');
  //       }
  //     } else {
  //       console.log('User has no enrolled biometrics');
  //     }
  //   } else {
  //     console.log('Biometric authentication is not supported on this device');
  //   }
  // };
  return (

        <NavigationContainer theme={CapVertTheme}>
          <StatusBar style='light' translucent={false} backgroundColor='#a0c951' />
          <Stack.Navigator >
         
           
            <Stack.Screen name="tab" component={TabScreen} options={{ headerShown: false }} />
            <Stack.Screen name="login" component={LoginScreen} options={{ headerShown: false }} />
            
     
          </Stack.Navigator>
        </NavigationContainer>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
    alignItems: 'center',
    justifyContent: 'center',
  },
});
