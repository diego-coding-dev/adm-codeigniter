<?php echo $this->extend('layout/adm-main'); ?>

<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('dashboard'); ?>

<?php echo $dashboard; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<div class="col-xl-8">

    <a href="<?php echo route_to('storage.list-search'); ?>" type="button" class="btn btn-secondary btn-sm mb-3">Voltar</a>

    <div class="card">
        <div class="card-body pt-3">

            <?php echo $this->include('adm/storage/storage/components/tabEditStorage'); ?>

            <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                    <h5 class="card-title">Sobre</h5>
                    <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p>

                    <h5 class="card-title">Detalhes</h5>

                    <div class="row" style="margin-bottom: 5px;">
                        <div class="col-lg-3 col-md-4 label ">Descrição</div>
                        <div class="col-lg-9 col-md-8"><?php echo esc($storage->description); ?></div>
                    </div>

                    <div class="row" style="margin-bottom: 5px;">
                        <div class="col-lg-3 col-md-4 label">Categoria</div>
                        <div class="col-lg-9 col-md-8"><?php echo esc($typeProduct->type_product); ?></div>
                    </div>

                    <div class="row" style="margin-bottom: 5px;">
                        <div class="col-lg-3 col-md-4 label">Quantidade em estoque</div>
                        <div class="col-lg-9 col-md-8"><?php echo esc($storage->quantity); ?></div>
                    </div>

                    <div class="row" style="margin-bottom: 5px;">
                        <div class="col-lg-3 col-md-4 label">Registrado em</div>
                        <div class="col-lg-9 col-md-8"><?php echo esc(format($storage->created_at)); ?></div>
                    </div>

                </div>

            </div><!-- End Bordered Tabs -->
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>