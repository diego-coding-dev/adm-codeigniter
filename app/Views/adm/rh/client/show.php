<?php echo $this->extend('layout/adm-main'); ?>

<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('dashboard'); ?>

<?php echo $dashboard; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<div class="col-xl-8">

    <a href="<?php echo route_to('client.list-search') ?>" type="button" class="btn btn-secondary btn-sm">Voltar</a>

    <div class="card">
        <div class="card-body">
            <div class="tab-content">

                <div class="tab-pane fade show active profile-overview">

                    <h5 class="card-title">Detalhes</h5>

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label ">Nome</div>
                        <div class="col-lg-9 col-md-8"><?php echo esc($client->name); ?></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Email</div>
                        <div class="col-lg-9 col-md-8"><?php echo esc($client->email); ?></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Registrado em</div>
                        <div class="col-lg-9 col-md-8"><?php echo esc(date('d/m/Y', strtotime($client->created_at))); ?></div>
                    </div>

                </div>

            </div><!-- End Bordered Tabs -->
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>