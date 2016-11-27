@extends('layout.master')
@section('title','Infomation Company')
@section('content')
@if (Session::has('status'))
    <div class="col-md-4 col-md-offset-4">
        <div class="alert alert-success notice_success">
            {{Session::get('status')}}
        </div>
    </div>
@endif
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h2 class="text-center text-capitalize">Thông tin công ty</h2>
                <form action="{{route('info.company')}}" method="post" enctype="multipart/form-data" id="form_company">
                    {{csrf_field()}}
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label for="name">Tên công ty</label>
                                @if($errors->has('name'))
                                    <span class="alert">
                                        <span data-dismiss="alert" class="close-alert pull-right"><i class="fa fa-window-close" aria-hidden="true"></i></span>
                                        <label class="label label-danger pull-right">{{$errors->first('name')}}</label>
                                    </span>
                                @endif
                                <input type="text" name="name" id="name" placeholder="Nhập tên công ty" class="form-control" value="{{old('name')}}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label for="images">Hình ảnh công ty</label>
                                @if($errors->has('images'))
                                    <span class="alert">
                                        <span data-dismiss="alert" class="close-alert pull-right"><i class="fa fa-window-close" aria-hidden="true"></i></span>
                                        <label class="label label-danger pull-right">{{$errors->first('images')}}</label>
                                    </span>
                                @endif
                                <input type="file" name="images" id="images" class="form-control">
                                <img src="http://24hourflex.com/wp-content/uploads/2015/12/upload.png" id="showimages" class="img-responsive" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label for="address">Địa chỉ công ty</label>
                                @if($errors->has('address'))
                                    <span class="alert">
                                        <span data-dismiss="alert" class="close-alert pull-right"><i class="fa fa-window-close" aria-hidden="true"></i></span>
                                        <label class="label label-danger pull-right">{{$errors->first('address')}}</label>
                                    </span>
                                @endif
                                <input type="text" name="address" id="address" class="form-control" value="{{old('address')}}" placeholder="Nhập địa chỉ công ty">
                                <input type="hidden" name="lat" id="lat_address">
                                <input type="hidden" name="lng" id="lng_address">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="col-md-6 col-md-offset-3" id="floating-panel">
                                    <button type="button" id="btn_address" name="button">Tìm kiếm vị trí</button>
                            </div>
                            <div id="map"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
                        <div class="form-group">
                            <label for="allinfo">Thông tin công ty</label>
                            @if($errors->has('allinfo'))
                                <span class="alert">
                                    <span data-dismiss="alert" class="close-alert pull-right"><i class="fa fa-window-close" aria-hidden="true"></i></span>
                                    <label class="label label-danger pull-right">{{$errors->first('allinfo')}}</label>
                                </span>
                            @endif
                            <textarea name="allinfo" id="allinfo">{{old('allinfo')}}</textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
                        <div class="form-group">
                            <button type="submit" id="btn_info" name="btn_info" class="btn btn-success form-control">Đăng Thông Tin Công Ty</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script type="text/javascript" src="{{url('public/tinymce/js/tinymce/tinymce.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function(){
    tinymce.init({
        selector: 'textarea',
        height:250,
        theme: 'modern',
        plugins: [
        'advlist autolink lists link image charmap preview anchor',
        ],
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify'
    });
    function readURL(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function (e){
                $("#showimages").attr('src',e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#images").change(function(){
        readURL(this);
    });
});
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCALJWTQoyKq3G6V6DaRRAQZ1PVPRLCRzk&libraries=places"></script>
<script>
$("#form_company").submit(function(e){
    e.preventDefault();
    $("#btn_address").focus();
});
////////////////////////////////////////// STYLE GOOGLE MAP
var styledMapType = new google.maps.StyledMapType(
    [
    //{elementType: 'geometry', stylers: [{color: '#ffffff'}]},  // color all land
      {elementType: 'labels.text.fill', stylers: [{color: '#0b5d47'}]},  // color text land
      {elementType: 'labels.text.stroke', stylers: [{color: '#ffffff'}]},  // color text land strong
      {
        featureType: 'poi',
        elementType: 'labels.text.fill',
        stylers: [{color: '#d40000'}] // color text center large
      },
      {
        featureType: 'poi',
        elementType: 'labels.text.stroke',
        stylers: [{color: '#ffffff'}] // color text center large
      },
      {
        featureType: 'transit.line',
        elementType: 'labels.text.fill',
        stylers: [{color: '#0b5d47'}] // color text land parcel
      },
      {
        featureType: 'transit.line',
        elementType: 'labels.text.stroke',
        stylers: [{color: '#ffffff'}] // color text strong land parcel
      },
      {
        featureType: 'administrative.land_parcel',
        elementType: 'labels.text.fill',
        stylers: [{color: '#ff0000'}] // color text land parcel
      },
      {
        featureType: 'road.local',
        elementType: 'labels.text.fill',
        stylers: [{color: '#0f8061'}] // color text road
      },
      {
        featureType: 'road.local',
        elementType: 'labels.text.stroke',
        stylers: [{color: '#ffffff'}] // color text road
      },
      {
        featureType: 'water',
        elementType: 'labels.text.fill',
        stylers: [{color: '#0da3c9'}] // color name rivers
      },
    //// // // // // // // // // // // // // //
      {
          featureType: 'water',
          elementType: 'geometry.fill',
          stylers: [{color: '#c7e9f2'}] // rivers color
      },
    {
      featureType: 'poi.park',
      elementType: 'geometry.fill',
      stylers: [{color: '#91ecce'}] // color park
    },
    {
      featureType: 'administrative.land_parcel',
      elementType: 'geometry.stroke',
      stylers: [{color: '#ff0000'}] // color land parcel
    },
      {
        featureType: 'transit.station',
        elementType: 'geometry',
        stylers: [{color: '#2bd187'}] // color country
      },
        {
          featureType: 'administrative',
          elementType: 'geometry.stroke',
          stylers: [{color: '#2bd187'}]   // color dashed bay
      },
      {
          featureType: 'poi',
          elementType: 'geometry',
          stylers: [{color: '#2bd187'}] // // color center large
      },


      {
        featureType: 'road',
        elementType: 'geometry',
        stylers: [{color: '#FFFFFF'}] // color row drive large
      },
      {
        featureType: 'road.arterial',
        elementType: 'geometry',
            stylers: [{color: '#FFFFFF'}] // color row drive smalll
      },
      {
        featureType: 'road.highway',
        elementType: 'geometry',
        stylers: [{color: '#09c996'}] // color highway
      },
      {
        featureType: 'road.highway',
        elementType: 'geometry.stroke',
        stylers: [{color: '#ffffff'}] // color 2sides strong highway
      },
      {
        featureType: 'road.highway.controlled_access',
        elementType: 'geometry',
        stylers: [{color: '#09c996'}] // color controlled access
      },
      {
        featureType: 'road.highway.controlled_access',
        elementType: 'geometry.stroke',
        stylers: [{color: '#ffffff'}] // color 2 slides controlled access
      },
      {
        featureType: 'transit.line',
        elementType: 'geometry',
        stylers: [{color: '#ff6a33'}] // color road
      },
      {
          featureType: 'landscape.natural',
          elementType: 'geometry',
          stylers: [{color: '#ebe5e5'}] // color landscape natural
      }
    ],
    {name: 'Styled Map'});
////////////////////////////////////////////////
var map;
var myLatLng;
geoLocationInit();
function geoLocationInit(){
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(success,fail);
    }else{
        alert("Trình duyệt không hỗ trợ bản đồ !");
    }
}
var latval;
var lngval;
function success(position){
    latval = position.coords.latitude;
    lngval = position.coords.longitude;
     myLatLng = new google.maps.LatLng(latval, lngval); // lấy tọa độ vị trí hiện tại
    createMap(myLatLng);
}
function fail(){
    alert('Kết nối với bản đồ thất bại !');
}
//////////////////////////////////////////////// create map
function createMap(){
    map = new google.maps.Map(document.getElementById('map'), {
            center: myLatLng,
            zoom: 14,
            mapTypeControlOptions: {
              mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain',
                      'styled_map']
            }
        });
    map.mapTypes.set('styled_map', styledMapType);
    map.setMapTypeId('styled_map');
    var market = new google.maps.Marker({
        position: myLatLng,
        map: map,
        animation: google.maps.Animation.DROP,
        icon:"http://developerweb.pro/CV/public/images/icon-home.png",
    });



    var geocoder = new google.maps.Geocoder();
     var infowindow = new google.maps.InfoWindow;

    document.getElementById("address").addEventListener("keyup", function(e) {
        e.preventDefault();
        if (e.keyCode == 13) {
            document.getElementById("btn_address").click();
        }
    });
    document.getElementById('btn_address').addEventListener('click', function() {
      geocodeAddress(geocoder,infowindow);
    });
}

function geocodeAddress(geocoder,infowindow) {
  var address = document.getElementById('address').value;
  geocoder.geocode({'address': address}, function(results, status) {
    if (status === 'OK') {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
        map: map,
        draggable: true,
        position: results[0].geometry.location,
        animation: google.maps.Animation.BOUNCE,
        icon:"http://developerweb.pro/CV/public/images/icon-map.png",
      });

    //    marker.addListener('click', function(){
    //         alert("ASdsadsa");
    //    });
     infowindow.setContent(results[0].formatted_address);
     infowindow.open(map, marker);

     var latlngStr = results[0].geometry.location;
     var lat = latlngStr.lat();
     var lng = latlngStr.lng();

     $("#lat_address").val(lat);
     $("#lng_address").val(lng);

     //  var directionsDisplay = new google.maps.DirectionsRenderer({
     //    draggable: true,
     //    map: map,
     //  });
     //  directionsDisplay.addListener('directions_changed', function() {
     //    computeTotalDistance(directionsDisplay.getDirections());
     //  });
     $("#form_company").submit(function(e){
          $(this).unbind('submit').submit()
     });
    } else {
        status = "Không tìm thấy địa chỉ !";
      alert(status);
      $("#form_company").submit(function(e){
          e.preventDefault();
      });
    }

    // function computeTotalDistance(result) {
    //   var total = 0;
    //   var myroute = result.routes[0];
    //   for (var i = 0; i < myroute.legs.length; i++) {
    //     total += myroute.legs[i].distance.value;
    //   }
    //   total = total / 1000;
    //   document.getElementById('total').innerHTML = total + ' km';
    // }


  });
}
</script>
@endsection
