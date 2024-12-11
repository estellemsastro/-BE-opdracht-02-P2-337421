/************************************************
-- Doel: Opvragen alle records uit de tabel
--       Leverancier.
************************************************
-- Versie: 01
-- Datum:  10-12-2024
-- Auteur: Estelle Sastropawiro
-- Details: Stored procedure voor leverancier model method
************************************************/

-- Noem de database voor de stored procedure
USE `jamin_a`;

-- Verwijder de bestaande stored procedure
DROP PROCEDURE IF EXISTS spGetAllProductenById;

DELIMITER //

CREATE PROCEDURE spGetAllProductenById(
    LeverancierId INT UNSIGNED
)
BEGIN

    -- Create a temporary table to store the most recent delivery for each product
    CREATE TEMPORARY TABLE TempProductDeliveries AS (
        SELECT 
            PPL.ProductId,
            MAX(PPL.DatumLevering) AS MostRecentDelivery
        FROM 
            ProductPerLeverancier AS PPL
        WHERE 
            PPL.LeverancierId = LeverancierId
        GROUP BY 
            PPL.ProductId
    );

    -- Select the results with the most recent delivery for each product
    WITH RankedProducts AS (
        SELECT 
            LEV.Id                      AS LeverancierId
            ,LEV.Naam                   AS LeverancierNaam
            ,LEV.ContactPersoon         AS LeverancierContact
            ,LEV.LeverancierNummer
            ,LEV.Mobiel                 AS LeverancierMobiel
            ,PROD.Id                    AS ProductId
            ,PROD.Naam                  AS ProductNaam
            ,MAG.Id                     AS MagazijnId
            ,MAG.AantalAanwezig      
            ,MAG.VerpakkingseenheidInKG AS VerpakkingsEenheid
            ,PPL.Id                     AS ProductPerLeverancierId
            ,PPL.DatumLevering          AS LaatsteLevering
            ,ROW_NUMBER() OVER (PARTITION BY PROD.Naam ORDER BY PPL.DatumLevering DESC) AS RowNum
        FROM 
            ProductPerLeverancier AS PPL

        INNER JOIN TempProductDeliveries AS TPD
                ON PPL.ProductId = TPD.ProductId 
                AND PPL.DatumLevering = TPD.MostRecentDelivery

        INNER JOIN Product AS PROD
                ON PROD.Id = PPL.ProductId
                
        INNER JOIN Leverancier AS LEV
                ON LEV.Id = PPL.LeverancierId

        INNER JOIN Magazijn AS MAG
                ON MAG.Id = PROD.Id

        WHERE 
            PPL.LeverancierId = LeverancierId     
    )

    SELECT 
        LeverancierId,
        LeverancierNaam,
        LeverancierContact,
        LeverancierNummer,
        LeverancierMobiel,
        ProductId,
        ProductNaam,
        MagazijnId,
        AantalAanwezig,
        VerpakkingsEenheid,
        ProductPerLeverancierId,
        LaatsteLevering
    FROM 
        RankedProducts
    WHERE 
        RowNum = 1
    ORDER BY 
        LaatsteLevering DESC;

    -- Drop the temporary table
    DROP TEMPORARY TABLE IF EXISTS TempProductDeliveries;

END //
DELIMITER ;

/**********debug code stored procedure***************
CALL spGetAllProductenById();
****************************************************/