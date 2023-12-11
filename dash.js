function handleAdd() {
  //  submit
  var form = document.getElementById("sign-up-form");
  //check if form is valid
  var email = document.getElementById("email").value;
  var password = document.getElementById("psw").value;
  var firstname = document.getElementById("firstname").value;
  var lastname = document.getElementById("lastname").value;
  var role = document.getElementById("role").value;

  //validate and submit


  form.submit();


}

function openNav() {
  document.getElementById("dashSidenav").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
  document.getElementById("dashSidenav").style.width = "0";
  document.getElementById("main").style.marginLeft = "0";
}

window.onload = function () {
  var myform = document.querySelector('#myform');

  myform.addEventListener('submit', function (element) {
    console.log('form submitted');
    var validationFailed = false;

    var firstname = document.querySelector('#firstname');
    var lastname = document.querySelector('#lastname');
    var telephone = document.querySelector('#telephone');
    var email = document.querySelector('#email');
    var website = document.querySelector('#website');
    var role = document.querySelector('#role');

    // clear any previous error messages
    clearErrors();

    if (isEmpty(firstname.value.trim())) {
      validationFailed = true;
      //alert('You must fill in your First Name');
      displayErrorMessage(firstname, "You must fill in your First Name");
    };

    if (isEmpty(lastname.value.trim())) {
      validationFailed = true;
      // alert('You must fill in your Last Name');
      displayErrorMessage(lastname, "You must fill in your Last Name");
    }

    if (!isValidTelephoneNumber(telephone.value.trim())) {
      validationFailed = true;
      //alert('Incorrect format for telephone number.');
      displayErrorMessage(telephone, "Incorrect format for telephone number.");
    };

    if (!isValidEmail(email.value.trim())) {
      validationFailed = true;
      //alert('Incorrect format for email.');
      displayErrorMessage(email, "Incorrect format for email address.");
    };

    if (!isValidUrl(website.value.trim())) {
      validationFailed = true;
      //alert('Incorrect format for email.');
      displayErrorMessage(website, "Incorrect format for URL.");
    };

    if (validationFailed) {
      console.log('Please fix issues in Form submission and try again.');
      element.preventDefault();
    }
  });
};

/**
 * Check if value for a field is empty.
 */
function isEmpty(elementValue) {
  if (elementValue.length == 0) {
    // Or you could check if the value == ""
    console.log('field is empty');
    return true;
  }

  return false;
}

/**
 * Check if a valid telephone number was entered.
 */
function isValidTelephoneNumber(telephoneNumber) {
  return /^\d{3}-\d{3}-\d{4}$/.test(telephoneNumber);
}

/**
 * Check if a valid email address was entered.
 */
function isValidEmail(emailAddress) {
  return /^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/.test(emailAddress);
}

function isValidUrl(websiteAddress) {
  return /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$/i.test(websiteAddress);
}






