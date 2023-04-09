<?php echo $this->extend('layout/adm-main'); ?>

<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('dashboard'); ?>

<?php echo $dashboard; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<div class="col-xl-8">

    <a href="<?php echo route_to('product.list-search'); ?>" type="button" class="btn btn-secondary btn-sm mb-3">Voltar</a>

    <div class="card">
        <div class="card-body pt-3">

            <?php echo $this->include('adm/storage/product/components/tabEditProduct'); ?>

            <div class="tab-content pt-2">

                <form class="mt-3" method="post" action="<?php echo route_to('product.save-image', $productId) ?>" enctype="multipart/form-data">

                    <input type="hidden" name="<?php echo csrf_token(); ?>" value="<?php echo csrf_hash(); ?>">

                    <div class="row mb-3">
                        <div class="col-md-8 col-lg-9">
                            <img src="<?php echo route_to('product.image', $product->image); ?>" alt="Profile">
                            <div class="pt-2 mb-3">
                                <input type="file" name="image">
                                <?php if (session()->has('errors')) : ?>
                                    <h6 class="mt-1 text-danger" style="margin-bottom: -23px;"><?php echo session()->get('errors.image'); ?></h6>
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm" title="Atualizar imagem do produto" style="margin-top: 20px;"><i class="bi bi-upload"></i></button>
                            <!-- <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image" style="margin-top: 20px;"><i class="bi bi-trash"></i></a> -->

                        </div>
                    </div>

                </form><!-- End Profile Edit Form -->

            </div><!-- End Bordered Tabs -->
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>