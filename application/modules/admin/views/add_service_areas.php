<!DOCTYPE html>
<html>

<head>

    <title>Admin | Add Service Area </title>
    <?php $this->load->view('common/admin_header'); ?>

    <style type="text/css">

        #map-canvas {
          height: 500px;
          margin: 0px;
          padding: 0px
      }

      #pac-input {
        height: 40px;
        width: 320px;
    }

</style>

</head>

<body>
    <div id="wrapper">

        <?php $this->load->view('common/admin_nav'); ?>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <?php $this->load->view('common/admin_top_nav'); ?>
            </div>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Add Service Area</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo admin_url(); ?>service_areas">Service Areas</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Add Service Area</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
                    <a href="<?php echo admin_url(); ?>service_areas" class="btn btn-primary mt-4">
                        Back to Service Areas
                    </a>
                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="float-left">Add Service Area</h5>

                            </div>
                            <div class="ibox-content">

                                <form id="add_service_areas_form" action="" method="post" class="form-horizontal">

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Area Title</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="area_title" id="area_title" class="form-control" required="required" placeholder="Area Title">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Draw Area</label>
                                        <div class="col-sm-10">
                                            <input id="pac-input" class="controls" type="text" placeholder="Search Area" />
                                            <div id="map-canvas"></div>
                                        </div>
                                    </div>

                                    <input type="text" name="vertices" value="" id="vertices" hidden />

                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <button class="btn btn-primary" type="button" id="add_service_areas_btn">
                                                Save Service Area
                                            </button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('common/admin_footer'); ?>
        </div>

    </div>

    <?php $this->load->view('common/admin_scripts'); ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHtMus_lrs1jrXwK9QkltUaAP5rr3UoX0&libraries=drawing,places&v=weekly&channel=2"></script>

    <script type="text/javascript">

        $("#add_service_areas_form").validate();

        $(document).on("click", "#add_service_areas_btn", function(e) {

            if($('#vertices').val() == "") {
                toastr.error("Please draw an area first.");
                return false;
            }

            if($("#add_service_areas_form").valid()) {

                e.preventDefault();
                var formData = $("#add_service_areas_form").serialize();
                var ajaxurl = '<?php echo admin_url().'service_areas/submit_service_areas'; ?>';

                $.ajax({
                    url: ajaxurl,
                    type : 'post',
                    dataType: "json",
                    data: formData,
                    success: function(data ) {
                        if(data.msg =='error') {
                            toastr.error(data.response);
                        } else if(data.msg =='success') {
                            toastr.success(data.response);
                            jQuery('#add_service_areas_form')[0].reset();

                            setTimeout( function() { window.location.href = '<?php echo admin_url().'service_areas'; ?>' }, 1500);
                        }
                    }
                });
            }
        });

        var map;
        var iw = new google.maps.InfoWindow();
        var lat_longs = new Array();
        var markers = new Array();
        var drawingManager;

        function initialize() {
            var myLatlng = new google.maps.LatLng(31.582045, 74.329376);
            var myOptions = {
                zoom: 13,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);

            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);


            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });

            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length == 0) {
                  return;
              }

              const bounds = new google.maps.LatLngBounds();

              places.forEach((place) => {
                  if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                const icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25),
                };

                if (place.geometry.viewport) {
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }

            });
              console.log(bounds);
              map.fitBounds(bounds);
          });

            drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [google.maps.drawing.OverlayType.POLYGON]
                },
                polygonOptions: {
                    editable: true
                }
            });
            drawingManager.setMap(map);

            google.maps.event.addListener(drawingManager, "overlaycomplete", function(event) {
                var newShape = event.overlay;
                newShape.type = event.type;
            });

            google.maps.event.addListener(drawingManager, "overlaycomplete", function(event) {
                overlayClickListener(event.overlay);
                $('#vertices').val(event.overlay.getPath().getArray());
            });
        }

        function overlayClickListener(overlay) {
            google.maps.event.addListener(overlay, "mouseup", function(event) {
                $('#vertices').val(overlay.getPath().getArray());
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);

    </script>

</body>
</html>