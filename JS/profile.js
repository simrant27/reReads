function handleProfilePhotoChange(event) {
  const file = event.target.files[0];
  const reader = new FileReader();

  reader.onload = function (e) {
    const profilePhoto = document.getElementById("profile-photo");
    profilePhoto.src = e.target.result;
  };

  reader.readAsDataURL(file);
}

function openEditForm() {
  const editProfilePopup = document.getElementById("edit-profile-popup");
  editProfilePopup.style.display = "block";

  const profileDetails = document.querySelector(".profile-details");
  profileDetails.style.display = "none";

  // Populate form fields with current profile data
  const profileName = document.getElementById("profile-name").textContent;
  const profileNumber = document.getElementById("profile-number").textContent;
  const profileEmail = document.getElementById("profile-email").textContent;
  const profileAddress = document.getElementById("profile-address").textContent;

  document.getElementById("edit-name").value = profileName;
  document.getElementById("edit-number").value = profileNumber.replace(
    "Phone Number: ",
    ""
  );
  document.getElementById("edit-email").value = profileEmail.replace(
    "Email: ",
    ""
  );
  document.getElementById("edit-address").value = profileAddress.replace(
    "Address: ",
    ""
  );
}

function closeEditProfilePopup() {
  const editProfilePopup = document.getElementById("edit-profile-popup");
  editProfilePopup.style.display = "none";

  const profileDetails = document.querySelector(".profile-details");
  profileDetails.style.display = "block";
}

// function saveProfileChanges(event) {
//   event.preventDefault();

//   const nameInput = document.getElementById("edit-name");
//   const numberInput = document.getElementById("edit-number");
//   const emailInput = document.getElementById("edit-email");
//   const addressInput = document.getElementById("edit-address");

//   const profileName = document.getElementById("profile-name");
//   const profileNumber = document.getElementById("profile-number");
//   const profileEmail = document.getElementById("profile-email");
//   const profileAddress = document.getElementById("profile-address");

//   profileName.textContent = nameInput.value;
//   profileNumber.textContent = `${numberInput.value}`;
//   profileEmail.textContent = `${emailInput.value}`;
//   profileAddress.textContent = `${addressInput.value}`;

//   closeEditProfilePopup();
// }

function openUploadBookForm() {
  document.getElementById("upload-book-popup").style.display = "block";
}

function closeUploadBookPopup() {
  document.getElementById("upload-book-popup").style.display = "none";
}

// function handleUploadBook(event) {
//   event.preventDefault();

//   const bookPhoto = document.getElementById("book-photo").files[0];
//   const bookName = document.getElementById("book-name").value;
//   const authorName = document.getElementById("author-name").value;
//   const bookLanguage = document.getElementById("genre").value;
//   const publishedYear = document.getElementById("published-year").value;
//   const bookPublisher = document.getElementById("book-publisher").value;
//   const priceType = document.querySelector(
//     'input[name="price-type"]:checked'
//   ).value;

//   let actualPrice = "";
//   let sellingPrice = "";

//   if (priceType === "sale") {
//     actualPrice = document.getElementById("actual-price").value;
//     sellingPrice = document.getElementById("selling-price").value;
//   }

//   closeUploadBookPopup();
// }

function togglePriceFields(show) {
  const priceFields = document.querySelector(".price-fields");
  priceFields.style.display = show ? "block" : "none";

  const actualPriceInput = document.getElementById("actual-price");
  actualPriceInput.required = show;

  const sellingPriceInput = document.getElementById("selling-price");
  sellingPriceInput.required = show;
}

// Add event listener to upload button
document
  .getElementById("upload-button")
  .addEventListener("click", function (event) {
    const priceType = document.querySelector(
      'input[name="price-type"]:checked'
    ).value;

    if (priceType === "donate") {
      handleDonateBook(event);
    } else if (priceType === "sale") {
      handleUploadBook(event);
    }
  });

// Add event listener to price type radio buttons
const donateRadio = document.getElementById("donate-radio");
donateRadio.addEventListener("change", function () {
  togglePriceFields(false);
});

const saleRadio = document.getElementById("sale-radio");
saleRadio.addEventListener("change", function () {
  togglePriceFields(true);
});

// Add event listener to edit button
document.getElementById("edit-button").addEventListener("click", openEditForm);

// Add event listener to cancel button in edit form
// document
//   .getElementById("edit-form")
//   .addEventListener("submit", saveProfileChanges);

// Add event listener to cancel button in edit form
document
  .getElementById("cancel-button")
  .addEventListener("click", closeEditProfilePopup);
