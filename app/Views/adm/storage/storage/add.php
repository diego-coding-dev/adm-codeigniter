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

            <div class="tab-content pt-2 mt-3">
                <form class="user" method="post" action="<?php echo route_to('storage.add-units', $storageId); ?>">

                    <input type="hidden" name="<?php echo csrf_token(); ?>" value="<?php echo csrf_hash(); ?>">

                    <div class="col-sm-4 mb-3 mb-sm-0">
                        <label>Quantidade</label>
                        <div class="input-group">
                            <!--<span class="input-group-text" id="inputGroupPrepend"><i class="ri-add-circle-line"></i></span>-->
                            <input type="text" name="quantity" class="form-control" onkeypress="isNumber(event)">
                            <span class="input-group-text" id="inputGroupPrepend">un.</span>
                        </div>
                        <?php if (session()->has('errors')) : ?>
                            <h6 class="mt-1 text-danger" style="margin-bottom: -23px;"><?php echo session()->get('errors.quantity'); ?></h6>
                        <?php endif; ?>
                    </div>

                    <div style="margin-top: 30px;">
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </div>
                </form>
                <script>
                    function isNumber(e) {
                        let value = String.fromCharCode(e.which);

                        if (!(/[0-9]/.test(value))) {
                            e.preventDefault();
                        }
                    }
                </script>
            </div><!-- End Bordered Tabs -->
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>