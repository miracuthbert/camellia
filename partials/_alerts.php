<?php if (session_has('error')) { ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php echo session_pop('error'); ?>
    </div>
<?php } ?>

<?php if (session_has('success')) { ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php echo session_pop('success'); ?>
    </div>
<?php } ?>

<?php if (session_has('info')) { ?>
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php echo session_pop('info'); ?>
    </div>
<?php } ?>

<?php if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) { ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <ul>
            <?php foreach ($_SESSION['errors'] as $error) { ?>
                <li><?php echo $error; ?></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>

<?php if (session_has('bulk_success') && count($_SESSION['bulk_success']) > 0) { ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <ul>
            <?php foreach ($_SESSION['bulk_success'] as $success) { ?>
                <li><?php echo $success; ?></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>