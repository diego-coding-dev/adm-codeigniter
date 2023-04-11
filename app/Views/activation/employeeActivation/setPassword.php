<?php echo $this->extend('layout/adm-main-public'); ?>

<?php echo $this->section('content'); ?>

<div class="d-flex justify-content-center py-4">
    <a href="index.html" class="logo d-flex align-items-center w-auto">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">ADM - Codeigniter</span>
    </a>
</div><!-- End Logo -->

<div class="card mb-3">
    <div class="card-body">

        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Finalizando sua ativação</h5>
            <!-- <p class="text-center small">Registre sua senha</p> -->
        </div>

        <form class="row g-3" method="post" action="<?php echo route_to('activation.employee-set-password'); ?>">

            <input type="hidden" name="<?php echo csrf_token(); ?>" value="<?php echo csrf_hash(); ?>">

            <input type="hidden" name="employee_id" value="<?php echo encrypt($employeeId); ?>">

            <div class="col-12">
                <label for="Senha" class="form-label">Senha</label>
                <input type="password" name="password" class="form-control">
                <?php if (session()->has('errors')) : ?>
                    <h6 class="mt-1 text-danger" style=""><?php echo session()->get('errors.password'); ?></h6>
                <?php endif; ?>
            </div>

            <div class="col-12">
                <label for="Confirme a senha" class="form-label">Repita a senha</label>
                <input type="password" name="password_confirm" class="form-control">
                <?php if (session()->has('errors')) : ?>
                    <h6 class="mt-1 text-danger" style=""><?php echo session()->get('errors.password_confirm'); ?></h6>
                <?php endif; ?>
            </div>

            <div class="col-12" style="margin-top: 50px;">
                <button class="btn btn-primary w-100" type="submit">Continuar</button>
            </div>
        </form>

    </div>
</div>

<?php echo $this->endSection(); ?>