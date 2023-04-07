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

                    <!-- Profile Edit Form -->
                    <form method="post" action="<?php echo route_to('profile.save-edit'); ?>">

                        <input type="hidden" name="<?php echo csrf_token(); ?>" value="<?php echo csrf_hash(); ?>">

                        <div class="row mb-3">
                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nome</label>
                            <div class="col-md-8 col-lg-9">
                                <input type="text" class="form-control" placeholder="<?php echo esc($account->name); ?>" disabled>
                                <?php if (session()->has('errors')) : ?>
                                    <h6 class="mt-1 text-danger" style="margin-bottom: -40px;"><?php echo session()->get('errors.name'); ?></h6>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row mb-3" style="margin-top: 40px;">
                            <label for="about" class="col-md-4 col-lg-3 col-form-label">Email</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="email" type="email" class="form-control" placeholder="<?php echo esc($account->email); ?>">
                                <?php if (session()->has('errors')) : ?>
                                    <h6 class="mt-1 text-danger" style="margin-bottom: -40px;"><?php echo session()->get('errors.email'); ?></h6>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="margin-top: 30px;">Salvar alterações</button>
                        </div>
                    </form><!-- End Profile Edit Form -->

                </div>

            </div><!-- End Bordered Tabs -->
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>