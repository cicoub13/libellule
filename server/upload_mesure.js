const firebase = require("firebase/app");
require("firebase/firestore");

var firebaseConfig = {
    apiKey: "AIzaSyCdz7FykmpNta6-VLPl2_BzfzXkanYomds",
    authDomain: "raspeed-f0f19.firebaseapp.com",
    projectId: "raspeed-f0f19",
    storageBucket: "raspeed-f0f19.appspot.com",
    messagingSenderId: "1097956216585",
    appId: "1:1097956216585:web:598c90e7f0408eec448dd8"
  };

// Initialize Firebase
firebase.initializeApp(firebaseConfig);

const db = firebase.firestore();
const docRef = db.collection('mesures').doc();
await docRef.set({
  download: 25.1,
  upload: 1.3,
  ping: 1815,
  date: admin.firestore.Timestamp.fromDate(new Date())
});