<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'botania';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM functionalblocks";
$result = $conn->query($sql);
?>

<?php if ($result->num_rows > 0): ?>
<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>BlockID</th>
            <th>Name</th>
            <th>Automation Type</th>
            <th>Description</th>
            <th>Crafting Recipe</th>
            <th>Uses Mana</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['BlockID']) ?></td>
            <td><?= htmlspecialchars($row['Name']) ?></td>
            <td><?= htmlspecialchars($row['AutomationType']) ?></td>
            <td><?= nl2br(htmlspecialchars($row['Description'] ?? '')) ?></td>
            <td><?= nl2br(htmlspecialchars($row['CraftingRecipe'] ?? '')) ?></td>
            <td><?= ($row['UsesMana'] ? 'Yes' : 'No') ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
<div class="alert alert-warning">No functional blocks found.</div>
<?php endif; ?>

<?php $conn->close(); ?>
