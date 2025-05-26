<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'botania';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM craftingrecipes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container my-4">
    <?php if ($result->num_rows > 0): ?>
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>RecipeID</th>
                <th>Result</th>
                <th>Ingredient 1</th>
                <th>Ingredient 2</th>
                <th>Ingredient 3</th>
                <th>Crafting Type</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['RecipeID']) ?></td>
                <td><?= htmlspecialchars($row['Result']) ?></td>
                <td><?= htmlspecialchars($row['Ingredient1']) ?></td>
                <td><?= htmlspecialchars($row['Ingredient2']) ?></td>
                <td><?= htmlspecialchars($row['Ingredient3'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['CraftingType'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['Amount']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <div class="alert alert-warning">No crafting recipes found.</div>
    <?php endif; ?>
</div>
</body>
</html>

<?php
$conn->close();
?>
