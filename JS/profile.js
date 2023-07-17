function handleProfilePhotoChange(event) {
  const file = event.target.files[0];
  const reader = new FileReader();

  reader.onload = function(e) {
    const profilePhoto = document.getElementById('profile-photo');
    profilePhoto.src = e.target.result;
  }

  reader.readAsDataURL(file);
}

function openEditForm() {
  const editFormContainer = document.getElementById('edit-form-container');
  editFormContainer.style.display = 'block';
  
  const profileDetails = document.querySelector('.profile-details');
  profileDetails.style.display = 'none';
}

function cancelEditForm() {
  const editFormContainer = document.getElementById('edit-form-container');
  editFormContainer.style.display = 'none';
  
  const profileDetails = document.querySelector('.profile-details');
  profileDetails.style.display = 'block';
}

function saveProfileChanges(event) {
  event.preventDefault();
  
  const nameInput = document.getElementById('edit-name');
  const numberInput = document.getElementById('edit-number');
  const emailInput = document.getElementById('edit-email');
  const addressInput = document.getElementById('edit-address');
  
  const profileName = document.getElementById('profile-name');
  const profileNumber = document.getElementById('profile-number');
  const profileEmail = document.getElementById('profile-email');
  const profileAddress = document.getElementById('profile-address');
  
  profileName.textContent = nameInput.value;
  profileNumber.textContent = `Phone Number: ${numberInput.value}`;
  profileEmail.textContent = `Email: ${emailInput.value}`;
  profileAddress.textContent = `Address: ${addressInput.value}`;
  
  cancelEditForm();
}
function openUploadBookForm() {
  document.getElementById("upload-book-popup").style.display = "block";
}

function closeUploadBookPopup() {
  document.getElementById("upload-book-popup").style.display = "none";
}

function handleUploadBook(event) {
  event.preventDefault();
  const bookPhoto = document.getElementById("book-photo").files[0];
  const bookName = document.getElementById("book-name").value;
  const authorName = document.getElementById("author-name").value;
  const bookLanguage = document.getElementById("book-language").value;
  const publishedDate = document.getElementById("published-date").value;
  const bookPublisher = document.getElementById("book-publisher").value;
  const priceType = document.querySelector('input[name="price-type"]:checked').value;
  let actualPrice = "";
  let sellingPrice = "";

  if (priceType === "sale") {
    actualPrice = document.getElementById("actual-price").value;
    sellingPrice = document.getElementById("selling-price").value;
  }

  // Perform necessary actions with the book details
  // Example: send data to server, update UI, etc.

  closeUploadBookPopup(); // Close the popup after handling the submission
}

function togglePriceFields(show) {
  const priceFields = document.querySelector('.price-fields');
  priceFields.style.display = show ? 'block' : 'none';
}

function openEditForm() {
  const editFormContainer = document.getElementById("edit-form-container");
  editFormContainer.style.display = "block";

  // Populate the form fields with current profile details
  const profileName = document.getElementById("profile-name").textContent;
  const profileNumber = document.getElementById("profile-number").textContent;
  const profileEmail = document.getElementById("profile-email").textContent;
  const profileAddress = document.getElementById("profile-address").textContent;

  document.getElementById("edit-name").value = profileName;
  document.getElementById("edit-number").value = profileNumber;
  document.getElementById("edit-email").value = profileEmail;
  document.getElementById("edit-address").value = profileAddress;
}

function saveProfileChanges(event) {
  event.preventDefault();
  
  // Get the updated values from the form fields
  const updatedName = document.getElementById("edit-name").value;
  const updatedNumber = document.getElementById("edit-number").value;
  const updatedEmail = document.getElementById("edit-email").value;
  const updatedAddress = document.getElementById("edit-address").value;

  // Update the profile details with the new values
  document.getElementById("profile-name").textContent = updatedName;
  document.getElementById("profile-number").textContent = "Phone Number: " + updatedNumber;
  document.getElementById("profile-email").textContent = "Email: " + updatedEmail;
  document.getElementById("profile-address").textContent = "Address: " + updatedAddress;

  // Close the edit form
  cancelEditForm();
}

function cancelEditForm() {
  const editFormContainer = document.getElementById("edit-form-container");
  editFormContainer.style.display = "none";
}
