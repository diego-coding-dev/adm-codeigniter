<!-- <div class="alert alert-warning bg-info text-dark border-0 alert-dismissible fade show" role="alert">
    Teste de mensagem
    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="alert" aria-label="Close"></button>
</div> -->

<?php if (session()->has('info')) : ?>
    <div class="alert alert-info bg-info text-dark border-0 alert-dismissible fade show" role="alert">
        <?php echo session()->get('info'); ?>
        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>

<?php if (session()->has('warning')) : ?>
    <div class="alert alert-warning bg-warning text-dark border-0 alert-dismissible fade show" role="alert">
        <?php echo session()->get('warning'); ?>
        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>

<?php if (session()->has('success')) : ?>
    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show" role="alert">
        <?php echo session()->get('success'); ?>
        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>

<?php if (session()->has('danger')) : ?>
    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
        <?php echo session()->get('danger'); ?>
        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>

<?php if (session()->has('primary')) : ?>
    <div class="alert alert-primary bg-primary text-light border-0 alert-dismissible fade show" role="alert">
        <?php echo session()->get('primary'); ?>
        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>

<?php if (session()->has('secondary')) : ?>
    <div class="alert alert-secondary bg-secondary text-light border-0 alert-dismissible fade show" role="alert">
        <?php echo session()->get('secondary'); ?>
        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>