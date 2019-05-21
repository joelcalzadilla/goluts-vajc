DROP TABLE IF EXISTS fs_performance_log;
CREATE TABLE fs_performance_log
(
    id          INT          NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fe_inicio   VARCHAR(255) NOT NULL,
    fe_final    TIME         NOT NULL,
    descripcion VARCHAR(255) NOT NULL
);
