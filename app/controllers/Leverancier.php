<?php
class Leverancier extends BaseController
{
    private $leverancierModel;

    public function __construct()
    {
        $this->leverancierModel = $this->model('LeverancierModel');
    }

    public function index()
    {
        $data = [
            'title' => 'Overzicht Leveranciers Jamin',
            'message' => NULL,
            'messageColor' => NULL,
            'messageVisibility' => 'none',
            'dataRows' => NULL
        ];

        $result = $this->leverancierModel->getAllLeveranciers();

        if (is_null($result)) {
            // Fout afhandelen
            $data['message'] = "Er is een fout opgetreden in de database";
            $data['messageColor'] = "danger";
            $data['messageVisibility'] = "flex";
            $data['dataRows'] = NULL;
        } else {
            $data['dataRows'] = $result;
        }

        // Laat de gebruiker op dezelfde pagina blijven
        $this->view('leverancier/index', $data);
    }

    public function producten($leverancierId)
    {
        $data = [
            'title' => 'Overzicht Leveranciers Jamin',
            'message' => NULL,
            'messageColor' => NULL,
            'messageVisibility' => 'none',
            'dataRows' => NULL
        ];

        $result = $this->leverancierModel->getAllProductenById($leverancierId);

        if (is_null($result)) {
            // Fout afhandelen
            $data['message'] = "Er is een fout opgetreden in de database";
            $data['messageColor'] = "danger";
            $data['messageVisibility'] = "flex";
            $data['dataRows'] = NULL;
        } else if ($result[0]->AantalAanwezig == 0) {
            $data['message'] = "Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin.";
            $data['dataRows'] = $result;
            // De gebruiker blijft op dezelfde pagina
        } else {
            $data['dataRows'] = $result;
        }

        $this->view('leverancier/producten', $data);
    }

    public function levering($ProductId)
    {
        $data = [
            'title' => 'Levering product',
            'message' => NULL,
            'messageColor' => NULL,
            'messageVisibility' => 'none',
            'dataRows' => NULL
        ];

        $result = $this->leverancierModel->getAllProductDetailsById($ProductId);

        if (is_null($result)) {
            // Fout afhandelen
            $data['message'] = "Er is een fout opgetreden in de database";
            $data['messageColor'] = "danger";
            $data['messageVisibility'] = "flex";
            $data['dataRows'] = NULL;
        } else {
            $data['dataRows'] = $result;
        }

        $this->view('leverancier/levering', $data);
    }

    public function nieuweLevering()
    {
        $data = [
            'title' => 'Levering product',
            'message' => null,
            'messageColor' => null,
            'messageVisibility' => 'none',
            'Aantal' => NULL,
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Verwerk formulierdata
            $productId = $_POST['ProductId'];
            $leverancierId = $_POST['LeverancierId'];
            $aantal = $_POST['Aantal'];
            $datumEerstVolgendeLevering = !empty($_POST['DatumEerstVolgendeLevering']) ? $_POST['DatumEerstVolgendeLevering'] : null;
            
            $data['Aantal'] = $aantal;

            if ($datumEerstVolgendeLevering && strtotime($datumEerstVolgendeLevering) < strtotime(date('Y-m-d'))) {
                $result = $this->leverancierModel->getAllProductDetailsById($productId);
                if (!is_null($result)) {
                    $data['dataRows'] = $result;
                }

                $data['message'] = "De geselecteerde datum mag niet in het verleden liggen.";
                $data['messageColor'] = "danger";
                $data['messageVisibility'] = "flex";

                $this->view('leverancier/levering', $data);
                exit;
            }

            // Voeg nieuwe levering toe
            $result = $this->leverancierModel->nieuweLevering($leverancierId, $productId, $aantal, $datumEerstVolgendeLevering);

            if ($result) {
                $data['message'] = "De nieuwe levering is succesvol toegevoegd.";
                $data['messageColor'] = "success";
            } else {
                $data['message'] = "Er is een fout opgetreden bij het toevoegen van de levering.";
                $data['messageColor'] = "danger";
            }

            $data['messageVisibility'] = "flex";
            // Laat de gebruiker op de huidige pagina
            $this->view('leverancier/levering', $data);
            exit;
        } else {
            // Indien geen POST, stuur de gebruiker terug naar leverancierspagina
            header('Location: ' . URLROOT . '/leverancier/index');
            exit;
        }
    }
}
