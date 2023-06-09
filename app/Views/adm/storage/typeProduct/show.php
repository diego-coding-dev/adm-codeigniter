<?php echo $this->extend('layout/adm-main'); ?>

<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('dashboard'); ?>

<?php echo $dashboard; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<div class="col-xl-8">

    <a href="<?php echo route_to('type-product.list-search') ?>" type="button" class="btn btn-secondary btn-sm">Voltar</a>

    <div class="card" style="margin-top: 20px;">
        <div class="card-body">
            <div class="tab-content">

                <div class="tab-pane fade show active profile-overview">

                    <h5 class="card-title">Detalhes</h5>

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label ">Categoria</div>
                        <div class="col-lg-9 col-md-8"><?php echo esc($typeProduct->type_product); ?></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Registrado em</div>
                        <div class="col-lg-9 col-md-8"><?php echo esc(date('d/m/Y', strtotime($typeProduct->created_at))); ?></div>
                    </div>

                </div>

            </div><!-- End Bordered Tabs -->
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>