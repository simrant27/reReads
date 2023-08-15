var images = [
  "../../assets/backgroundImage/download4.jpeg",
  "../../assets/backgroundImage/images.jpeg",
  "../../assets/backgroundImage/download3.jpeg",
  "../../assets/backgroundImage/download.jpeg",
  "../../assets/backgroundImage/download1.jpeg",
];
var currentIndex = 0;
var bgimg = document.getElementById("bg-img");
function changeImage() {
  bgimg.style.backgroundImage = `url(${images[currentIndex]})`;

  currentIndex = (currentIndex + 1) % images.length;
}

setInterval(changeImage, 5000);
