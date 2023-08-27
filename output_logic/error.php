<?php
if (isset($_SESSION['error'])){
    echo '<p style="color:red;">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);
}
?>