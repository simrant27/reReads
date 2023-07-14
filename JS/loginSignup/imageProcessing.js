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
