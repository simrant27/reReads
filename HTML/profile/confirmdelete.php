<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../CSS/profile/confirmdelete.css">
  <title>Document</title>
</head>
<body>
  <div class="delete_m">
    <button onclick="document.querySelector('.delete_cont').style.display = 'block'">Delete</button>
    <div class="delete_cont">
      <span onclick="document.querySelector('.delete_cont').style.display = 'none'" class="close" title="close">&times;</span>
    <div class="delete_txt">
      <p>Are you sure you want to delete?</p>
    </div>
    <div
    onclick="document.querySelector('.delete_cont').style.display = 'none'"
    class="delete_actions">
      <button class="cancel">
        Cancel
      </button>
<button class="delete">
  Delete
</button>
<input type="hidden" id="bookIdToDelete" name="bookIdToDelete" value="">

    </div>
  </div>
  </div>
</body>


</html>
