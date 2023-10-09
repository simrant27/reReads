



<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../CSS/profile/confirmdelete.css">
      <link rel="stylesheet" href="../../CSS/notification/notification.css">

  <title>Document</title>
</head>
<body>
  <div class="delete_m">
    <label for="notification-toggle" class="notification-icon icon-button">
        <span class="material-icons" onclick="showDeleteConfirmation()">Delete</span>
    </label>
    <div class="delete_cont">
        <span onclick="hideDeleteConfirmation()" class="close" title="close">&times;</span>
        <div class="delete_txt">
            <p>Are you sure you want to delete?</p>
        </div>
        <div onclick="hideDeleteConfirmation()" class="delete-actions">
            <button class="cancel">
                Cancel
            </button>
            <button class="delete" onclick="performDeleteAction()">Delete</button>
        </div>
    </div>
</div>
</body>
<script>
  // deleteConfirmation.js

function showDeleteConfirmation() {
    var deleteCont = document.querySelector('.delete_cont');
    if (deleteCont) {
        deleteCont.style.display = 'block';
    }
}

function hideDeleteConfirmation() {
    var deleteCont = document.querySelector('.delete_cont');
    if (deleteCont) {
        deleteCont.style.display = 'none';
    }
}

// Attach event listeners to your "Delete" button and "Cancel" button
document.addEventListener('DOMContentLoaded', function() {
    var deleteButton = document.querySelector('.notification-icon .material-icons');
    if (deleteButton) {
        deleteButton.addEventListener('click', showDeleteConfirmation);
    }

    var cancelButton = document.querySelector('.delete-actions .cancel');
    if (cancelButton) {
        cancelButton.addEventListener('click', hideDeleteConfirmation);
    }
});

</script>
</html> -->
