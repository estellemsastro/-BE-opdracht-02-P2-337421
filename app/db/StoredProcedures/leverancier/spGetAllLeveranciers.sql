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
use `jamin_a`;

-- Verwijder de bestaande stored procedure
DROP PROCEDURE IF EXISTS spGetAllLeveranciers;

DELIMITER //

CREATE PROCEDURE spGetAllLeveranciers()
BEGIN

    SELECT      LEV.Id                   AS LeverancierId
                ,LEV.Naam
                ,LEV.ContactPersoon
                ,LEV.LeverancierNummer
                ,LEV.Mobiel
                ,PROD.Id                 AS ProductId
                ,COUNT(DISTINCT PROD.Id) AS AantalVerschillendeProducten

    FROM        Leverancier AS LEV

    LEFT JOIN ProductPerLeverancier AS PPL
            ON LEV.Id = PPL.LeverancierId
            
    LEFT JOIN Product AS PROD
            ON PROD.Id = PPL.ProductId

    GROUP BY  LEV.Id
            
    ORDER BY AantalVerschillendeProducten DESC;


END //
DELIMITER ;

/**********debug code stored procedure***************
CALL spGetAllLeveranciers();
****************************************************/