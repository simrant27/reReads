const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#password");
const CtogglePassword = document.querySelector("#CtogglePassword");
const Cpassword = document.querySelector("#Cpassword");

togglePassword.addEventListener("click", function (e) {
  // toggle the type attribute
  const type =
    password.getAttribute("type") === "password" ? "text" : "password";
  password.setAttribute("type", type);
  // toggle the eye slash icon
  this.classList.toggle("fa-eye-slash");
});
CtogglePassword.addEventListener("click", function (e) {
  // toggle the type attribute
  const type =
    Cpassword.getAttribute("type") === "password" ? "text" : "password";
  Cpassword.setAttribute("type", type);
  // toggle the eye slash icon
  this.classList.toggle("fa-eye-slash");
});
CtogglePassword.classList.add("fa-eye-slash");
togglePassword.classList.add("fa-eye-slash");
