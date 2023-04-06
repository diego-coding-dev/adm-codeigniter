<?php echo $this->extend('layout/adm-main-public'); ?>

<?php echo $this->section('content'); ?>

<div class="card mb-3">

    <div class="card-body">

        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Área restrita</h5>
            <p class="text-center small">Por favor, insira suas credênciais</p>
        </div>

        <form class="row g-3" method="post" action="<?php echo route_to('authenticate'); ?>">

            <input type="hidden" name="<?php echo csrf_token(); ?>" value="<?php echo csrf_hash(); ?>">

            <div class="col-12">
                <label for="email" class="form-label">Usuário</label>
                <div class="input-group">
                    <span class="input-group-text" id="inputGroupPrepend"><i class="ri-at-line"></i></span>
                    <input type="email" name="email" class="form-control">
                </div>
                <?php if (session()->has('errors')) : ?>
                    <h6 class="mt-1 text-danger" style="margin-bottom: -23px;"><?php echo session()->get('errors.email'); ?></h6>
                <?php endif; ?>
            </div>

            <div class="col-12" style="margin-top: 30px;">
                <label for="password" class="form-label">Senha</label>
                <div class="input-group">
                    <span class="input-group-text" id="inputGroupPrepend"><i class="ri-door-lock-line"></i></span>
                    <input type="password" name="password" class="form-control">
                </div>
                <?php if (session()->has('errors')) : ?>
                    <h6 class="mt-1 text-danger" style="margin-bottom: -23px;"><?php echo session()->get('errors.password'); ?></h6>
                <?php endif; ?>
            </div>

            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit" style="margin-top: 30px;">Entrar</button>
            </div>
        </form>

    </div>
</div>

<?php echo $this->endSection(); ?>