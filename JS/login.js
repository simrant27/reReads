const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#password");

togglePassword.addEventListener("click", function (e) {
  // toggle the type attribute
  const type =
    password.getAttribute("type") === "password" ? "text" : "password";
  password.setAttribute("type", type);
  // toggle the eye slash icon
  this.classList.toggle("fa-eye-slash");
});

togglePassword.classList.add("fa-eye-slash");

//　for image
var image = document.getElementById("Imagecontainer");
var images = [
  "../assets/download (1).jpeg",
  "../assets/download (2).jpeg",
  "../assets/download.jpeg",
]; // Array of image URLs
var currentIndex = 0;

function changeImage() {
  image.src = images[currentIndex];
  currentIndex = (currentIndex + 1) % images.length; // Update current index
}

setInterval(changeImage, 3000);
