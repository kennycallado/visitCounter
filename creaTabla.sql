CREATE TABLE IF NOT EXISTS visita (
  id int AUTO_INCREMENT PRIMARY KEY,
  fecha timestamp,
  os varchar(20),
  browser varchar(20),
  pais varchar(30),
  comunidad varchar(30),
  provincia varchar(30),
  ciudad varchar(30)
) CHARACTER SET utf8; 
