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
  var uploadWindow = window.open("", "_blank", "width=400,height=500");
  uploadWindow.document.write(`
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Upload Book</title>
      <style>
        /* Styles for the form and other elements */

        body {
          font-family: "Arial", sans-serif;
          background-color: #f8f8f8;
        }

        h1 {
          font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
          font-size: 24px;
          font-weight: bold;
          margin-bottom: 20px;
          color: #333;
        }

        form {
          font-size: 16px;
        }

        .form-row {
          display: flex;
          align-items: center;
          margin-bottom: 15px;
        }

        label {
          font-weight: bold;
          font-family: "Roboto", Arial, sans-serif;
          flex-basis: 30%;
          color: #333;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
          padding: 8px;
          font-family: "Courier New", monospace;
          font-size: 14px;
          border: 1px solid #ccc;
          border-radius: 4px;
          flex-basis: 70%;
        }

        .radio-group {
          display: flex;
          align-items: center;
        }

        .radio-group label {
          margin-right: 10px;
        }

        .additional-form {
          display: none;
        }

        button[type="submit"] {
          padding: 10px 20px;
          font-family: "Montserrat", Arial, sans-serif;
          font-size: 16px;
          background-color: #4CAF50;
          color: white;
          border: none;
          cursor: pointer;
          border-radius: 4px;
        }
      </style>
    </head>
    <body>
      <h1>Upload Book</h1>
      <form id="upload-form" onsubmit="submitBook(event)">
        <div class="form-row">
          <label for="book-name">Book Name:</label>
          <input type="text" id="book-name" name="book-name" required>
        </div>
        <div class="form-row">
          <label for="author-name">Author Name:</label>
          <input type="text" id="author-name" name="author-name" required>
        </div>
        <div class="form-row">
          <label for="genre">Genre:</label>
          <input type="text" id="genre" name="genre" required>
        </div>
        <div class="form-row">
          <label for="language">Language:</label>
          <input type="text" id="language" name="language" required>
        </div>
        <div class="form-row">
          <label for="published-date">Published Date:</label>
          <input type="text" id="published-date" name="published-date" placeholder="mm/dd/yyyy" required>
        </div>
        <div class="form-row">
          <label for="publisher">Publisher:</label>
          <input type="text" id="publisher" name="publisher" required>
        </div>
        <div class="form-row">
          <label for="actual-price">Actual Price:</label>
          <input type="number" id="actual-price" name="actual-price" required>
        </div>
        <div class="form-row">
          <label for="transaction-type">Transaction Type:</label>
          <div class="radio-group">
            <label for="donate">
              <input type="radio" id="donate" name="transaction-type" value="donate" required>
              Donate
            </label>
            <label for="sale">
              <input type="radio" id="sale" name="transaction-type" value="sale" required onclick="toggleAdditionalForm(this)">
              Sale
            </label>
          </div>
        </div>
        <div class="additional-form">
          <div class="form-row">
            <label for="selling-price">Selling Price:</label>
            <input type="number" id="selling-price" name="selling-price" required>
          </div>
          <div class="form-row">
            <label for="actual-price-sale">Actual Price:</label>
            <input type="number" id="actual-price-sale" name="actual-price-sale" required>
          </div>
        </div>
        <button type="submit">Upload</button>
      </form>
      <script>
        function toggleAdditionalForm(radio) {
          var additionalForm = document.querySelector('.additional-form');
          additionalForm.style.display = radio.checked ? 'block' : 'none';
        }

        function submitBook(event) {
          event.preventDefault();
          // Handle the form submission and book upload logic here
          // You can access the form data using the DOM API
          var bookName = document.getElementById('book-name').value;
          var authorName = document.getElementById('author-name').value;
          var genre = document.getElementById('genre').value;
          var language = document.getElementById('language').value;
          var publishedDate = document.getElementById('published-date').value;
          var publisher = document.getElementById('publisher').value;
          var actualPrice = document.getElementById('actual-price').value;
          var transactionType = document.querySelector('input[name="transaction-type"]:checked').value;
          var sellingPrice = document.getElementById('selling-price').value;
          var actualPriceSale = document.getElementById('actual-price-sale').value;

          // Add your logic to handle the form submission
        }
      </script>
    </body>
    </html>
`);




  uploadWindow.document.close();
}


