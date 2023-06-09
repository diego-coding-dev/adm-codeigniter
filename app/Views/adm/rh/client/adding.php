<?php echo $this->extend('layout/adm-main'); ?>

<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('dashboard'); ?>

<?php echo $dashboard; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<div class="card">
    <div class="card-body">

        <!-- Multi Columns Form -->
        <form class="row g-3 mt-1" method="post" action="<?php echo url_to('client.add') ?>">

            <input type="hidden" name="<?php echo csrf_token(); ?>" value="<?php echo csrf_hash(); ?>">

            <div class="col-md-6">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" name="name">
                <?php if (session()->has('errors')) : ?>
                    <h6 class="mt-1 text-danger" style="margin-bottom: -23px;"><?php echo session()->get('errors.name'); ?></h6>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email">
                <?php if (session()->has('errors')) : ?>
                    <h6 class="mt-1 text-danger" style="margin-bottom: -23px;"><?php echo session()->get('errors.email'); ?></h6>
                <?php endif; ?>
            </div>
            <div class="text-left">
                <button type="submit" class="btn btn-primary" style="margin-top: 30px;">Salvar</button>
                <a href="<?php echo url_to('client.list-search'); ?>" type="button" class="btn btn-danger" style="margin-top: 30px;">Cancelar</a>
            </div>
        </form><!-- End Multi Columns Form -->

    </div>
</div>

<?php echo $this->endSection(); ?>