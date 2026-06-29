@extends('admin.layout.app')
@section('content')
    <!-- Main Content-->
    <div class="main-content side-content pt-0">

        <div class="main-container container-fluid">
            <div class="inner-body">

                <!-- Page Header -->
                <div class="page-header">
                    <div>
                        <h2 class="main-content-title tx-24 mg-b-5">User Map</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">HRMS </a></li>
                            <li class="breadcrumb-item active" aria-current="page">User Map </li>
                        </ol>
                    </div>
                    
                </div>
                <!-- End Page Header -->

               
                <!-- Row -->
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="card card-body listing-location  mb-4" id="map2" style="height:500px">
                                    <h4 class="mb-1">Location 2</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Row -->
            </div>
        </div>
    </div>
    <!-- End Main Content-->


    <script>
    
    // function getTopCities(this){
    //     var value = $(this).data('data-show-div');
    //     alert(value);
    // }
    
    
    function initMap() {
        const myLatLng = { lat: 22.2734719, lng: 70.7512559 };
        //const myLatLng = { lat: 25.276987, lng: 55.296249 };

        const map = new google.maps.Map(document.getElementById("map2"), {
            zoom: 1,
            center: myLatLng,
        });

        var locations = {{ Js::from($propertyAddressPoints) }}; 
        var infowindow = new google.maps.InfoWindow();

        var bounds = new google.maps.LatLngBounds(); // Create bounds object

        var marker, i;

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i]['location_lat'], locations[i]['location_lng']),
                map: map,
                title: locations[i]['location_address']
            });

            bounds.extend(marker.getPosition()); // Extend bounds to include marker position

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                let string = "{{ url('/admin/getUserMap/')  }}" + locations[i]['id'];
                let modifiedString = string.replace(/ /g, '');
                let blank = "_blank";

                return function() {
                    var content = '<a target=' + blank + ' href=' + modifiedString + '><br><strong>' + locations[i]['first_name'] + ' </strong> (<strong>' + locations[i]['location_date'] + '</strong> / <strong>' + locations[i]['location_time'] + '</strong>)<br><br>' + locations[i]['location_address'] + '</a><br>';
                    content += 'Latitude: ' + locations[i]['location_lat'] + '<br>';
                    content += 'Longitude: ' + locations[i]['location_lng'] + '<br>';
                    infowindow.setContent(content);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }

        map.fitBounds(bounds); // Fit the map to the bounds
    }
  
    window.initMap = initMap;
    </script>
    <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key=AIzaSyCVz3ayqg0OlLehwoncB6Pof8AZYhbrRIA&callback=initMap" ></script>

<script>

    reloadPage();
    // Function to reload the page after 10 seconds
    function reloadPage() {
        setTimeout(function() {
            location.reload();
        }, 10000); // 10000 milliseconds = 10 seconds
    }
</script>
  
@endsection
