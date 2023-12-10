document.addEventListener("DOMContentLoaded", function () {
    var switchTypeButton = document.querySelector('#switch-type');
  
      switchTypeButton.addEventListener('click', function() {
      console.log('Switch to Type Button Pressed.');});

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.open("GET", "details.php?");
      xmlhttp.send();
  });