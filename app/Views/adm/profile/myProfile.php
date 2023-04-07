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
                <div class="tab-content pt-2">

                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <h5 class="card-title">Sobre</h5>
                        <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p>

                        <h5 class="card-title">Detalhes</h5>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label ">Nome</div>
                            <div class="col-lg-9 col-md-8"><?php echo esc($account->name); ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Email</div>
                            <div class="col-lg-9 col-md-8"><?php echo esc($account->email); ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Registrado em</div>
                            <div class="col-lg-9 col-md-8"><?php echo esc(date('d/m/Y', strtotime($account->name))); ?></div>
                        </div>

                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Status</div>
                            <div class="col-lg-9 col-md-8"><?php echo ($account->is_active === 't') ? 'Ativado' : 'Não ativado'; ?></div>
                        </div>

                    </div>

                </div><!-- End Bordered Tabs -->
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>