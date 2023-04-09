<?php echo $this->extend('layout/adm-main'); ?>

<?php echo $this->section('title'); ?>

<?php echo $title; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('dashboard'); ?>

<?php echo $dashboard; ?>

<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>

<div class="col-lg-6">
    <div class="card">
        <div class="card-body">
            <form class="mt-3" method="post" action="<?php echo route_to('product.add') ?>" enctype="multipart/form-data">

                <input type="hidden" name="<?php echo csrf_token(); ?>" value="<?php echo csrf_hash(); ?>">

                <div class="row mb-3">
                    <label for="image" class="col-md-4 col-lg-3 col-form-label">Imagem do produto</label>
                    <div class="col-md-8 col-lg-9">
                        <img src="<?php echo site_url(); ?>assets/img/profile-img.jpg" alt="Profile">
                        <div class="pt-2 mb-3">
                            <input type="file" name="image">
                            <?php if (session()->has('errors')) : ?>
                                <h6 class="mt-1 text-danger" style="margin-bottom: -23px;"><?php echo session()->get('errors.image'); ?></h6>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="description" class="col-md-4 col-lg-3 col-form-label">Produto</label>
                    <div class="col-md-8 col-lg-9">
                        <input name="description" type="text" class="form-control">
                        <?php if (session()->has('errors')) : ?>
                            <h6 class="mt-1 text-danger" style="margin-bottom: -23px;"><?php echo session()->get('errors.description'); ?></h6>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="type_product_id" class="col-md-4 col-lg-3 col-form-label">Categoria</label>
                    <div class="col-md-8 col-lg-9">
                        <select class="form-select" name="type_product_id" aria-label="Default select example">
                            <option value="" selected>Selecione...</option>
                            <?php foreach ($typeProductList as $key => $typeProduct) : ?>
                                <option value="<?php echo $typeProduct->id; ?>"><?php echo esc($typeProduct->type_product); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session()->has('errors')) : ?>
                            <h6 class="mt-1 text-danger" style="margin-bottom: -23px;"><?php echo session()->get('errors.type_product_id'); ?></h6>
                        <?php endif; ?>
                    </div>
                </div>




                <div class="text-center">
                    <button type="submit" class="btn btn-primary" style="margin-top: 30px;">Adicionar</button>
                </div>
            </form><!-- End Profile Edit Form -->
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>