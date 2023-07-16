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
