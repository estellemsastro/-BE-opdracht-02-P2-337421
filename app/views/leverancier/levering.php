<?php require_once APPROOT . '/views/includes/header.php'; ?>

<!-- Voor het centreren van de container gebruiken we het bootstrap grid -->
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
            <?php if (isset($data['dataRows']) && !empty($data['dataRows'])): ?>
                <!-- Only display data if $data['dataRows'] is not empty -->
                <h5>Naam Leverancier: <?= htmlspecialchars($data['dataRows'][0]->LeverancierNaam, ENT_QUOTES, 'UTF-8') ?></h5>
                <h5>Contactpersoon Leverancier: <?= htmlspecialchars($data['dataRows'][0]->LeverancierContact, ENT_QUOTES, 'UTF-8') ?></h5>
                <h5>Mobiel: <?= htmlspecialchars($data['dataRows'][0]->LeverancierMobiel, ENT_QUOTES, 'UTF-8') ?></h5>

                <form action="<?= URLROOT; ?>/leverancier/nieuweLevering" method="POST">
                    <input type="hidden" name="ProductId" value="<?= htmlspecialchars($data['dataRows'][0]->ProductId, ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="LeverancierId" value="<?= htmlspecialchars($data['dataRows'][0]->LeverancierId, ENT_QUOTES, 'UTF-8') ?>">

                    <label for="Aantal">Aantal producteenheden</label>
                    <input type="number" name="Aantal" id="Aantal" value="<?= isset($data['Aantal']) ? htmlspecialchars($data['Aantal'], ENT_QUOTES, 'UTF-8') : '' ?>" required>

                    <label for="DatumEerstVolgendeLevering">Datum eerstvolgende levering</label>
                    <input type="date" name="DatumEerstVolgendeLevering" id="DatumEerstVolgendeLevering">

                    <button type="submit" class="btn btn-primary mt-3">Opslaan</button>
                </form>
            <?php else: ?>
                <!-- Display a message if no data is available -->
                <p>Er zijn geen gegevens gevonden voor dit product.</p>
            <?php endif; ?>

            <a href="<?= URLROOT; ?>/homepages/index">Homepage</a> |
            <a href="<?= URLROOT; ?>/leverancier/index">Leveranciers</a>
        </div>
        <div class="col-2"></div>
    </div>

</div>

<?php require_once APPROOT . '/views/includes/footer.php'; ?>
