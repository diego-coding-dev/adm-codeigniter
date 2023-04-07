<?php echo $this->extend('layout/adm-main'); ?>

<?php echo $this->section('title'); ?>
<?php echo $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('dashboard'); ?>
<?php echo $dashboard; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<div class="col-xl-8">
    <div class="card">
        <div class="card-body pt-3">

            <?php echo $this->include('adm/profile/components/tabEditProfile'); ?>

            <div class="tab-content pt-2">

                <div class="tab-pane fade show active pt-3">
                    <!-- Change Password Form -->
                    <form method="post" action="<?php echo route_to('profile.save-password'); ?>">

                        <input type="hidden" name="<?php echo csrf_token(); ?>" value="<?php echo csrf_hash(); ?>">

                        <div class="row mb-3">
                            <label for="current_password" class="col-md-4 col-lg-3 col-form-label">Senha atual</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="current_password" type="password" class="form-control">
                                <?php if (session()->has('errors')) : ?>
                                    <h6 class="mt-1 text-danger" style="margin-bottom: -40px;"><?php echo session()->get('errors.current_password'); ?></h6>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-3" style="margin-top: 40px;">
                            <label for="password" class="col-md-4 col-lg-3 col-form-label">Nova senha</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="password" type="password" class="form-control" id="newPassword">
                                <?php if (session()->has('errors')) : ?>
                                    <h6 class="mt-1 text-danger" style="margin-bottom: -40px;"><?php echo session()->get('errors.password'); ?></h6>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-3" style="margin-top: 40px;">
                            <label for="password_confirm" class="col-md-4 col-lg-3 col-form-label">Nova senha novamente</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="password_confirm" type="password" class="form-control" id="renewPassword">
                                <?php if (session()->has('errors')) : ?>
                                    <h6 class="mt-1 text-danger" style="margin-bottom: -40px;"><?php echo session()->get('errors.password_confirm'); ?></h6>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="margin-top: 30px;">Alterar senha</button>
                        </div>
                    </form><!-- End Change Password Form -->

                </div>

            </div><!-- End Bordered Tabs -->
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>