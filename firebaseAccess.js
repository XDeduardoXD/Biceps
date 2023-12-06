 


// Configuración de Firebase
const firebaseConfig = {
    apiKey: "AIzaSyCU9v5kAlHZh_eJ8-MLRWiBpPsF24Ligkw",
    authDomain: "prueba-c36ba.firebaseapp.com",
    projectId: "prueba-c36ba",
    storageBucket: "prueba-c36ba.appspot.com",
    messagingSenderId: "759125692065",
    appId: "1:759125692065:web:2b502e6a03e9ad008e2ae0"
  };
  
  
  // Inicializa Firebase usando la versión 'compat'
  firebase.initializeApp(firebaseConfig);
  const db = firebase.firestore();