/*ELIMINAR PROCEDIMIENTOS ALMACENADOS */
DROP PROCEDURE IF EXISTS `SP_GETALL_IDS_SUBMISSIONS`;
DROP PROCEDURE IF EXISTS `SP_GET_DATE_PUBLICATION`;
DROP PROCEDURE IF EXISTS `SP_GET_TITLE_PUBLICATION`;
DROP PROCEDURE IF EXISTS `SP_GET_AUTHORS`;
DROP PROCEDURE IF EXISTS `SP_GET_AUTHORS_DATA`;
DROP PROCEDURE IF EXISTS `SP_GET_NUM_VOLUM`;
DROP PROCEDURE IF EXISTS `SP_GET_FILTER_TITLE`;
DROP PROCEDURE IF EXISTS `SP_GET_FILTER_USERNAME`;
DROP PROCEDURE IF EXISTS `SP_CERTIFICATE_GENERATION_DATE`;

/* OBTENER EL ID DE TODAS LAS SUBMISSIONS */
DELIMITER $$
CREATE PROCEDURE `SP_GETALL_IDS_SUBMISSIONS` ()
BEGIN
	SELECT SUBMISSION_ID FROM SUBMISSIONS;
END$$
DELIMITER ;

/* OBTENER LA FECHA DE PUBLICACIÓN */
DELIMITER $$
CREATE PROCEDURE `SP_GET_DATE_PUBLICATION` (IN ID_SUBMISSION INTEGER)
BEGIN
	DECLARE ID_PUBLICATION INTEGER;
	SET lc_time_names = 'es_ES';
    
	SET ID_PUBLICATION = (SELECT CURRENT_PUBLICATION_ID FROM SUBMISSIONS where SUBMISSION_ID = ID_SUBMISSION);
    
	SELECT DAY(DATE_PUBLISHED) AS DIA, MONTHNAME(DATE_PUBLISHED) AS MES, YEAR(DATE_PUBLISHED) AS ANIO FROM PUBLICATIONS AS PUB 
	INNER JOIN SUBMISSIONS AS SUB ON PUB.PUBLICATION_ID = SUB.CURRENT_PUBLICATION_ID
	WHERE PUB.PUBLICATION_ID = ID_PUBLICATION;

END$$
DELIMITER ;

/* OBTENER LA FECHA ACTUAL */
DELIMITER $$
CREATE PROCEDURE `SP_CERTIFICATE_GENERATION_DATE` ()
BEGIN
	SET lc_time_names = 'es_ES';
	SELECT DAY(CURDATE()) AS DIA, MONTHNAME(CURDATE()) AS MES, YEAR(CURDATE()) AS ANIO;
END$$
DELIMITER ;

/* OBTENER EL TITULO DE LA PUBLICACIÓN */
DELIMITER $$
CREATE PROCEDURE `SP_GET_TITLE_PUBLICATION` (IN ID_SUBMISSION INTEGER)
BEGIN 
DECLARE ID_PUBLICATION INTEGER;
SET ID_PUBLICATION = (SELECT CURRENT_PUBLICATION_ID FROM SUBMISSIONS where SUBMISSION_ID = ID_SUBMISSION);

SELECT SETTING_VALUE AS TITLE FROM PUBLICATION_SETTINGS AS PS WHERE PS.PUBLICATION_ID = ID_PUBLICATION AND 
(SETTING_NAME LIKE "TITLE%" AND LOCALE LIKE "es_ES") AND PS.PUBLICATION_ID;																							
END$$
DELIMITER ;

/* OBTENER LOS ID DE LOS AUTORES DE LA PUBLICACIÓN */
DELIMITER $$
CREATE PROCEDURE `SP_GET_AUTHORS` (IN ID_SUBMISSION INTEGER)
BEGIN
DECLARE ID_PUBLICATION INTEGER;
SET ID_PUBLICATION = (SELECT CURRENT_PUBLICATION_ID FROM SUBMISSIONS where SUBMISSION_ID = ID_SUBMISSION);

SELECT AUTHOR_ID FROM AUTHORS WHERE PUBLICATION_ID = ID_PUBLICATION;	
END$$
DELIMITER ;

/* OBTENER LA INFORMACIÓN DE LOS AUTORES DE LA PUBLICACIÓN */
DELIMITER $$
CREATE PROCEDURE `SP_GET_AUTHORS_DATA` (IN ID_AUTHOR INTEGER)
BEGIN
SELECT TRIM(REPLACE(SETTING_VALUE, '  ', ' ')) AS SETTING_VALUE FROM AUTHOR_SETTINGS 
WHERE AUTHOR_ID = ID_AUTHOR AND (SETTING_NAME LIKE "FAMILYNAME%" OR SETTING_NAME LIKE "GIVENNAME%" OR 
SETTING_NAME LIKE "affiliation%") AND LOCALE LIKE "es_ES%" ORDER BY SETTING_NAME DESC;	
END$$
DELIMITER ;

/* OBTENER EL VOLUMEN, NUMERO DE LA PUBLICACIÓN */
DELIMITER $$
CREATE PROCEDURE `SP_GET_NUM_VOLUM` (IN ID_SUBMISSION INTEGER)
BEGIN
	DECLARE ID_ISSUE INTEGER; 
    DECLARE ID_PUBLICATION INTEGER;
    
    SET ID_PUBLICATION = (SELECT CURRENT_PUBLICATION_ID FROM SUBMISSIONS where SUBMISSION_ID = ID_SUBMISSION);
    SET ID_ISSUE = (SELECT SETTING_VALUE fROM PUBLICATION_SETTINGS WHERE PUBLICATION_ID = ID_PUBLICATION AND SETTING_NAME LIKE "issueId%");
    
    SELECT VOLUME, NUMBER FROM ojournal.issues where ISSUE_ID = ID_ISSUE;
END$$
DELIMITER ;

/*OBTENER EL FILTRO POR NOMBRE DEL ARTÍCULO */
DELIMITER $$
CREATE PROCEDURE `SP_GET_FILTER_TITLE`(IN ARTICLE_TITLE VARCHAR(500))
BEGIN
	SELECT (SELECT SUBMISSION_ID FROM SUBMISSIONS WHERE CURRENT_PUBLICATION_ID = PS.PUBLICATION_ID ) AS SUBMISSION_ID,
	(SELECT JOURNAL_ID FROM SECTIONS AS SEC WHERE SEC.SECTION_ID = (SELECT SECTION_ID FROM PUBLICATIONS WHERE PUBLICATION_ID = PS.PUBLICATION_ID)) AS JOURNAL,
	(SELECT TRIM(REPLACE(SETTING_VALUE, '  ', ' ')) FROM PUBLICATION_SETTINGS WHERE SETTING_NAME LIKE "TITLE%" AND LOCALE LIKE "es_ES%" AND PS.PUBLICATION_ID = PUBLICATION_ID) AS TITLE, 
	(SELECT STATUS FROM SUBMISSIONS WHERE CURRENT_PUBLICATION_ID = PS.PUBLICATION_ID) AS STATE 
	FROM PUBLICATION_SETTINGS AS PS 
	WHERE TRIM(REPLACE(SETTING_VALUE, '  ', ' ')) IN 
	(SELECT TRIM(REPLACE(SETTING_VALUE, '  ', ' ')) FROM PUBLICATION_SETTINGS 
	WHERE (SETTING_NAME LIKE "TITLE%" AND LOCALE LIKE "es_ES%") AND TRIM(REPLACE(SETTING_VALUE, '  ', ' ')) LIKE TRIM(REPLACE(ARTICLE_TITLE, '  ', ' '))
	AND (SELECT STATUS FROM SUBMISSIONS WHERE STATUS = 3 AND CURRENT_PUBLICATION_ID = PS.PUBLICATION_ID)
	AND (SELECT SUBMISSION_ID FROM SUBMISSIONS WHERE CURRENT_PUBLICATION_ID = PS.PUBLICATION_ID  AND CURRENT_PUBLICATION_ID IS NOT NULL)) 
	GROUP BY PUBLICATION_ID LIMIT 10;
END$$
DELIMITER ;

/*OBTENER EL FILTRO POR USERNAME DEL ARTÍCULO */
DELIMITER $$
CREATE PROCEDURE `SP_GET_FILTER_USERNAME`(IN USER_NAME VARCHAR(500))
BEGIN
	SELECT (SELECT SUBMISSION_ID FROM SUBMISSIONS WHERE AUTH.PUBLICATION_ID = CURRENT_PUBLICATION_ID) AS SUBMISSION_ID, 
	PUBLICATION_ID,
    (SELECT JOURNAL_ID FROM SECTIONS AS SEC WHERE SEC.SECTION_ID = (SELECT SECTION_ID FROM PUBLICATIONS WHERE PUBLICATION_ID = AUTH.PUBLICATION_ID)) 
	AS JOURNAL,
    (SELECT TRIM(REPLACE(SETTING_VALUE, '  ', ' ')) FROM PUBLICATION_SETTINGS AS PS WHERE (SETTING_NAME LIKE "TITLE%" AND LOCALE LIKE "es_ES%")
	AND AUTH.PUBLICATION_ID = PS.PUBLICATION_ID) AS TITLE, 
	(SELECT STATUS FROM SUBMISSIONS WHERE STATUS = 3 AND CURRENT_PUBLICATION_ID = AUTH.PUBLICATION_ID) AS STATE 
	FROM AUTHORS AS AUTH WHERE EMAIL IN (SELECT EMAIL FROM USERS WHERE USERNAME LIKE USER_NAME) 
    AND (SELECT SETTING_VALUE FROM PUBLICATION_SETTINGS AS PS WHERE (SETTING_NAME LIKE "TITLE%" AND LOCALE LIKE "es_ES%")
    AND (SELECT STATUS FROM SUBMISSIONS WHERE STATUS = 3 AND CURRENT_PUBLICATION_ID = AUTH.PUBLICATION_ID)
	AND AUTH.PUBLICATION_ID = PS.PUBLICATION_ID) IS NOT NULL
	GROUP BY AUTH.PUBLICATION_ID;
END$$
DELIMITER ;