var req;
var countReq;
var ckMap;
var fbid;

function highlightRow(rowId) {
	rowID.style.backgroundColor = '#efefef';
}

function dehighlightRow(rowId) {
	rowID.style.backgroundColor = '#ffffff';
}


function executeCount() {
	if(countReq.readyState == 4) {
		if(countReq.status == 200) {
			list = document.querySelectorAll("[data-id=_" + fbid + "]");
			console.log(list);
			span = list.item(0);
			if (span) {
				console.log(countReq.responseText);
				span.innerHTML = countReq.responseText;
			}
		} else {
			alert("Error:\n" + countReq.statusText);
		}
	}
}

function incrementCount() {
	if (window.XMLHttpRequest) {
		countReq = new XMLHttpRequest(); 
	} else if (window.ActiveXObject) { 
		countReq = new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	
	if (countReq) { 
		countReq.onreadystatechange = executeCount;
		console.log("FB ID = " + fbid);
		countReq.open("GET", 'counter.php?fbid=' + fbid, true);
		countReq.send(null);
	}
}

function execute() {
	if(req.readyState == 4) {
		if(req.status == 200) {
			document.getElementById('details-content').innerHTML = req.responseText;
		} else {
			alert("Error:\n" + req.statusText);
		}
	}	
}

function loadXML(url) {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest(); 
	} else if (window.ActiveXObject) { 
		req = new ActiveXObject("Microsoft.XMLHTTP"); 
	} 
	
	if (req) { 
		req.onreadystatechange = execute; 
		req.open("GET", url, true);
		req.send(null);
	}
}

function showMap(lat, lon, branchTitle) {
	if (ckMap != undefined) {
		ckMap.off();
		ckMap.remove();
	}
	
	ckMap = L.map('map').setView([lat, lon], 13);
	L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/dark-v9/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiZmZsb3JlYW5pIiwiYSI6ImNqM2tsbGZvaDAwNTgyd3M3cGs0OG93cGgifQ.inBL1gJ4sSWVeeSOBmoEZQ', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
			'<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="http://mapbox.com">Mapbox</a>',
		id: 'mapbox.streets'
	}).addTo(ckMap);
	
	var marker = L.marker([lat, lon]).addTo(ckMap);
	marker.bindPopup("<b>" + branchTitle + "</b>").openPopup();
}

function showDetails(lat, lon, branchTitle, url, rowid) {
	fbid = rowid;
	incrementCount();
	loadXML(url);
	showMap(lat, lon, branchTitle);
}