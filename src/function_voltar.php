<?php 
function voltarPage() {
    header("Location: ../pages/os_panel.php"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['logout']))  {
    voltarPage();
}

?>