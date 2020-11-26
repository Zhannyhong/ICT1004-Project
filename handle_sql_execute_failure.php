<?php
if (!$stmt->execute())
{
    echo "<h2>Execute failed: (' . $stmt->errno . ') ' . $stmt->error</h2>";
    exit();
}
$result = $stmt->get_result();
$stmt->close();
?>

