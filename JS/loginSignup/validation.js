var form = document.getElementById("myForm");
var name = document.getElementById("name");
var email = document.getElementById("email");
var password = document.getElementById("password");
var Cpassword = document.getElementById("Cpassword");
var phoneNumber = document.getElementById("PhoneNumber");
var address = document.getElementById("Address");
var signupButton = document.getElementById("signup");

form.addEventListener("submit", (e) => {
  e.preventDefault();

  validateInputs().then((isValid) => {
    if (isValid) {
      // If validation is successful, submit the form to the PHP script
      form.submit();
    }
  });
});

const setError = (element, message) => {
  const inputControl = element.parentElement;
  const errorDisplay = inputControl.querySelector(".error");

  errorDisplay.innerText = message;
  inputControl.classList.add("error");
  inputControl.classList.remove("success");
};

const setSuccess = (element) => {
  const inputControl = element.parentElement;
  const errorDisplay = inputControl.querySelector(".error");

  errorDisplay.innerText = "";
  inputControl.classList.add("success");
  inputControl.classList.remove("error");
};

const isValidEmail = (email) => {
  const re =
    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
};

const isValidPhone = (phoneNumber) => {
  const phoneNO = /^[0-9]{10}$/;
  return phoneNO.test(String(phoneNumber));
};

const validateInputs = () => {
  return new Promise((resolve) => {
    const nameValue = name.value.trim();
    const emailValue = email.value.trim();
    const passwordValue = password.value.trim();
    const confirmPasswordValue = Cpassword.value.trim();
    const addressValue = address.value.trim();
    const phoneNumberValue = phoneNumber.value.trim();

    if (nameValue === "") {
      setError(name, "Username is required");
    } else {
      setSuccess(name);
    }

    if (addressValue === "") {
      setError(address, "Address is required");
    } else {
      setSuccess(address);
    }

    if (phoneNumberValue === "") {
      setError(phoneNumber, "Phone number is required");
    } else if (!isValidPhone(phoneNumberValue)) {
      setError(
        phoneNumber,
        "Invalid phone number format. Please enter a 10-digit numeric phone number without spaces or special characters."
      );
    } else {
      setSuccess(phoneNumber);
    }

    if (emailValue === "") {
      setError(email, "Email is required");
    } else if (!isValidEmail(emailValue)) {
      setError(email, "Provide a valid email address");
    } else {
      setSuccess(email);
    }

    if (passwordValue === "") {
      setError(password, "Password is required");
    } else if (passwordValue.length < 8) {
      setError(password, "Password must be at least 8 characters long.");
    } else {
      setSuccess(password);
    }

    if (confirmPasswordValue === "") {
      setError(Cpassword, "Please confirm your password");
    } else if (confirmPasswordValue !== passwordValue) {
      setError(Cpassword, "Passwords do not match");
    } else {
      setSuccess(Cpassword);
    }

    // After all validations are done, check if there are any errors
    // If there are no errors, resolve the promise with true
    // If there are errors, resolve the promise with false
    resolve(
      !name.parentElement.classList.contains("error") &&
        !email.parentElement.classList.contains("error") &&
        !password.parentElement.classList.contains("error") &&
        !Cpassword.parentElement.classList.contains("error") &&
        !phoneNumber.parentElement.classList.contains("error") &&
        !address.parentElement.classList.contains("error")
    );
  });
};
