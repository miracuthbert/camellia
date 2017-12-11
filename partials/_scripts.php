<!-- Scripts -->
<script src="<?php echo APP_URL . "/public/js/app.js"; ?>"></script>

<?php

//unset session errors if exists
if (isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}