<!DOCTYPE html>
<html>
  <head>
    <title>The Old Mountain</title>
    <link rel="icon" type="image/x-icon" href="theoldmountain.ico"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="includes/css/style.css" type="text/css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js" type="text/javascript"></script>
  </head>

  <body>
    <section class="logo-container">
      <div class="row">
        <div class="col-12">
          <div class="logo animate__animated animate__fadeInUp">
            <img src="includes/img/logos/theoldmountain2.png">
          </div>
          <div class="description animate__animated animate__fadeInUp">
            <!-- ᚩᛚᛞ ᛘᚩᚢᚾᛏᚪᛁᚾ ᚷᚱᚩᚢᛈ -->
          </div>
          <div class="access_code animate__animated animate__fadeInUp">
            <input id="uintTextBox" type="password" pattern="[0-9]" name="access_code" placeholder="Enter Access Code" maxlength = "4"></input>
            <br />
          </div>
        </div>
      </div>
    </section>
  </body>

  <script type"text/js">
  // Restricts input for each element in the set of matched elements to the given inputFilter.
  (function($) {
    $.fn.inputFilter = function(inputFilter) {
      return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
        if (inputFilter(this.value)) {
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
          this.value = "";
        }
      });
    };
  }(jQuery));


  // Install input filters.
  $("#intTextBox").inputFilter(function(value) {
    return /^-?\d*$/.test(value); });
  $("#uintTextBox").inputFilter(function(value) {
    return /^\d*$/.test(value); });
  $("#intLimitTextBox").inputFilter(function(value) {
    return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 500); });
  $("#floatTextBox").inputFilter(function(value) {
    return /^-?\d*[.,]?\d*$/.test(value); });
  $("#currencyTextBox").inputFilter(function(value) {
    return /^-?\d*[.,]?\d{0,2}$/.test(value); });
  $("#latinTextBox").inputFilter(function(value) {
    return /^[a-z]*$/i.test(value); });
  $("#hexTextBox").inputFilter(function(value) {
    return /^[0-9a-f]*$/i.test(value); });
  </script>
</html>
