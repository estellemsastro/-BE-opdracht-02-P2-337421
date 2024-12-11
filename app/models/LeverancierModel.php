<?php

class LeverancierModel
{
    private $db;

    public function __construct()
    {
        /**
         * Maak een nieuw database object die verbinding maakt met de 
         * MySQL server
         */
        $this->db = new Database();
    }   

    public function getAllLeveranciers()
    {
        try {
            $sql = "CALL spGetAllLeveranciers()";

            $this->db->query($sql);

            return $this->db->resultSet();

        } catch (Exception $e) {
            /**
             * Log de error in de functie logger()
             */
            logger(__LINE__, __METHOD__, __FILE__, $e->getMessage());            
        }
    }

    public function getAllProductenById($leverancierId)
    {
        try {
            $sql = "CALL spGetAllProductenById($leverancierId)";

            $this->db->query($sql);

            return $this->db->resultSet();

        } catch (Exception $e) {
            /**
             * Log de error in de functie logger()
             */
            logger(__LINE__, __METHOD__, __FILE__, $e->getMessage());            
        }
    }

    public function getAllProductDetailsById($ProductId)
    {
        try {
            $sql = "CALL spGetProductDetailsById($ProductId)";

            $this->db->query($sql);

            return $this->db->resultSet();

        } catch (Exception $e) {
            /**
             * Log de error in de functie logger()
             */
            logger(__LINE__, __METHOD__, __FILE__, $e->getMessage());            
        }
    }

    public function nieuweLevering($leverancierId, $productId, $aantal, $datumEerstVolgendeLevering = null)
    {
        try {
            $sql = "CALL spInsertNewLevering(:leverancierId, :productId, :aantal, :datumEerstVolgendeLevering)";
            $this->db->query($sql);

            // Bind de parameters
            $this->db->bind(':leverancierId', $leverancierId, PDO::PARAM_INT);
            $this->db->bind(':productId', $productId, PDO::PARAM_INT);
            $this->db->bind(':aantal', $aantal, PDO::PARAM_INT);
            $this->db->bind(':datumEerstVolgendeLevering', $datumEerstVolgendeLevering, PDO::PARAM_STR);

            // Voer de query uit
            $this->db->execute();
            return true;
        } catch (Exception $e) {
            logger(__LINE__, __METHOD__, __FILE__, $e->getMessage());
            return false;
        }
    }
}