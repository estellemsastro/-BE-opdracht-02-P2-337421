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
DROP PROCEDURE IF EXISTS spGetProductByLeverancier;

DELIMITER //

CREATE PROCEDURE spGetProductByLeverancier(
    productId INT UNSIGNED
)
BEGIN

    SELECT       PPL.Id                    AS      PPLId
                ,PPL.LeverancierId         AS      PPLLeverancierId
                ,PPL.ProductId             AS      PPLProductId
                ,PPL.MagazijnId            AS      PPLMagazijnId
                ,PPL.DatumLevering
                ,PPL.Aantal
                ,PPL.DatumEerstVolgendeLevering
                ,PROD.Id                    AS      ProductId
                ,PROD.Naam                  AS      ProductNaam
                ,LEVER.Id                   AS      LeverId
                ,LEVER.Naam                 AS      LeverancierNaam
                ,LEVER.ContactPersoon       AS      LeverancierContact
                ,LEVER.LeverancierNummer    AS      LeverancierNummer
                ,LEVER.Mobiel               AS      LeverancierMobiel
                ,MAGA.Id
                ,MAGA.AantalAanwezig        AS      MagazijnAantal

    FROM        ProductPerLeverancier AS PPL

    INNER JOIN Product AS PROD
            ON PROD.Id = PPL.ProductId
            
    INNER JOIN Leverancier AS LEVER
            ON LEVER.Id = PPL.LeverancierId

    INNER JOIN Magazijn AS MAGA
            ON MAGA.Id = PROD.Id

    WHERE   PPL.ProductId = productId     
            
    ORDER BY PPL.DatumLevering ASC;


END //
DELIMITER ;

/**********debug code stored procedure***************
CALL spGetProductByLeverancier();
****************************************************/