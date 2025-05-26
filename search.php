<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'botania';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($search === '') {
    echo '<div class="alert alert-warning">Please enter a search term.</div>';
    exit;
}

$search_esc = $conn->real_escape_string("%$search%");

echo "<h3>Search results for: " . htmlspecialchars($search) . "</h3>";

// Helper function to output table for each query result
function outputTable($title, $columns, $rows) {
    if (count($rows) === 0) {
        echo "<div class='alert alert-secondary'>No $title found.</div>";
        return;
    }

    echo "<h4>$title</h4>";
    echo "<table class='table table-striped table-bordered'>";
    echo "<thead class='table-dark'><tr>";
    foreach ($columns as $colName) {
        echo "<th>" . htmlspecialchars($colName) . "</th>";
    }
    echo "</tr></thead><tbody>";

    foreach ($rows as $row) {
        echo "<tr>";
        foreach ($columns as $colKey => $colName) {
            // Allow numeric keys for colName = colKey, or associative array colKey => colName
            if (is_int($colKey)) {
                $val = $row[$colName];
            } else {
                $val = $row[$colKey];
            }
            echo "<td>" . nl2br(htmlspecialchars($val)) . "</td>";
        }
        echo "</tr>";
    }
    echo "</tbody></table>";
}

// 1. Search craftingrecipes by Result (name)
$sql1 = "SELECT RecipeID, Result, Ingredient1, Ingredient2, Ingredient3 FROM craftingrecipes WHERE Result LIKE '$search_esc'";
$res1 = $conn->query($sql1);
$craftingRows = [];
if ($res1) {
    while($r = $res1->fetch_assoc()) $craftingRows[] = $r;
}
outputTable('Crafting Recipes', ['RecipeID', 'Result', 'Ingredient1', 'Ingredient2', 'Ingredient3'], $craftingRows);

// 2. Search flowers by Name
$sql2 = "SELECT FlowerID, Name, Type, ManaUsage FROM flowers WHERE Name LIKE '$search_esc'";
$res2 = $conn->query($sql2);
$flowerRows = [];
if ($res2) {
    while($r = $res2->fetch_assoc()) $flowerRows[] = $r;
}
outputTable('Flowers', ['FlowerID', 'Name', 'Type', 'ManaUsage'], $flowerRows);

// 3. Search functionalblocks by Name
$sql3 = "SELECT BlockID, Name, AutomationType FROM functionalblocks WHERE Name LIKE '$search_esc'";
$res3 = $conn->query($sql3);
$blockRows = [];
if ($res3) {
    while($r = $res3->fetch_assoc()) $blockRows[] = $r;
}
outputTable('Functional Blocks', ['BlockID', 'Name', 'AutomationType'], $blockRows);

// 4. Search items by Name
$sql4 = "SELECT ItemID, Name, Category FROM items WHERE Name LIKE '$search_esc'";
$res4 = $conn->query($sql4);
$itemRows = [];
if ($res4) {
    while($r = $res4->fetch_assoc()) $itemRows[] = $r;
}
outputTable('Items', ['ItemID', 'Name', 'Category'], $itemRows);

// 5. Search petals by Color (assuming 'Color' is like 'name' here)
$sql5 = "SELECT PetalID, Color, Rarity FROM petals WHERE Color LIKE '$search_esc'";
$res5 = $conn->query($sql5);
$petalRows = [];
if ($res5) {
    while($r = $res5->fetch_assoc()) $petalRows[] = $r;
}
outputTable('Petals', ['PetalID', 'Color', 'Rarity'], $petalRows);

// 6. Search seeds by Color
$sql6 = "SELECT SeedID, Color, Rarity FROM seeds WHERE Color LIKE '$search_esc'";
$res6 = $conn->query($sql6);
$seedRows = [];
if ($res6) {
    while($r = $res6->fetch_assoc()) $seedRows[] = $r;
}
outputTable('Seeds', ['SeedID', 'Color', 'Rarity'], $seedRows);

$conn->close();
?>
