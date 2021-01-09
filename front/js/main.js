// Your web app's Firebase configuration
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

var dates = [];
var downloads = [];
var uploads = [];
var pings = [];

function reset(){
  dates = [];
   downloads = [];
   uploads = [];
   pings = [];
}

var db = firebase.firestore();

getWeek();

function getMonth(){
  reset();
  db.collection('mesures').orderBy('date', 'desc').limit(24*31).get()
  .then((mesures) => {
    mesures.forEach(doc => {
      console.log(doc.id, '=>', doc.data());
    
      dates.unshift(new Date(doc.data().date.toDate()).toISOString());
      downloads.unshift(doc.data().download / 8000000);
      uploads.unshift(doc.data().upload / 8000000);
      pings.unshift(Math.ceil(doc.data().ping));
    })
    fillChart(downloads, uploads, pings, dates);
  });
}

function getWeek(){
  reset();
  db.collection('mesures').orderBy('date', 'desc').limit(24*7).get()
  .then((mesures) => {
    mesures.forEach(doc => {
      console.log(doc.id, '=>', doc.data());
    
      dates.unshift(new Date(doc.data().date.toDate()).toISOString());
      downloads.unshift(doc.data().download / 8000000);
      uploads.unshift(doc.data().upload / 8000000);
      pings.unshift(Math.ceil(doc.data().ping));
    })
    fillChart(downloads, uploads, pings, dates);
  });
}

function getDay(){
  reset();
  db.collection('mesures').orderBy('date', 'desc').limit(24).get()
  .then((mesures) => {
    mesures.forEach(doc => {
      console.log(doc.id, '=>', doc.data());
    
      dates.unshift(new Date(doc.data().date.toDate()).toISOString());
      downloads.unshift(doc.data().download / 8000000);
      uploads.unshift(doc.data().upload / 8000000);
      pings.unshift(Math.ceil(doc.data().ping));
    })
    fillChart(downloads, uploads, pings, dates);
  });
}



function fillChart(downloads, uploads, pings, dates) {
  console.log(downloads);
  console.log(uploads);
  console.log(pings);
  console.log(dates);
  var ctx = document.getElementById('myChart').getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: dates,
          datasets: [{
            label: 'Download',
            borderColor: '#02c608',
            backgroundColor: '#02c608',
            fill: false,
            data: downloads,
            yAxisID: 'y-axis-1',
        },
        {
          label: 'Upload',
          borderColor: '#c60202',
            backgroundColor: '#c60202',
            fill: false,
          data: uploads,
          yAxisID: 'y-axis-1',
        },
        {
            label: 'Ping',
            borderColor: '#c602bd',
            backgroundColor: '#c602bd',
            fill: false,
            data: pings,
            yAxisID: 'y-axis-2',
        }]
      },
      options: {
        responsive: true,
					hoverMode: 'index',
					stacked: false,
					title: {
						display: true,
						text: 'Speed Test'
					},
					scales: {
						yAxes: [{
							type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
              display: true,
              labelString:'MB/s',
							position: 'left',
							id: 'y-axis-1',
						}, {
							type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
							display: true,
              position: 'right',
              labelString:'ms',
							id: 'y-axis-2',

							// grid line settings
							gridLines: {
								drawOnChartArea: true, // only want the grid lines for one axis to show up
							},
						}],
					}
      }
  });
}