<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places" type="text/javascript"></script>
<script type="text/javascript">
var map;
var geocoder = new google.maps.Geocoder();
var autocomplete;
var marker;
var place;
var address = '';
var latLng = new google.maps.LatLng(23.0300,72.5800);
var zoom = 12;


function updateLatLng(latLng) {
  document.getElementById('lat').value = latLng.lat();
  document.getElementById('lng').value = latLng.lng();
}


function initialize() {
  var mapOptions = {
	center: latLng,
	zoom: zoom,
	mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  
  map = new google.maps.Map(document.getElementById('map'), mapOptions);
  var input = /** @type {HTMLInputElement} */(document.getElementById('searchTextField'));
  autocomplete = new google.maps.places.Autocomplete(input);
  
  autocomplete.bindTo('bounds', map);
  
	marker = new google.maps.Marker({
    position: latLng,
    title: 'Address',
    map: map,
    draggable: true
  });
	  
  
  
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
	place = autocomplete.getPlace();
	$(input).removeClass('notfound');
    if (!place.geometry) {
      // Inform the user that the place was not found and return.
      $(input).addClass('notfound');
      return;
    } //alert(place.address_components);

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);  // Why 17? Because it looks good.
    }
	
	marker.setPosition(place.geometry.location);
    marker.setVisible(true);
	updateLatLng(place.geometry.location);
	
    if (place.address_components) {
      var len = place.address_components.length;
	  for(i=0;i<len;i++) { //alert(place.address_components[i].types[0]+" = "+place.address_components[i].short_name);
		if(place.address_components[i].types[0] == 'locality') {
		  $('#city').val(place.address_components[i].short_name);
		}
		if(place.address_components[i].types[0] == 'administrative_area_level_1') {
		  $('#state').val(place.address_components[i].short_name);
		}
		if(place.address_components[i].types[0] == 'country') {
		  $('#country').val(place.address_components[i].short_name);
		}
		if(place.address_components[i].types[0] == 'postal_code') {
		  $('#pincode').val(place.address_components[i].short_name);
		}
	  }
    }
  });
  
  google.maps.event.addListener(marker, 'dragend', function() {
    updateLatLng(marker.getPosition());
  });
}



google.maps.event.addDomListener(window, 'load', initialize);
</script>