<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'botania';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM flowers";
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
    <table class="table table-striped table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>FlowerID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Mana Usage</th>
                <th>Abilities</th>
                <th>Crafting Recipe</th>
                <th>World Gen Type</th>
                <th>Biome</th>
                <th>Spawn Rate</th>
                <th>Is Rare</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['FlowerID']) ?></td>
                <td><?= htmlspecialchars($row['Name']) ?></td>
                <td><?= htmlspecialchars($row['Type'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['ManaUsage'] ?? '') ?></td>
                <td><?= nl2br(htmlspecialchars($row['Abilities'] ?? '')) ?></td>
                <td><?= nl2br(htmlspecialchars($row['CraftingRecipe'] ?? '')) ?></td>
                <td><?= htmlspecialchars($row['WorldGenType'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['Biome'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['SpawnRate'] ?? '') ?></td>
                <td><?= ($row['IsRare'] ? 'Yes' : 'No') ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <div class="alert alert-warning">No flowers found.</div>
    <?php endif; ?>
</div>
</body>
</html>

<?php
$conn->close();
?>
