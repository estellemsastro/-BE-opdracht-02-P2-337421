/******************************************************
-- Doel: Opvragen van alle records uit de tabellen Magazijn
--       en Product
-- Versie: 01
-- Datum:  24-10-2024
-- Auteur: Arjan de Ruijter
******************************************************/

-- Noem de database voor de stored procedure
use `jamin_a`;

-- Verwijder de bestaande stored procedure
DROP PROCEDURE IF EXISTS spReadMagazijnProduct;

DELIMITER //

CREATE PROCEDURE spReadMagazijnProduct()
BEGIN

    SELECT       MAGA.Id                    AS      MagazijnId
                ,MAGA.ProductId             AS      MagazijnProductId
                ,MAGA.VerpakkingseenheidInKG
                ,MAGA.AantalAanwezig
                ,PROD.Id                    AS      ProductId
                ,PROD.Naam
                ,PROD.Barcode

    FROM        Magazijn AS MAGA

    INNER JOIN Product AS PROD
            ON PROD.Id = MAGA.ProductId

    ORDER BY PROD.Barcode ASC;


END //
DELIMITER ;

/**********debug code stored procedure***************
CALL spReadMagazijnProduct();
****************************************************/