//　for image
var image = document.getElementById("Imagecontainer");
var images = [
  "../../assets/backgroundImage/download4.jpeg",
  "../../assets/backgroundImage/images.jpeg",
  "../../assets/backgroundImage/download5.jpeg",
  "../../assets/backgroundImage/download.jpeg",
  "../../assets/backgroundImage/download1.jpeg",
  "../../assets/backgroundImage/download3.jpeg",
]; // Array of image URLs
var currentIndex = 0;

function changeImage() {
  image.src = images[currentIndex];
  currentIndex = (currentIndex + 1) % images.length; // Update current index
}

setInterval(changeImage, 3000);
