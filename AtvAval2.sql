CREATE DATABASE clinicaMedica;

USE clinicaMedica;

CREATE TABLE clinica (
codigo INTEGER AUTO_INCREMENT PRIMARY KEY,
paciente VARCHAR(60),
medico VARCHAR(60),
dataConsulta DATE,
tipoConsulta VARCHAR(20),
valor DOUBLE
);

INSERT INTO clinica(paciente, medico, dataConsulta, tipoConsulta, valor) VALUES #Particular, SUS, Plano de Saúde, Social
('Auri','John','2019-10-10','Plano de Saúde','750.00'),
('Beto','Bruno','2019-10-16','SUS','1000.00'),
('Carlos','Bruno','2019-10-14','Social','380.00'),
('Dennis','John','2019-10-16','Social','430.00'),
('Edson','John','2019-11-05','Particular','6549.90'),
('Fernando','Bruno','2019-10-28','Plano de Saúde','600.00'),
('Gilson','Bruno','2019-11-01','SUS','2300.00'),
('Humberto','John','2019-11-12','Particular','1894.90');

DROP TABLE clinica;
SELECT * FROM clinica; 
DELETE FROM clinica WHERE tipoConsulta LIKE'Plano de Saúde'; 

