var form = document.getElementById("myForm");
var nameField = document.getElementById("name");
var emailField = document.getElementById("email");
var passwordField = document.getElementById("password");

form.addEventListener("submit", function (event) {
  event.preventDefault(); // Prevent form submission

  // Validate email field
  if (!validateEmail(emailField.value)) {
    alert("Please enter a valid email address.");
    return;
  }

  // Validate password field
  if (!validatePassword(passwordField.value)) {
    alert(
      "Please enter a valid password (at least 8 characters with at least one uppercase letter, one lowercase letter, and one digit ."
    );
    return;
  }
  // Validate name field
  if (!validateName(nameField.value)) {
    alert("Please enter a valid name.");
    return;
  }
  // If all validations pass, you can submit the form or perform further actions
  alert("Form submitted successfully!");
});

function validateEmail(email) {
  // Regex pattern for email validation
  var pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return pattern.test(email);
}

function validatePassword(password) {
  // Regex pattern for password validation (at least 8 characters with at least one uppercase letter, one lowercase letter, and one digit)
  var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
  return pattern.test(password);
}

function validateName(name) {
  // Regex pattern for name validation (allow only letters and spaces)
  var pattern = /^[a-zA-Z\s]+$/;
  return pattern.test(name);
}
