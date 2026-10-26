<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenujs/metismenujs.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/eva-icons/eva.min.js') }}"></script>

        <!-- apexcharts -->
        <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

        <!-- Vector map-->
        <script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
        <script src="{{ asset('assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

        <script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>

        <script src="{{ asset('assets/js/app.js') }}"></script>
          <!-- gridjs js -->
          <script src="{{ asset('assets/libs/gridjs/gridjs.umd.js') }}"></script>

          <script src="{{ asset('assets/js/pages/gridjs.init.js') }}"></script>
          <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
          <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
          <!-- Buttons examples -->
          <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
          <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
          <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
          <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
          <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
          <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
          <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
          <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

          <!-- Responsive examples -->
          <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
          <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
          <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.colVis.min.js"></script>
          <!-- Datatable init js -->
          <!-- choices js -->
        <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
          {{-- <script src="assets/libs/gridjs/gridjs.umd.js"></script> --}}
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script> --}}
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script> --}}
<!-- choices js -->
<!-- Plugins js -->
<script src="{{ asset('assets/libs/dropzone/min/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
{{-- <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script> --}}
 <!-- Sweet Alerts js -->
 <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

 <!-- Sweet alert init js-->
 <script src="{{ asset('assets/js/pages/sweet-alerts.init.js') }}"></script>
 <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
 <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>


{{-- <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script> --}}

<script>
  var id;
  var alertPlaceholder = document.getElementById("liveAlertPlaceholder");
//   setInterval(function() {
//       if (sessionStorage.getItem("last_id") != null) {

//           var settings = {
//               "url": "api/notifications/company/{{ Auth::user()->company_id }}/{{ Auth::user()->id }}",
//               "method": "GET",
//               "timeout": 0,
//           };

//           $.ajax({
//               ...settings,
//               statusCode: {
//                   200: function(response) {

//                       // console.log("LENGTH=====" + response.length);


//                       if (response.length >= 1) {


//                           if (sessionStorage.getItem("last_id") == response[0]['id']) {
//                               // console.log(response[0]['id']);
//                           } else {


//                               alerts(response[0]['data'], "primary")

//                               sessionStorage.setItem("last_id", response[0]['id']);
//                           }
//                       }

//                   },
//                   // Add more status code handlers as needed
//               },
//               success: function(data) {
//                   // Additional success handling if needed
//               },
//               error: function(xhr, textStatus, errorThrown) {


//                   // console.log("Request failed with status code: " + xhr.status);
//               }
//           });
//       } else {
//           var settingsx = {
//               "url": "api/notifications",
//               "method": "GET",
//               "timeout": 0,
//           };

//           $.ajax({
//               ...settingsx,
//               statusCode: {
//                   200: function(response) {
//                       console.log("First Time");

//                       sessionStorage.setItem("last_id", response[0]['id']);

//                   },
//                   // Add more status code handlers as needed
//               },
//               success: function(data) {
//                   // Additional success handling if needed
//               },
//               error: function(xhr, textStatus, errorThrown) {


//                   // console.log("Request failed with status code: " + xhr.status);
//               }
//           });

//       }


//   }, 20000);

//   function alerts(e, t) {
//       var l = document.createElement("div");
//       l.innerHTML = '<div class="alert alert-' + t +
//           ' alert-dismissible" role="alert">' + e +
//           '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
//           alertPlaceholder.append(l)
//   }
</script>
