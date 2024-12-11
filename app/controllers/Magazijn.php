<?php

class Magazijn extends BaseController
{
    private $magazijnModel;

    public function __construct()
    {
        $this->magazijnModel = $this->model('MagazijnModel');
    }

    public function index()
    {
        $data = [
            'title' => 'Overzicht Magazijn Jamin',
            'message' => NULL,
            'messageColor' => NULL,
            'messageVisibility' => 'none',
            'dataRows' => NULL
        ];

        $result = $this->magazijnModel->getAllMagazijnProducts();

        if (is_null($result)) {
            // Fout afhandelen
            $data['message'] = "Er is een fout opgetreden in de database";
            $data['messageColor'] = "danger";
            $data['messageVisibility'] = "flex";
            $data['dataRows'] = NULL;

            header('Refresh:3; url=' . URLROOT . '/Homepages/index');
        } else {
            $data['dataRows'] = $result;
        }

        $this->view('magazijn/index', $data);
    }

    public function leverancier($productId)
    {
        $data = [
            'title' => 'Leverings Informatie',
            'message' => NULL,
            'messageColor' => NULL,
            'messageVisibility' => 'none',
            'dataRows' => NULL
        ];

        $result = $this->magazijnModel->getProductsByLeverancier($productId);

        if (is_null($result)) {
            // Fout afhandelen
            $data['message'] = "Er is een fout opgetreden in de database";
            $data['messageColor'] = "danger";
            $data['messageVisibility'] = "flex";
            $data['dataRows'] = NULL;

            header('Refresh:3; url=' . URLROOT . '/Homepages/index');
        } else if ($result[0]->MagazijnAantal == 0) {
            $data['message'] = "Er is van dit product op dit moment geen voorraad aanwezig, de verwachte eerstvolgende levering is: " . $result[0]->DatumEerstVolgendeLevering;
            $data['dataRows'] = NULL;
            header('Refresh:4; url=' . URLROOT . '/magazijn/index');
        } else {
            $data['dataRows'] = $result;
        }

        $this->view('magazijn/leverancier', $data);
    }

    public function allergeen($productId)
    {
        $data = [
            'title' => 'Overzicht allergenen',
            'message' => NULL,
            'messageColor' => NULL,
            'messageVisibility' => 'none',
            'dataRows' => NULL
        ];

        $result = $this->magazijnModel->getAllergeenByProduct($productId);

        if (is_null($result)) {
            // Fout afhandelen
            $data['message'] = "Er is een fout opgetreden in de database";
            $data['messageColor'] = "danger";
            $data['messageVisibility'] = "flex";
            $data['dataRows'] = NULL;

            header('Refresh:3; url=' . URLROOT . '/Homepages/index');
        } else if ($result == NULL) {
            $data['message'] = "In dit product zitten geen stoffen die een allergische reactie kunnen veroorzaken";
            header('Refresh:4; url=' . URLROOT . '/magazijn/index');
        } else {
            $data['dataRows'] = $result;
        }

        $this->view('magazijn/allergeen', $data);
    }
}