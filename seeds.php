<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'botania';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM seeds";
$result = $conn->query($sql);
?>

<?php if ($result->num_rows > 0): ?>
<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>SeedID</th>
            <th>Color</th>
            <th>Crafting Recipe</th>
            <th>Used For</th>
            <th>Rarity</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['SeedID']) ?></td>
            <td><?= htmlspecialchars($row['Color']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['CraftingRecipe'] ?? '')) ?></td>
            <td><?= nl2br(htmlspecialchars($row['UsedFor'] ?? '')) ?></td>
            <td><?= ($row['Rarity'] ? 'Rare' : 'Common') ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
<div class="alert alert-warning">No seeds found.</div>
<?php endif; ?>

<?php $conn->close(); ?>
