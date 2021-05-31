<?php
    session_start();
    if(isset($_POST['more']) && $_POST['more']==1) $_SESSION['messages_limit'] += 10;