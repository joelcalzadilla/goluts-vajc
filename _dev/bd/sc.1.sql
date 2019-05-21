ALTER TABLE articulos
  DROP KEY descripcion;
ALTER TABLE articulos
  CHANGE  descripcion descripcion VARCHAR(100) COLLATE utf8_general_ci;
ALTER TABLE articulos
  ADD INDEX (descripcion);
