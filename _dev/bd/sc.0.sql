ALTER TABLE articulos
  DROP KEY descripcion;
ALTER TABLE articulos
  ADD INDEX (descripcion(100));
