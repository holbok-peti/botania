<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Botania Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="p-3">

  <div class="container">
    <h1>Botania Dashboard</h1>

    <div class="btn-group mb-3" role="group">
      <button class="btn btn-primary" data-page="craftingrecipes.php">Crafting Recipes</button>
      <button class="btn btn-primary" data-page="flowers.php">Flowers</button>
      <button class="btn btn-primary" data-page="functionalblocks.php">Functional Blocks</button>
      <button class="btn btn-primary" data-page="petals.php">Petals</button>
      <button class="btn btn-primary" data-page="seeds.php">Seeds</button>
      <button class="btn btn-primary" data-page="flower_game.php">Flower Connection Game</button>
    </div>

    <form id="searchForm" class="mb-3" onsubmit="return false;">
      <div class="input-group">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by name or color..." />
        <button type="submit" class="btn btn-success">Search</button>
      </div>
    </form>


    <div id="contentArea">
      <p>Welcome! Click a category or search to get started.</p>
    </div>
  </div>

<script>
$(function() {

  $('.btn-group button').click(function() {
    let page = $(this).data('page');
    $('#contentArea').html('<p>Loading...</p>');
    $.get(page, function(data) {
      $('#contentArea').html(data);
    });
  });

  $('#searchForm').submit(function() {
    let query = $('#searchInput').val().trim();
    if (!query) {
      alert('Please enter a search term');
      return false;
    }
    $('#contentArea').html('<p>Searching...</p>');
    $.get('search.php', { q: query }, function(data) {
      $('#contentArea').html(data);
    });
    return false; 
  });
});
</script>

</body>
</html>
