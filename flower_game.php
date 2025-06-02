<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'botania';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT FlowerID, Name, Abilities FROM flowers ORDER BY RAND() LIMIT 5";
$result = $conn->query($sql);

$flowers = [];
while ($row = $result->fetch_assoc()) {
    $flowers[] = $row;
}
$conn->close();

if (count($flowers) < 5) {
    echo "<div class='alert alert-warning'>Not enough flowers in database for the game.</div>";
    exit;
}

$allNames = array_column($flowers, 'Name');
$allUses = array_map(function($f) { return $f['Abilities']; }, $flowers);

function shuffleOptions($correct, $all) {
    $options = array_filter($all, fn($a) => $a !== $correct);
    shuffle($options);
    $options = array_slice($options, 0, 4);
    $options[] = $correct;
    shuffle($options);
    return $options;
}
?>

<div class="container">
  <h2>Flower Connection Game</h2>
  <p>Pick the correct name and use for the flower image. Max score: 10</p>
  <div id="score" class="mb-3">Score: 0</div>

  <div id="gameArea"></div>

  <button id="nextBtn" class="btn btn-primary mt-3" style="display:none;">Next</button>
  <div id="result" class="mt-3"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const flowers = <?= json_encode($flowers); ?>;
let score = 0;
let currentIndex = 0;

function shuffleArray(arr) {
  for (let i = arr.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [arr[i], arr[j]] = [arr[j], arr[i]];
  }
}

function createOptions(correct, all) {
  const options = all.filter(a => a !== correct);
  shuffleArray(options);
  const selected = options.slice(0,4);
  selected.push(correct);
  shuffleArray(selected);
  return selected;
}

function renderQuestion() {
  $('#result').text('');
  if(currentIndex >= flowers.length) {
    $('#gameArea').html(`<h4>Game over! Final score: ${score} / 10</h4>`);
    $('#nextBtn').hide();
    return;
  }
  
  let flower = flowers[currentIndex];
  let allNames = flowers.map(f => f.Name);
  let allUses = flowers.map(f => f.Abilities);

  allUses = allUses.filter(a => a && a.trim() !== '');

  let nameOptions = createOptions(flower.Name, allNames);
  let useOptions = createOptions(flower.Abilities, allUses);

  let imgSrc = `img/${encodeURIComponent(flower.Name)}.png`;

  let html = `
    <div class="text-center mb-3">
      <img src="${imgSrc}" alt="${flower.Name}" style="max-height:200px; max-width:200px; object-fit:contain; border:1px solid #ccc;"/>
    </div>
    <div>
      <strong>Pick the correct flower name:</strong>
      <div class="btn-group" role="group" id="nameOptions">`;
  nameOptions.forEach(opt => {
    html += `<button type="button" class="btn btn-outline-primary option-btn" data-type="name" data-val="${opt}">${opt}</button>`;
  });
  html += `</div></div><br/>`;

  html += `
    <div>
      <strong>Pick the correct use/ability of this flower:</strong>
      <div class="btn-group" role="group" id="useOptions">`;
  useOptions.forEach(opt => {
    html += `<button type="button" class="btn btn-outline-secondary option-btn" data-type="use" data-val="${opt}">${opt}</button>`;
  });
  html += `</div></div>`;

  $('#gameArea').html(html);
  $('#nextBtn').hide();

  selectedName = null;
  selectedUse = null;

  $('.option-btn').click(function() {
    const type = $(this).data('type');
    if(type === 'name') {
      $('#nameOptions .btn').removeClass('active');
      $(this).addClass('active');
      selectedName = $(this).data('val');
    } else {
      $('#useOptions .btn').removeClass('active');
      $(this).addClass('active');
      selectedUse = $(this).data('val');
    }

    if(selectedName && selectedUse) {
      let correctName = flower.Name;
      let correctUse = flower.Abilities;

      let nameCorrect = (selectedName === correctName);
      let useCorrect = (selectedUse === correctUse);

      if(nameCorrect && useCorrect) {
        score++;
        $('#result').html('<div class="alert alert-success">Correct! +1 point.</div>');
      } else {
        $('#result').html(`<div class="alert alert-danger">Incorrect. Correct name: <strong>${correctName}</strong>, use: <strong>${correctUse}</strong></div>`);
      }
      $('#score').text(`Score: ${score}`);
      $('#nextBtn').show();
      $('.option-btn').attr('disabled', true);
    }
  });
}

let selectedName = null;
let selectedUse = null;

$('#nextBtn').click(function() {
  currentIndex++;
  if(score >= 10) {
    $('#gameArea').html(`<h4>Congratulations! You scored 10 points!</h4>`);
    $('#nextBtn').hide();
    $('#result').hide();
    return;
  }
  renderQuestion();
});

renderQuestion();
</script>
