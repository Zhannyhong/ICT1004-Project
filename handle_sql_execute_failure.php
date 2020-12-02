<?php
if (!$stmt->execute())
{
    echo "<h2>Execute failed: (' . $stmt->errno . ') ' . $stmt->error</h2>";
    echo "<h2>Please try again</h2>";
    exit();
}
$result = $stmt->get_result();
$stmt->close();
?>

