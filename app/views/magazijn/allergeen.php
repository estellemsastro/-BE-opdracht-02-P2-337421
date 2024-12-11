<?php require_once APPROOT . '/views/includes/header.php'; ?>

<!-- Voor het centreren van de container gebruiken we het boodstrap grid -->
<div class="container">

    <div class="row mt-3 text-center" style="display:<?= $data['messageVisibility']; ?>">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="alert alert-<?= $data['messageColor']; ?>" role="alert">
                <?= $data['message']; ?>
            </div>
        </div>
        <div class="col-2"></div>
    </div>


    <div class="row mt-3">
        <div class="col-2"></div>
        <div class="col-8">
            <h2><?php echo $data['title']; ?></h2>
        </div>
        <div class="col-2"></div>
    </div>

    <div class="row mt-3">
        <div class="col-2"></div>
        <div class="col-8">
            <?php if (isset($data['dataRows'])) : ?>
                <h5>Naam: <?= $data['dataRows'][0]->ProductNaam ?></h5>
                <h5>Barcode: <?= $data['dataRows'][0]->ProductBarcode ?></h5>
            <?php endif; ?>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Omschrijving</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_null($data['dataRows'])) { ?>
                                <tr>
                                  <td colspan='6' class='text-center'><?= $data['message']; ?></td>
                                </tr>
                    <?php } else {                              
                              foreach ($data['dataRows'] as $product) { ?>
                                <tr>
                                <td><?= $product->AllergeenNaam ?></td>
                                <td><?= $product->AllergeenOmschrijving ?></td>       
                                </tr>
                    <?php } } ?>
                </tbody>
            </table>
            <a href="<?= URLROOT; ?>/homepages/index">Homepage</a> |
            <a href="<?= URLROOT; ?>/magazijn/index">Magazijn</a>
        </div>
        <div class="col-2"></div>
    </div>

</div>




<?php require_once APPROOT . '/views/includes/footer.php'; ?>