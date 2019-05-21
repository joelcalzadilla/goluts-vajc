/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50719
 Source Host           : localhost:3306
 Source Schema         : fs_goluts

 Target Server Type    : MySQL
 Target Server Version : 50719
 File Encoding         : 65001

 Date: 02/01/2019 02:48:48
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for agenciastrans
-- ----------------------------
DROP TABLE IF EXISTS `agenciastrans`;
CREATE TABLE `agenciastrans`  (
  `codtrans` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `telefono` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `web` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`codtrans`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for agentes
-- ----------------------------
DROP TABLE IF EXISTS `agentes`;
CREATE TABLE `agentes`  (
  `apellidos` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `ciudad` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `coddepartamento` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpais` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpostal` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `direccion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `dnicif` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fax` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idprovincia` int(11) NULL DEFAULT NULL,
  `idusuario` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `irpf` double NULL DEFAULT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `nombreap` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `porcomision` double NULL DEFAULT NULL,
  `provincia` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `telefono` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `seg_social` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `cargo` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `banco` varchar(34) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `f_alta` date NULL DEFAULT NULL,
  `f_baja` date NULL DEFAULT NULL,
  `f_nacimiento` date NULL DEFAULT NULL,
  `pin` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `rfid` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `carrera` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `centroestudios` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codarea` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codbanco` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcargo` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codformacion` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codgerencia` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codmotivocese` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codseguridadsocial` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsistemapension` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsupervisor` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsupervisorf` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codtipo` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `cuenta_banco` varchar(34) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `dependientes` int(11) NULL DEFAULT NULL,
  `estado` varchar(1) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `estado_civil` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fecha_creacion` timestamp(0) NULL DEFAULT NULL,
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `foto` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idempresa` int(11) NULL DEFAULT NULL,
  `idsindicato` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `pago_neto` double NOT NULL DEFAULT 0,
  `pago_total` double NOT NULL DEFAULT 0,
  `codigo_pension` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `segundo_apellido` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `sexo` varchar(1) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `tiempo_contrato` int(11) NULL DEFAULT NULL,
  `tipo_cuenta` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`codagente`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for albaranescli
-- ----------------------------
DROP TABLE IF EXISTS `albaranescli`;
CREATE TABLE `albaranescli`  (
  `apartado` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `cifnif` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ciudad` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcliente` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `coddir` int(11) NULL DEFAULT NULL,
  `coddivisa` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codpago` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codpais` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpostal` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codserie` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `direccion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `fecha` date NOT NULL,
  `hora` time(0) NULL DEFAULT '00:00:00',
  `femail` date NULL DEFAULT NULL,
  `idalbaran` int(11) NOT NULL AUTO_INCREMENT,
  `idfactura` int(11) NULL DEFAULT NULL,
  `idprovincia` int(11) NULL DEFAULT NULL,
  `irpf` double NOT NULL DEFAULT 0,
  `netosindto` double NOT NULL DEFAULT 0,
  `neto` double NOT NULL DEFAULT 0,
  `nombrecliente` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `numero` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `numero2` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `porcomision` double NULL DEFAULT NULL,
  `provincia` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `ptefactura` tinyint(1) NOT NULL DEFAULT 1,
  `recfinanciero` double NOT NULL DEFAULT 0,
  `tasaconv` double NOT NULL DEFAULT 1,
  `total` double NOT NULL DEFAULT 0,
  `totaleuros` double NOT NULL DEFAULT 0,
  `totalirpf` double NOT NULL DEFAULT 0,
  `totaliva` double NOT NULL DEFAULT 0,
  `totalrecargo` double NOT NULL DEFAULT 0,
  `codtrans` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codigoenv` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `nombreenv` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `apellidosenv` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `direccionenv` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpostalenv` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `ciudadenv` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `provinciaenv` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `apartadoenv` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpaisenv` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `numdocs` int(11) NULL DEFAULT 0,
  `dtopor1` double NOT NULL DEFAULT 0,
  `dtopor2` double NOT NULL DEFAULT 0,
  `dtopor3` double NOT NULL DEFAULT 0,
  `dtopor4` double NOT NULL DEFAULT 0,
  `dtopor5` double NOT NULL DEFAULT 0,
  `codruta` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codvendedor` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idalbaran`) USING BTREE,
  UNIQUE INDEX `uniq_codigo_albaranescli`(`codigo`) USING BTREE,
  INDEX `ca_albaranescli_series2`(`codserie`) USING BTREE,
  INDEX `ca_albaranescli_ejercicios2`(`codejercicio`) USING BTREE,
  INDEX `ca_albaranescli_facturas`(`idfactura`) USING BTREE,
  CONSTRAINT `ca_albaranescli_ejercicios2` FOREIGN KEY (`codejercicio`) REFERENCES `ejercicios` (`codejercicio`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `ca_albaranescli_facturas` FOREIGN KEY (`idfactura`) REFERENCES `facturascli` (`idfactura`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `ca_albaranescli_series2` FOREIGN KEY (`codserie`) REFERENCES `series` (`codserie`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for albaranesprov
-- ----------------------------
DROP TABLE IF EXISTS `albaranesprov`;
CREATE TABLE `albaranesprov`  (
  `cifnif` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `coddivisa` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codpago` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codproveedor` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codserie` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `fecha` date NOT NULL,
  `hora` time(0) NOT NULL DEFAULT '00:00:00',
  `idalbaran` int(11) NOT NULL AUTO_INCREMENT,
  `idfactura` int(11) NULL DEFAULT NULL,
  `irpf` double NOT NULL DEFAULT 0,
  `neto` double NOT NULL DEFAULT 0,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `numero` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `numproveedor` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `ptefactura` tinyint(1) NOT NULL DEFAULT 1,
  `recfinanciero` double NOT NULL DEFAULT 0,
  `tasaconv` double NOT NULL DEFAULT 1,
  `total` double NOT NULL DEFAULT 0,
  `totaleuros` double NOT NULL DEFAULT 0,
  `totalirpf` double NOT NULL DEFAULT 0,
  `totaliva` double NOT NULL DEFAULT 0,
  `totalrecargo` double NOT NULL DEFAULT 0,
  `numdocs` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`idalbaran`) USING BTREE,
  UNIQUE INDEX `uniq_codigo_albaranesprov`(`codigo`) USING BTREE,
  INDEX `ca_albaranesprov_series2`(`codserie`) USING BTREE,
  INDEX `ca_albaranesprov_ejercicios2`(`codejercicio`) USING BTREE,
  INDEX `ca_albaranesprov_facturas`(`idfactura`) USING BTREE,
  CONSTRAINT `ca_albaranesprov_ejercicios2` FOREIGN KEY (`codejercicio`) REFERENCES `ejercicios` (`codejercicio`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `ca_albaranesprov_facturas` FOREIGN KEY (`idfactura`) REFERENCES `facturasprov` (`idfactura`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `ca_albaranesprov_series2` FOREIGN KEY (`codserie`) REFERENCES `series` (`codserie`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for almacenes
-- ----------------------------
DROP TABLE IF EXISTS `almacenes`;
CREATE TABLE `almacenes`  (
  `apartado` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codpais` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpostal` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `contacto` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `direccion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fax` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idprovincia` int(11) NULL DEFAULT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `poblacion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `porpvp` double NULL DEFAULT NULL,
  `provincia` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `telefono` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `tipovaloracion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`codalmacen`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for articulo_codbarras
-- ----------------------------
DROP TABLE IF EXISTS `articulo_codbarras`;
CREATE TABLE `articulo_codbarras`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codbarras` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `articulo_codbarras_referencia_index`(`referencia`) USING BTREE,
  INDEX `articulo_codbarras_codbarras_index`(`codbarras`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for articulo_combinaciones
-- ----------------------------
DROP TABLE IF EXISTS `articulo_combinaciones`;
CREATE TABLE `articulo_combinaciones`  (
  `codbarras` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codigo` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codigo2` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idvalor` int(11) NOT NULL,
  `impactoprecio` double NOT NULL DEFAULT 0,
  `nombreatributo` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `refcombinacion` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `stockfis` double NULL DEFAULT 0,
  `valor` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uniq_articulo_combinaciones`(`codigo`, `referencia`, `idvalor`) USING BTREE,
  INDEX `ca_articulo_combinaciones_valores`(`idvalor`) USING BTREE,
  INDEX `ca_articulo_combinaciones_articulos`(`referencia`) USING BTREE,
  CONSTRAINT `ca_articulo_combinaciones_articulos` FOREIGN KEY (`referencia`) REFERENCES `articulos` (`referencia`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ca_articulo_combinaciones_valores` FOREIGN KEY (`idvalor`) REFERENCES `atributos_valores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for articulo_propiedades
-- ----------------------------
DROP TABLE IF EXISTS `articulo_propiedades`;
CREATE TABLE `articulo_propiedades`  (
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  PRIMARY KEY (`name`, `referencia`) USING BTREE,
  INDEX `ca_articulo_propiedades_articulos`(`referencia`) USING BTREE,
  CONSTRAINT `ca_articulo_propiedades_articulos` FOREIGN KEY (`referencia`) REFERENCES `articulos` (`referencia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for articulo_trazas
-- ----------------------------
DROP TABLE IF EXISTS `articulo_trazas`;
CREATE TABLE `articulo_trazas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `numserie` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `lote` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fecha_entrada` date NULL DEFAULT NULL,
  `fecha_salida` date NULL DEFAULT NULL,
  `idlalbventa` int(11) NULL DEFAULT NULL,
  `idlfacventa` int(11) NULL DEFAULT NULL,
  `idlalbcompra` int(11) NULL DEFAULT NULL,
  `idlfaccompra` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uniq_codigo_articulo_trazas`(`numserie`) USING BTREE,
  INDEX `ca_articulo_trazas_articulos`(`referencia`) USING BTREE,
  INDEX `ca_articulo_trazas_linalbcli`(`idlalbventa`) USING BTREE,
  INDEX `ca_articulo_trazas_linfaccli`(`idlfacventa`) USING BTREE,
  INDEX `ca_articulo_trazas_linalbprov`(`idlalbcompra`) USING BTREE,
  INDEX `ca_articulo_trazas_linfacprov`(`idlfaccompra`) USING BTREE,
  CONSTRAINT `ca_articulo_trazas_articulos` FOREIGN KEY (`referencia`) REFERENCES `articulos` (`referencia`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ca_articulo_trazas_linalbcli` FOREIGN KEY (`idlalbventa`) REFERENCES `lineasalbaranescli` (`idlinea`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `ca_articulo_trazas_linalbprov` FOREIGN KEY (`idlalbcompra`) REFERENCES `lineasalbaranesprov` (`idlinea`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `ca_articulo_trazas_linfaccli` FOREIGN KEY (`idlfacventa`) REFERENCES `lineasfacturascli` (`idlinea`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `ca_articulo_trazas_linfacprov` FOREIGN KEY (`idlfaccompra`) REFERENCES `lineasfacturasprov` (`idlinea`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for articulo_unidadmedida
-- ----------------------------
DROP TABLE IF EXISTS `articulo_unidadmedida`;
CREATE TABLE `articulo_unidadmedida`  (
  `base` tinyint(1) NOT NULL DEFAULT 0,
  `factor` decimal(10, 0) NOT NULL DEFAULT 1,
  `codum` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `peso` decimal(10, 0) NULL DEFAULT NULL,
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `se_compra` tinyint(1) NOT NULL DEFAULT 0,
  `se_vende` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`codum`, `referencia`) USING BTREE,
  INDEX `ca_articulo_unidadmedida_articulos`(`referencia`) USING BTREE,
  CONSTRAINT `ca_articulo_unidadmedida_articulos` FOREIGN KEY (`referencia`) REFERENCES `articulos` (`referencia`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for articulos
-- ----------------------------
DROP TABLE IF EXISTS `articulos`;
CREATE TABLE `articulos`  (
  `factualizado` date NULL DEFAULT NULL,
  `bloqueado` tinyint(1) NULL DEFAULT 0,
  `equivalencia` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idsubcuentairpfcom` int(11) NULL DEFAULT NULL,
  `idsubcuentacom` int(11) NULL DEFAULT NULL,
  `stockmin` double NULL DEFAULT 0,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `codbarras` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codimpuesto` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `stockfis` double NULL DEFAULT 0,
  `stockmax` double NULL DEFAULT 0,
  `costemedio` double NULL DEFAULT 0,
  `preciocoste` double NULL DEFAULT 0,
  `tipocodbarras` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT 'Code39',
  `nostock` tinyint(1) NULL DEFAULT 0,
  `codsubcuentacom` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `codsubcuentairpfcom` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `secompra` tinyint(1) NULL DEFAULT 1,
  `codfamilia` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codfabricante` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `imagen` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `controlstock` tinyint(1) NULL DEFAULT 0,
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `tipo` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `pvp` double NULL DEFAULT 0,
  `sevende` tinyint(1) NULL DEFAULT 1,
  `publico` tinyint(1) NULL DEFAULT 0,
  `partnumber` varchar(38) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `trazabilidad` tinyint(1) NULL DEFAULT 0,
  `distribuidora` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `reservas` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `fechaultrecepcion` date NULL DEFAULT NULL,
  `ultrecepcion` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `ultunidades` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `venta_historica` float(10, 2) NULL DEFAULT NULL,
  `penulrecepcion` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `penultunidades` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `antepenulrecepcion` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `antepenulunidades` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `pvp_anterior` double NULL DEFAULT NULL,
  `num_ultimo_recibido` float(10, 2) NULL DEFAULT NULL,
  `num_anterior_del_anterior` float(10, 2) NULL DEFAULT NULL,
  `uds_num_anterior_del_anterior` float(10, 2) NULL DEFAULT NULL,
  `num_anterior` float(10, 2) NULL DEFAULT NULL,
  `uds_num_anterior` float(10, 2) NULL DEFAULT NULL,
  `uds_recibidas_ult_reparto` float(10, 2) NULL DEFAULT NULL,
  `stock_vendido_ult_recepcion` float(10, 2) NULL DEFAULT NULL,
  `fcodigo` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fecha_recepcion` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `key_bd` tinyint(1) NOT NULL,
  `notas` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `devuelto_descatalogado` tinyint(1) NULL DEFAULT 0,
  `codbarras_numerico` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `referencia_numerica` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`referencia`) USING BTREE,
  INDEX `ca_articulos_impuestos`(`codimpuesto`) USING BTREE,
  INDEX `ca_articulos_familias`(`codfamilia`) USING BTREE,
  INDEX `ca_articulos_fabricantes`(`codfabricante`) USING BTREE,
  INDEX `articulos_codbarras_index`(`codbarras`) USING BTREE,
  INDEX `key_bd`(`key_bd`) USING BTREE,
  INDEX `codbarras_numerico`(`codbarras_numerico`) USING BTREE,
  INDEX `referencia_numerica`(`referencia_numerica`) USING BTREE,
  INDEX `referencia`(`referencia`, `referencia_numerica`, `codbarras`, `codbarras_numerico`) USING BTREE,
  INDEX `descripcion`(`descripcion`) USING BTREE,
  CONSTRAINT `ca_articulos_fabricantes` FOREIGN KEY (`codfabricante`) REFERENCES `fabricantes` (`codfabricante`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `ca_articulos_familias` FOREIGN KEY (`codfamilia`) REFERENCES `familias` (`codfamilia`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `ca_articulos_impuestos` FOREIGN KEY (`codimpuesto`) REFERENCES `impuestos` (`codimpuesto`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for articulosprov
-- ----------------------------
DROP TABLE IF EXISTS `articulosprov`;
CREATE TABLE `articulosprov`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codproveedor` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `refproveedor` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `precio` double NULL DEFAULT 0,
  `dto` double NULL DEFAULT 0,
  `codimpuesto` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `stock` double NULL DEFAULT 0,
  `nostock` tinyint(1) NULL DEFAULT 1,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `coddivisa` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codbarras` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `partnumber` varchar(38) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uniq_articulo_proveedor2`(`codproveedor`, `refproveedor`) USING BTREE,
  CONSTRAINT `ca_articulosprov_proveedores` FOREIGN KEY (`codproveedor`) REFERENCES `proveedores` (`codproveedor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for atributos
-- ----------------------------
DROP TABLE IF EXISTS `atributos`;
CREATE TABLE `atributos`  (
  `codatributo` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`codatributo`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for atributos_valores
-- ----------------------------
DROP TABLE IF EXISTS `atributos_valores`;
CREATE TABLE `atributos_valores`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codatributo` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `valor` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ca_atributos_valores`(`codatributo`) USING BTREE,
  CONSTRAINT `ca_atributos_valores` FOREIGN KEY (`codatributo`) REFERENCES `atributos` (`codatributo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bancos
-- ----------------------------
DROP TABLE IF EXISTS `bancos`;
CREATE TABLE `bancos`  (
  `codbanco` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  `nombre` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codigo_alterno` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `tipo` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`codbanco`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for beneficios
-- ----------------------------
DROP TABLE IF EXISTS `beneficios`;
CREATE TABLE `beneficios`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_pre` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codigo_ped` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codigo_alb` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codigo_fac` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `precioneto` double NULL DEFAULT 0,
  `preciocoste` double NULL DEFAULT 0,
  `beneficio` double NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uniq_codigo_pre`(`codigo_pre`) USING BTREE,
  UNIQUE INDEX `uniq_codigo_ped`(`codigo_ped`) USING BTREE,
  UNIQUE INDEX `uniq_codigo_alb`(`codigo_alb`) USING BTREE,
  UNIQUE INDEX `uniq_codigo_fac`(`codigo_fac`) USING BTREE,
  CONSTRAINT `ca_codigo_alb` FOREIGN KEY (`codigo_alb`) REFERENCES `albaranescli` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ca_codigo_fac` FOREIGN KEY (`codigo_fac`) REFERENCES `facturascli` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ca_codigo_ped` FOREIGN KEY (`codigo_ped`) REFERENCES `pedidoscli` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ca_codigo_pre` FOREIGN KEY (`codigo_pre`) REFERENCES `presupuestoscli` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cajas
-- ----------------------------
DROP TABLE IF EXISTS `cajas`;
CREATE TABLE `cajas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fs_id` int(11) NOT NULL,
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `f_inicio` timestamp(0) NOT NULL DEFAULT '2018-12-03 00:00:00',
  `d_inicio` double NOT NULL DEFAULT 0,
  `f_fin` timestamp(0) NULL DEFAULT NULL,
  `d_fin` double NULL DEFAULT NULL,
  `tickets` int(11) NULL DEFAULT NULL,
  `ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cajas_terminales
-- ----------------------------
DROP TABLE IF EXISTS `cajas_terminales`;
CREATE TABLE `cajas_terminales`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codserie` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codcliente` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `tickets` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `anchopapel` int(11) NULL DEFAULT NULL,
  `comandocorte` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `comandoapertura` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `num_tickets` int(11) NULL DEFAULT NULL,
  `sin_comandos` tinyint(1) NULL DEFAULT 0,
  `nombre` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `comandologo` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `cambiar_agente` tinyint(1) NULL DEFAULT 1,
  `forzar_pin` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for clientes
-- ----------------------------
DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes`  (
  `capitalimpagado` double NULL DEFAULT NULL,
  `cifnif` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcliente` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codcontacto` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcuentadom` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcuentarem` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `coddivisa` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codedi` varchar(17) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codgrupo` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpago` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codserie` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuenta` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codtiporappel` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `contacto` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `copiasfactura` int(11) NULL DEFAULT NULL,
  `debaja` tinyint(1) NULL DEFAULT 0,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fax` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fechabaja` date NULL DEFAULT NULL,
  `fechaalta` date NULL DEFAULT NULL,
  `idsubcuenta` int(11) NULL DEFAULT NULL,
  `ivaincluido` tinyint(1) NULL DEFAULT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `razonsocial` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `recargo` tinyint(1) NULL DEFAULT NULL,
  `regimeniva` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `riesgoalcanzado` double NULL DEFAULT NULL,
  `riesgomax` double NULL DEFAULT NULL,
  `telefono1` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `telefono2` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `tipoidfiscal` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'NIF',
  `personafisica` tinyint(1) NULL DEFAULT 1,
  `web` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `diaspago` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codproveedor` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codtarifa` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`codcliente`) USING BTREE,
  INDEX `ca_clientes_grupos`(`codgrupo`) USING BTREE,
  CONSTRAINT `ca_clientes_grupos` FOREIGN KEY (`codgrupo`) REFERENCES `gruposclientes` (`codgrupo`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for co_asientos
-- ----------------------------
DROP TABLE IF EXISTS `co_asientos`;
CREATE TABLE `co_asientos`  (
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codplanasiento` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `concepto` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `documento` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `editable` tinyint(1) NOT NULL,
  `fecha` date NOT NULL,
  `idasiento` int(11) NOT NULL AUTO_INCREMENT,
  `idconcepto` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `importe` double NULL DEFAULT NULL,
  `numero` int(11) NOT NULL,
  `tipodocumento` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idasiento`) USING BTREE,
  INDEX `ca_co_asientos_ejercicios2`(`codejercicio`) USING BTREE,
  CONSTRAINT `ca_co_asientos_ejercicios2` FOREIGN KEY (`codejercicio`) REFERENCES `ejercicios` (`codejercicio`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for co_codbalances08
-- ----------------------------
DROP TABLE IF EXISTS `co_codbalances08`;
CREATE TABLE `co_codbalances08`  (
  `descripcion4ba` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `descripcion4` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `nivel4` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `descripcion3` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `orden3` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `nivel3` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `descripcion2` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `nivel2` int(11) NULL DEFAULT NULL,
  `descripcion1` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `nivel1` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `naturaleza` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codbalance` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`codbalance`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for co_conceptospar
-- ----------------------------
DROP TABLE IF EXISTS `co_conceptospar`;
CREATE TABLE `co_conceptospar`  (
  `concepto` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idconceptopar` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idconceptopar`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for co_cuentas
-- ----------------------------
DROP TABLE IF EXISTS `co_cuentas`;
CREATE TABLE `co_cuentas`  (
  `codbalance` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcuenta` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codepigrafe` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idcuenta` int(11) NOT NULL AUTO_INCREMENT,
  `idcuentaesp` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idepigrafe` int(11) NOT NULL,
  PRIMARY KEY (`idcuenta`) USING BTREE,
  UNIQUE INDEX `uniq_codcuenta`(`codcuenta`, `codejercicio`) USING BTREE,
  INDEX `ca_co_cuentas_ejercicios`(`codejercicio`) USING BTREE,
  INDEX `ca_co_cuentas_epigrafes2`(`idepigrafe`) USING BTREE,
  CONSTRAINT `ca_co_cuentas_ejercicios` FOREIGN KEY (`codejercicio`) REFERENCES `ejercicios` (`codejercicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ca_co_cuentas_epigrafes2` FOREIGN KEY (`idepigrafe`) REFERENCES `co_epigrafes` (`idepigrafe`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for co_cuentascbba
-- ----------------------------
DROP TABLE IF EXISTS `co_cuentascbba`;
CREATE TABLE `co_cuentascbba`  (
  `desccuenta` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcuenta` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codbalance` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for co_cuentasesp
-- ----------------------------
DROP TABLE IF EXISTS `co_cuentasesp`;
CREATE TABLE `co_cuentasesp`  (
  `codcuenta` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuenta` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idcuentaesp` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idcuentaesp`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for co_epigrafes
-- ----------------------------
DROP TABLE IF EXISTS `co_epigrafes`;
CREATE TABLE `co_epigrafes`  (
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codepigrafe` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idepigrafe` int(11) NOT NULL AUTO_INCREMENT,
  `idgrupo` int(11) NULL DEFAULT NULL,
  `idpadre` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`idepigrafe`) USING BTREE,
  INDEX `ca_co_epigrafes_ejercicios`(`codejercicio`) USING BTREE,
  INDEX `ca_co_epigrafes_gruposepigrafes2`(`idgrupo`) USING BTREE,
  CONSTRAINT `ca_co_epigrafes_ejercicios` FOREIGN KEY (`codejercicio`) REFERENCES `ejercicios` (`codejercicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ca_co_epigrafes_gruposepigrafes2` FOREIGN KEY (`idgrupo`) REFERENCES `co_gruposepigrafes` (`idgrupo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for co_gruposepigrafes
-- ----------------------------
DROP TABLE IF EXISTS `co_gruposepigrafes`;
CREATE TABLE `co_gruposepigrafes`  (
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codgrupo` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idgrupo` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idgrupo`) USING BTREE,
  INDEX `ca_co_gruposepigrafes_ejercicios`(`codejercicio`) USING BTREE,
  CONSTRAINT `ca_co_gruposepigrafes_ejercicios` FOREIGN KEY (`codejercicio`) REFERENCES `ejercicios` (`codejercicio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for co_regiva
-- ----------------------------
DROP TABLE IF EXISTS `co_regiva`;
CREATE TABLE `co_regiva`  (
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codsubcuentaacr` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuentadeu` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fechaasiento` date NOT NULL,
  `fechafin` date NOT NULL,
  `fechainicio` date NOT NULL,
  `idasiento` int(11) NOT NULL,
  `idregiva` int(11) NOT NULL AUTO_INCREMENT,
  `idsubcuentaacr` int(11) NULL DEFAULT NULL,
  `idsubcuentadeu` int(11) NULL DEFAULT NULL,
  `periodo` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idregiva`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for co_secuencias
-- ----------------------------
DROP TABLE IF EXISTS `co_secuencias`;
CREATE TABLE `co_secuencias`  (
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idsecuencia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `valor` int(11) NULL DEFAULT NULL,
  `valorout` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`idsecuencia`) USING BTREE,
  INDEX `ca_co_secuencias_ejercicios`(`codejercicio`) USING BTREE,
  CONSTRAINT `ca_co_secuencias_ejercicios` FOREIGN KEY (`codejercicio`) REFERENCES `ejercicios` (`codejercicio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for co_subcuentas
-- ----------------------------
DROP TABLE IF EXISTS `co_subcuentas`;
CREATE TABLE `co_subcuentas`  (
  `codcuenta` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `coddivisa` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codimpuesto` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuenta` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `debe` double NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `haber` double NOT NULL,
  `idcuenta` int(11) NULL DEFAULT NULL,
  `idsubcuenta` int(11) NOT NULL AUTO_INCREMENT,
  `iva` double NOT NULL,
  `recargo` double NOT NULL,
  `saldo` double NOT NULL,
  PRIMARY KEY (`idsubcuenta`) USING BTREE,
  UNIQUE INDEX `uniq_codsubcuenta`(`codsubcuenta`, `codejercicio`) USING BTREE,
  INDEX `ca_co_subcuentas_ejercicios`(`codejercicio`) USING BTREE,
  INDEX `ca_co_subcuentas_cuentas2`(`idcuenta`) USING BTREE,
  CONSTRAINT `ca_co_subcuentas_cuentas2` FOREIGN KEY (`idcuenta`) REFERENCES `co_cuentas` (`idcuenta`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ca_co_subcuentas_ejercicios` FOREIGN KEY (`codejercicio`) REFERENCES `ejercicios` (`codejercicio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for co_subcuentascli
-- ----------------------------
DROP TABLE IF EXISTS `co_subcuentascli`;
CREATE TABLE `co_subcuentascli`  (
  `codcliente` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codsubcuenta` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idsubcuenta` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ca_co_subcuentascli_ejercicios`(`codejercicio`) USING BTREE,
  INDEX `ca_co_subcuentascli_clientes`(`codcliente`) USING BTREE,
  INDEX `ca_co_subcuentascli_subcuentas`(`idsubcuenta`) USING BTREE,
  CONSTRAINT `ca_co_subcuentascli_clientes` FOREIGN KEY (`codcliente`) REFERENCES `clientes` (`codcliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ca_co_subcuentascli_ejercicios` FOREIGN KEY (`codejercicio`) REFERENCES `ejercicios` (`codejercicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ca_co_subcuentascli_subcuentas` FOREIGN KEY (`idsubcuenta`) REFERENCES `co_subcuentas` (`idsubcuenta`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for contratoservicioscli
-- ----------------------------
DROP TABLE IF EXISTS `contratoservicioscli`;
CREATE TABLE `contratoservicioscli`  (
  `idcontrato` int(11) NOT NULL AUTO_INCREMENT,
  `codcliente` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fecha_alta` date NOT NULL,
  `fecha_renovacion` date NOT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `codpago` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `importe_anual` double NULL DEFAULT NULL,
  `periodo` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fsiguiente_servicio` date NULL DEFAULT NULL,
  PRIMARY KEY (`idcontrato`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cuentasbanco
-- ----------------------------
DROP TABLE IF EXISTS `cuentasbanco`;
CREATE TABLE `cuentasbanco`  (
  `codsubcuenta` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `iban` varchar(34) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcuenta` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `swift` varchar(11) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`codcuenta`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cuentasbcocli
-- ----------------------------
DROP TABLE IF EXISTS `cuentasbcocli`;
CREATE TABLE `cuentasbcocli`  (
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `swift` varchar(11) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `ctaentidad` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `iban` varchar(34) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `agencia` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `entidad` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcliente` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ctaagencia` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcuenta` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `cuenta` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `principal` tinyint(1) NULL DEFAULT NULL,
  `fmandato` date NULL DEFAULT NULL,
  PRIMARY KEY (`codcuenta`) USING BTREE,
  INDEX `ca_cuentasbcocli_clientes`(`codcliente`) USING BTREE,
  CONSTRAINT `ca_cuentasbcocli_clientes` FOREIGN KEY (`codcliente`) REFERENCES `clientes` (`codcliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for cuentasbcopro
-- ----------------------------
DROP TABLE IF EXISTS `cuentasbcopro`;
CREATE TABLE `cuentasbcopro`  (
  `agencia` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcuenta` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codproveedor` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ctaagencia` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `ctaentidad` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `cuenta` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `entidad` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `iban` varchar(34) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `swift` varchar(11) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `principal` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`codcuenta`) USING BTREE,
  INDEX `ca_cuentasbcopro_proveedores`(`codproveedor`) USING BTREE,
  CONSTRAINT `ca_cuentasbcopro_proveedores` FOREIGN KEY (`codproveedor`) REFERENCES `proveedores` (`codproveedor`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for dirclientes
-- ----------------------------
DROP TABLE IF EXISTS `dirclientes`;
CREATE TABLE `dirclientes`  (
  `codcliente` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codpais` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `apartado` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idprovincia` int(11) NULL DEFAULT NULL,
  `provincia` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `ciudad` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpostal` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `direccion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `domenvio` tinyint(1) NULL DEFAULT NULL,
  `domfacturacion` tinyint(1) NULL DEFAULT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ca_dirclientes_clientes`(`codcliente`) USING BTREE,
  CONSTRAINT `ca_dirclientes_clientes` FOREIGN KEY (`codcliente`) REFERENCES `clientes` (`codcliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_asignacion_cargos
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_asignacion_cargos`;
CREATE TABLE `distribucion_asignacion_cargos`  (
  `codcargo` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `fecha_creacion` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `idempresa` int(11) NOT NULL,
  `tipo_cargo` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idempresa`, `codcargo`, `tipo_cargo`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_clientes
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_clientes`;
CREATE TABLE `distribucion_clientes`  (
  `canal` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codcliente` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `fecha_creacion` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `idempresa` int(11) NOT NULL,
  `iddireccion` int(11) NOT NULL,
  `ruta` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `subcanal` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idempresa`, `codcliente`, `codalmacen`, `ruta`, `iddireccion`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_conductores
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_conductores`;
CREATE TABLE `distribucion_conductores`  (
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codtrans` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  `fecha_creacion` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) NOT NULL,
  `idsubcuenta` int(11) NULL DEFAULT NULL,
  `licencia` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `nombre` varchar(80) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `tipolicencia` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuenta` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_coordenadas_clientes
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_coordenadas_clientes`;
CREATE TABLE `distribucion_coordenadas_clientes`  (
  `codcliente` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `coordenadas` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `fecha_creacion` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `iddireccion` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idempresa`, `codcliente`, `iddireccion`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_faltantes
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_faltantes`;
CREATE TABLE `distribucion_faltantes`  (
  `codtrans` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codcuenta` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcuentap` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `coddivisa` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `conductor` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idsubcuenta` int(11) NULL DEFAULT NULL,
  `idsubcuentap` int(11) NULL DEFAULT NULL,
  `dc` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `estado` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fecha` date NOT NULL,
  `fechap` date NULL DEFAULT NULL,
  `fechav` date NOT NULL,
  `fecha_creacion` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `idempresa` int(11) NOT NULL,
  `idrecibo` int(11) NOT NULL,
  `idreciboref` int(11) NULL DEFAULT NULL,
  `idasiento` int(11) NULL DEFAULT NULL,
  `idasientop` int(11) NULL DEFAULT NULL,
  `idtransporte` int(11) NOT NULL,
  `importe` double NOT NULL,
  `nombreconductor` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `tipo` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idempresa`, `codalmacen`, `idrecibo`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_lineasordenescarga
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_lineasordenescarga`;
CREATE TABLE `distribucion_lineasordenescarga`  (
  `cantidad` double NULL DEFAULT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  `fecha` date NOT NULL,
  `fecha_creacion` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `idempresa` int(11) NOT NULL,
  `idordencarga` int(11) NOT NULL,
  `peso` decimal(10, 0) NULL DEFAULT NULL,
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idempresa`, `codalmacen`, `idordencarga`, `referencia`) USING BTREE,
  CONSTRAINT `ca_linea_ordencarga` FOREIGN KEY (`idempresa`, `codalmacen`, `idordencarga`) REFERENCES `distribucion_ordenescarga` (`idempresa`, `codalmacen`, `idordencarga`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_lineastransporte
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_lineastransporte`;
CREATE TABLE `distribucion_lineastransporte`  (
  `cantidad` double NOT NULL,
  `devolucion` double NULL DEFAULT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  `fecha` date NOT NULL,
  `fecha_creacion` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `idempresa` int(11) NOT NULL,
  `idtransporte` int(11) NOT NULL,
  `importe` double NULL DEFAULT NULL,
  `peso` double NULL DEFAULT NULL,
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idempresa`, `codalmacen`, `idtransporte`, `referencia`) USING BTREE,
  CONSTRAINT `distribucion_lineastransporte_fkey` FOREIGN KEY (`idempresa`, `codalmacen`, `idtransporte`) REFERENCES `distribucion_transporte` (`idempresa`, `codalmacen`, `idtransporte`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_ordenescarga
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_ordenescarga`;
CREATE TABLE `distribucion_ordenescarga`  (
  `cargado` tinyint(1) NULL DEFAULT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codalmacen_dest` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codtrans` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `conductor` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `despachado` tinyint(1) NULL DEFAULT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  `fecha` date NOT NULL,
  `fecha_creacion` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `idempresa` int(11) NOT NULL,
  `idordencarga` int(11) NOT NULL,
  `idtransporte` int(11) NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `tipolicencia` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `tipounidad` int(11) NOT NULL,
  `totalcantidad` double NULL DEFAULT NULL,
  `totalpeso` double NULL DEFAULT NULL,
  `unidad` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idempresa`, `codalmacen`, `idordencarga`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_ordenescarga_facturas
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_ordenescarga_facturas`;
CREATE TABLE `distribucion_ordenescarga_facturas`  (
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `fecha` date NOT NULL,
  `fecha_creacion` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `idempresa` int(11) NOT NULL,
  `idfactura` int(11) NOT NULL,
  `idordencarga` int(11) NOT NULL,
  `idtransporte` int(11) NULL DEFAULT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idempresa`, `idordencarga`, `codalmacen`, `idfactura`) USING BTREE,
  INDEX `ca_facturas_ordenescarga`(`idempresa`, `codalmacen`, `idordencarga`) USING BTREE,
  CONSTRAINT `ca_facturas_ordenescarga` FOREIGN KEY (`idempresa`, `codalmacen`, `idordencarga`) REFERENCES `distribucion_ordenescarga` (`idempresa`, `codalmacen`, `idordencarga`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_organizacion
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_organizacion`;
CREATE TABLE `distribucion_organizacion`  (
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codsupervisor` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  `fecha_creacion` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `idempresa` int(11) NOT NULL,
  `tipoagente` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idempresa`, `codagente`, `tipoagente`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_restricciones_tiporuta
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_restricciones_tiporuta`;
CREATE TABLE `distribucion_restricciones_tiporuta`  (
  `fecha_creacion` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `id` int(11) NOT NULL,
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`referencia`, `id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_rutas
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_rutas`;
CREATE TABLE `distribucion_rutas`  (
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codruta` int(11) NULL DEFAULT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `domingo` tinyint(1) NULL DEFAULT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  `fecha_creacion` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `idempresa` int(11) NOT NULL,
  `jueves` tinyint(1) NULL DEFAULT NULL,
  `lunes` tinyint(1) NULL DEFAULT NULL,
  `martes` tinyint(1) NULL DEFAULT NULL,
  `miercoles` tinyint(1) NULL DEFAULT NULL,
  `ruta` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `sabado` tinyint(1) NULL DEFAULT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `viernes` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`idempresa`, `codagente`, `ruta`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_segmentos
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_segmentos`;
CREATE TABLE `distribucion_segmentos`  (
  `codigo` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codigo_padre` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  `fecha_creacion` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `idempresa` int(11) NOT NULL,
  `tiposegmento` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idempresa`, `codigo`, `tiposegmento`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_subcuentas_faltantes
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_subcuentas_faltantes`;
CREATE TABLE `distribucion_subcuentas_faltantes`  (
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codsubcuenta` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `conductor` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idempresa` int(11) NOT NULL,
  `idsubcuenta` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_tiporuta
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_tiporuta`;
CREATE TABLE `distribucion_tiporuta`  (
  `descripcion` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_creacion` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_tipounidad
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_tipounidad`;
CREATE TABLE `distribucion_tipounidad`  (
  `descripcion` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  `fecha_creacion` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `id` int(11) NOT NULL,
  `idempresa` int(11) NOT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idempresa`, `id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_tipovendedor
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_tipovendedor`;
CREATE TABLE `distribucion_tipovendedor`  (
  `descripcion` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  `fecha_creacion` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_transporte
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_transporte`;
CREATE TABLE `distribucion_transporte`  (
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codalmacen_dest` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codtrans` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `conductor` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `despachado` tinyint(1) NULL DEFAULT NULL,
  `devolucionado` tinyint(1) NULL DEFAULT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  `fecha` date NOT NULL,
  `fechad` date NULL DEFAULT NULL,
  `fechal` date NULL DEFAULT NULL,
  `fecha_creacion` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `idempresa` int(11) NOT NULL,
  `idordencarga` int(11) NOT NULL,
  `idtransporte` int(11) NOT NULL,
  `liquidado` tinyint(1) NULL DEFAULT NULL,
  `liquidacion_importe` double NULL DEFAULT NULL,
  `liquidacion_faltante` double NULL DEFAULT NULL,
  `tipolicencia` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `tipounidad` int(11) NOT NULL,
  `totalcantidad` double NULL DEFAULT NULL,
  `totalpeso` double NULL DEFAULT NULL,
  `totalimporte` double NULL DEFAULT NULL,
  `unidad` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idempresa`, `codalmacen`, `idtransporte`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for distribucion_unidades
-- ----------------------------
DROP TABLE IF EXISTS `distribucion_unidades`;
CREATE TABLE `distribucion_unidades`  (
  `capacidad` int(11) NOT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codtrans` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  `fecha_creacion` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `idempresa` int(11) NOT NULL,
  `placa` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `tipounidad` int(11) NOT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idempresa`, `placa`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for divisas
-- ----------------------------
DROP TABLE IF EXISTS `divisas`;
CREATE TABLE `divisas`  (
  `bandera` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `coddivisa` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codiso` varchar(5) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fecha` date NULL DEFAULT NULL,
  `simbolo` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `tasaconv` double NOT NULL,
  `tasaconv_compra` double NULL DEFAULT NULL,
  PRIMARY KEY (`coddivisa`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for documentosfac
-- ----------------------------
DROP TABLE IF EXISTS `documentosfac`;
CREATE TABLE `documentosfac`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ruta` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `nombre` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `fecha` date NULL DEFAULT NULL,
  `hora` time(0) NULL DEFAULT '00:00:00',
  `tamano` int(11) NULL DEFAULT NULL,
  `usuario` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idfactura` int(11) NULL DEFAULT NULL,
  `idalbaran` int(11) NULL DEFAULT NULL,
  `idpedido` int(11) NULL DEFAULT NULL,
  `idpresupuesto` int(11) NULL DEFAULT NULL,
  `idservicio` int(11) NULL DEFAULT NULL,
  `idfacturaprov` int(11) NULL DEFAULT NULL,
  `idalbaranprov` int(11) NULL DEFAULT NULL,
  `idpedidoprov` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ejercicios
-- ----------------------------
DROP TABLE IF EXISTS `ejercicios`;
CREATE TABLE `ejercicios`  (
  `idasientocierre` int(11) NULL DEFAULT NULL,
  `idasientopyg` int(11) NULL DEFAULT NULL,
  `idasientoapertura` int(11) NULL DEFAULT NULL,
  `plancontable` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `longsubcuenta` int(11) NULL DEFAULT NULL,
  `estado` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `fechafin` date NOT NULL,
  `fechainicio` date NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`codejercicio`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for empresa
-- ----------------------------
DROP TABLE IF EXISTS `empresa`;
CREATE TABLE `empresa`  (
  `administrador` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `apartado` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `cifnif` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ciudad` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcuentarem` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `coddivisa` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codedi` varchar(17) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpago` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpais` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpostal` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codserie` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `contintegrada` tinyint(1) NULL DEFAULT NULL,
  `direccion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fax` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `horario` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idprovincia` int(11) NULL DEFAULT NULL,
  `xid` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `lema` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `logo` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `nombrecorto` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `pie_factura` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `provincia` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `recequivalencia` tinyint(1) NULL DEFAULT NULL,
  `stockpedidos` tinyint(1) NULL DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `web` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `inicioact` date NULL DEFAULT NULL,
  `regimeniva` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for estados_servicios
-- ----------------------------
DROP TABLE IF EXISTS `estados_servicios`;
CREATE TABLE `estados_servicios`  (
  `id` int(11) NOT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `color` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `activo` tinyint(1) NULL DEFAULT 1,
  `albaran` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fabricantes
-- ----------------------------
DROP TABLE IF EXISTS `fabricantes`;
CREATE TABLE `fabricantes`  (
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codfabricante` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`codfabricante`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for facturascli
-- ----------------------------
DROP TABLE IF EXISTS `facturascli`;
CREATE TABLE `facturascli`  (
  `apartado` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `automatica` tinyint(1) NULL DEFAULT NULL,
  `cifnif` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ciudad` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcliente` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `coddir` int(11) NULL DEFAULT NULL,
  `coddivisa` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codigorect` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpago` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codpais` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpostal` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codserie` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `deabono` tinyint(1) NULL DEFAULT 0,
  `direccion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `editable` tinyint(1) NULL DEFAULT 0,
  `fecha` date NOT NULL,
  `vencimiento` date NULL DEFAULT NULL,
  `femail` date NULL DEFAULT NULL,
  `hora` time(0) NOT NULL DEFAULT '00:00:00',
  `idasiento` int(11) NULL DEFAULT NULL,
  `idasientop` int(11) NULL DEFAULT NULL,
  `idfactura` int(11) NOT NULL AUTO_INCREMENT,
  `idfacturarect` int(11) NULL DEFAULT NULL,
  `idpagodevol` int(11) NULL DEFAULT NULL,
  `idprovincia` int(11) NULL DEFAULT NULL,
  `irpf` double NOT NULL DEFAULT 0,
  `netosindto` double NOT NULL DEFAULT 0,
  `neto` double NOT NULL DEFAULT 0,
  `nogenerarasiento` tinyint(1) NULL DEFAULT NULL,
  `nombrecliente` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `numero` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `numero2` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `pagada` tinyint(1) NOT NULL DEFAULT 0,
  `anulada` tinyint(1) NOT NULL DEFAULT 0,
  `porcomision` double NULL DEFAULT NULL,
  `provincia` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `recfinanciero` double NULL DEFAULT NULL,
  `tasaconv` double NOT NULL DEFAULT 1,
  `total` double NOT NULL DEFAULT 0,
  `totaleuros` double NOT NULL DEFAULT 0,
  `totalirpf` double NOT NULL DEFAULT 0,
  `totaliva` double NOT NULL DEFAULT 0,
  `totalrecargo` double NULL DEFAULT NULL,
  `tpv` tinyint(1) NULL DEFAULT NULL,
  `codtrans` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codigoenv` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `nombreenv` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `apellidosenv` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `direccionenv` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpostalenv` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `ciudadenv` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `provinciaenv` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `apartadoenv` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpaisenv` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idimprenta` int(11) NULL DEFAULT NULL,
  `numdocs` int(11) NULL DEFAULT 0,
  `dtopor1` double NOT NULL DEFAULT 0,
  `dtopor2` double NOT NULL DEFAULT 0,
  `dtopor3` double NOT NULL DEFAULT 0,
  `dtopor4` double NOT NULL DEFAULT 0,
  `dtopor5` double NOT NULL DEFAULT 0,
  `codruta` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codvendedor` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idfactura`) USING BTREE,
  UNIQUE INDEX `uniq_codigo_facturascli`(`codigo`) USING BTREE,
  INDEX `ca_facturascli_series2`(`codserie`) USING BTREE,
  INDEX `ca_facturascli_ejercicios2`(`codejercicio`) USING BTREE,
  INDEX `ca_facturascli_asiento2`(`idasiento`) USING BTREE,
  INDEX `ca_facturascli_asientop`(`idasientop`) USING BTREE,
  CONSTRAINT `ca_facturascli_asiento2` FOREIGN KEY (`idasiento`) REFERENCES `co_asientos` (`idasiento`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `ca_facturascli_asientop` FOREIGN KEY (`idasientop`) REFERENCES `co_asientos` (`idasiento`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `ca_facturascli_ejercicios2` FOREIGN KEY (`codejercicio`) REFERENCES `ejercicios` (`codejercicio`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `ca_facturascli_series2` FOREIGN KEY (`codserie`) REFERENCES `series` (`codserie`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for facturasprov
-- ----------------------------
DROP TABLE IF EXISTS `facturasprov`;
CREATE TABLE `facturasprov`  (
  `automatica` tinyint(1) NULL DEFAULT NULL,
  `cifnif` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `coddivisa` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codigorect` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpago` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codproveedor` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codserie` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `deabono` tinyint(1) NULL DEFAULT 0,
  `editable` tinyint(1) NULL DEFAULT 0,
  `fecha` date NOT NULL,
  `hora` time(0) NOT NULL DEFAULT '00:00:00',
  `idasiento` int(11) NULL DEFAULT NULL,
  `idasientop` int(11) NULL DEFAULT NULL,
  `idfactura` int(11) NOT NULL AUTO_INCREMENT,
  `idfacturarect` int(11) NULL DEFAULT NULL,
  `idpagodevol` int(11) NULL DEFAULT NULL,
  `irpf` double NULL DEFAULT NULL,
  `neto` double NULL DEFAULT NULL,
  `nogenerarasiento` tinyint(1) NULL DEFAULT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `numero` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `numproveedor` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `pagada` tinyint(1) NOT NULL DEFAULT 0,
  `anulada` tinyint(1) NOT NULL DEFAULT 0,
  `recfinanciero` double NULL DEFAULT NULL,
  `tasaconv` double NOT NULL,
  `total` double NULL DEFAULT NULL,
  `totaleuros` double NULL DEFAULT NULL,
  `totalirpf` double NULL DEFAULT NULL,
  `totaliva` double NULL DEFAULT NULL,
  `totalrecargo` double NULL DEFAULT NULL,
  `numdocs` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`idfactura`) USING BTREE,
  UNIQUE INDEX `uniq_codigo_facturasprov`(`codigo`) USING BTREE,
  INDEX `ca_facturasprov_series2`(`codserie`) USING BTREE,
  INDEX `ca_facturasprov_ejercicios2`(`codejercicio`) USING BTREE,
  INDEX `ca_facturasprov_asiento2`(`idasiento`) USING BTREE,
  INDEX `ca_facturasprov_asientop`(`idasientop`) USING BTREE,
  CONSTRAINT `ca_facturasprov_asiento2` FOREIGN KEY (`idasiento`) REFERENCES `co_asientos` (`idasiento`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `ca_facturasprov_asientop` FOREIGN KEY (`idasientop`) REFERENCES `co_asientos` (`idasiento`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `ca_facturasprov_ejercicios2` FOREIGN KEY (`codejercicio`) REFERENCES `ejercicios` (`codejercicio`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `ca_facturasprov_series2` FOREIGN KEY (`codserie`) REFERENCES `series` (`codserie`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for familias
-- ----------------------------
DROP TABLE IF EXISTS `familias`;
CREATE TABLE `familias`  (
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codfamilia` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `madre` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`codfamilia`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for formaspago
-- ----------------------------
DROP TABLE IF EXISTS `formaspago`;
CREATE TABLE `formaspago`  (
  `codpago` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `genrecibos` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codcuenta` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `domiciliado` tinyint(1) NULL DEFAULT NULL,
  `imprimir` tinyint(1) NULL DEFAULT 1,
  `vencimiento` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT '+1month',
  PRIMARY KEY (`codpago`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fs_extensions2
-- ----------------------------
DROP TABLE IF EXISTS `fs_extensions2`;
CREATE TABLE `fs_extensions2`  (
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `page_from` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `page_to` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `type` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `params` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`name`, `page_from`) USING BTREE,
  INDEX `ca_fs_extensions2_fs_pages`(`page_from`) USING BTREE,
  CONSTRAINT `ca_fs_extensions2_fs_pages` FOREIGN KEY (`page_from`) REFERENCES `fs_pages` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fs_logs
-- ----------------------------
DROP TABLE IF EXISTS `fs_logs`;
CREATE TABLE `fs_logs`  (
  `alerta` tinyint(1) NULL DEFAULT NULL,
  `controlador` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `detalle` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `fecha` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `tipo` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 109 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fs_pages
-- ----------------------------
DROP TABLE IF EXISTS `fs_pages`;
CREATE TABLE `fs_pages`  (
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `folder` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `version` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `show_on_menu` tinyint(1) NOT NULL DEFAULT 1,
  `important` tinyint(1) NOT NULL DEFAULT 0,
  `orden` int(11) NOT NULL DEFAULT 100,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fs_roles
-- ----------------------------
DROP TABLE IF EXISTS `fs_roles`;
CREATE TABLE `fs_roles`  (
  `codrol` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`codrol`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fs_users
-- ----------------------------
DROP TABLE IF EXISTS `fs_users`;
CREATE TABLE `fs_users`  (
  `nick` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `log_key` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `last_login` date NULL DEFAULT NULL,
  `last_login_time` time(0) NULL DEFAULT NULL,
  `last_ip` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `last_browser` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fs_page` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `css` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`nick`) USING BTREE,
  INDEX `ca_fs_users_pages`(`fs_page`) USING BTREE,
  CONSTRAINT `ca_fs_users_pages` FOREIGN KEY (`fs_page`) REFERENCES `fs_pages` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for fs_vars
-- ----------------------------
DROP TABLE IF EXISTS `fs_vars`;
CREATE TABLE `fs_vars`  (
  `name` varchar(35) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `varchar` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  PRIMARY KEY (`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for gruposclientes
-- ----------------------------
DROP TABLE IF EXISTS `gruposclientes`;
CREATE TABLE `gruposclientes`  (
  `codgrupo` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codtarifa` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`codgrupo`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_ausencias
-- ----------------------------
DROP TABLE IF EXISTS `hr_ausencias`;
CREATE TABLE `hr_ausencias`  (
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `documento` varchar(120) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `f_desde` timestamp(0) NOT NULL DEFAULT '2018-12-30 00:00:00',
  `f_hasta` timestamp(0) NOT NULL DEFAULT '2018-12-30 00:00:00',
  `fecha_creacion` timestamp(0) NOT NULL DEFAULT '2018-12-30 00:00:00',
  `fecha_modificacion` timestamp(0) NULL DEFAULT '2018-12-30 00:00:00',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `justificada` tinyint(1) NOT NULL DEFAULT 0,
  `tipo_ausencia` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `codagente`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_cargos
-- ----------------------------
DROP TABLE IF EXISTS `hr_cargos`;
CREATE TABLE `hr_cargos`  (
  `codcargo` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codcategoria` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  `padre` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`codcargo`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_categoriaempleado
-- ----------------------------
DROP TABLE IF EXISTS `hr_categoriaempleado`;
CREATE TABLE `hr_categoriaempleado`  (
  `codcategoria` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`codcategoria`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_contratos
-- ----------------------------
DROP TABLE IF EXISTS `hr_contratos`;
CREATE TABLE `hr_contratos`  (
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `contrato` varchar(120) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  `fecha_creacion` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_fin` date NULL DEFAULT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_contrato` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `codagente`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_dependientes
-- ----------------------------
DROP TABLE IF EXISTS `hr_dependientes`;
CREATE TABLE `hr_dependientes`  (
  `apellido_materno` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `apellido_paterno` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `coddependiente` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `docidentidad` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `f_nacimiento` date NOT NULL,
  `fecha_creacion` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `genero` varchar(1) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `grado_academico` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_estadocivil
-- ----------------------------
DROP TABLE IF EXISTS `hr_estadocivil`;
CREATE TABLE `hr_estadocivil`  (
  `codestadocivil` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(90) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`codestadocivil`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_formacion
-- ----------------------------
DROP TABLE IF EXISTS `hr_formacion`;
CREATE TABLE `hr_formacion`  (
  `codformacion` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `nombre` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`codformacion`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_generaciones
-- ----------------------------
DROP TABLE IF EXISTS `hr_generaciones`;
CREATE TABLE `hr_generaciones`  (
  `codgeneracion` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(90) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fin_generacion` int(11) NOT NULL,
  `inicio_generacion` int(11) NOT NULL,
  PRIMARY KEY (`codgeneracion`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_hoja_vida
-- ----------------------------
DROP TABLE IF EXISTS `hr_hoja_vida`;
CREATE TABLE `hr_hoja_vida`  (
  `autor_documento` varchar(120) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `documento` varchar(120) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_documento` date NOT NULL,
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_documento` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_motivocese
-- ----------------------------
DROP TABLE IF EXISTS `hr_motivocese`;
CREATE TABLE `hr_motivocese`  (
  `codmotivocese` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codtipocese` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`codmotivocese`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_movimientos_empleados
-- ----------------------------
DROP TABLE IF EXISTS `hr_movimientos_empleados`;
CREATE TABLE `hr_movimientos_empleados`  (
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codautoriza` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codmovimiento` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `documento` varchar(120) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `f_desde` date NOT NULL,
  `f_hasta` date NULL DEFAULT NULL,
  `fecha_creacion` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `fecha_modificacion` timestamp(0) NULL DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `observaciones` varchar(180) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `usuario_creacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `usuario_modificacion` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`, `codagente`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_organizacion
-- ----------------------------
DROP TABLE IF EXISTS `hr_organizacion`;
CREATE TABLE `hr_organizacion`  (
  `codorganizacion` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  `padre` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `tipo` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`codorganizacion`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_seguridadsocial
-- ----------------------------
DROP TABLE IF EXISTS `hr_seguridadsocial`;
CREATE TABLE `hr_seguridadsocial`  (
  `codseguridadsocial` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  `nombre` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `nombre_corto` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `tipo` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`codseguridadsocial`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_sindicalizacion
-- ----------------------------
DROP TABLE IF EXISTS `hr_sindicalizacion`;
CREATE TABLE `hr_sindicalizacion`  (
  `idsindicato` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`idsindicato`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_sistemapension
-- ----------------------------
DROP TABLE IF EXISTS `hr_sistemapension`;
CREATE TABLE `hr_sistemapension`  (
  `codsistemapension` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  `nombre` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `nombre_corto` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '0',
  `tipo` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`codsistemapension`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_tipoausencias
-- ----------------------------
DROP TABLE IF EXISTS `hr_tipoausencias`;
CREATE TABLE `hr_tipoausencias`  (
  `aplicar_descuento` tinyint(1) NOT NULL DEFAULT 0,
  `codausencia` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`codausencia`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_tipocese
-- ----------------------------
DROP TABLE IF EXISTS `hr_tipocese`;
CREATE TABLE `hr_tipocese`  (
  `codtipocese` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`codtipocese`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_tipocuenta
-- ----------------------------
DROP TABLE IF EXISTS `hr_tipocuenta`;
CREATE TABLE `hr_tipocuenta`  (
  `codtipo` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codigo_banco` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`codtipo`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_tipodependientes
-- ----------------------------
DROP TABLE IF EXISTS `hr_tipodependientes`;
CREATE TABLE `hr_tipodependientes`  (
  `coddependiente` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(90) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`coddependiente`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_tipoempleado
-- ----------------------------
DROP TABLE IF EXISTS `hr_tipoempleado`;
CREATE TABLE `hr_tipoempleado`  (
  `codtipo` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`codtipo`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_tipomovimiento
-- ----------------------------
DROP TABLE IF EXISTS `hr_tipomovimiento`;
CREATE TABLE `hr_tipomovimiento`  (
  `codmovimiento` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`codmovimiento`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for hr_tipopago
-- ----------------------------
DROP TABLE IF EXISTS `hr_tipopago`;
CREATE TABLE `hr_tipopago`  (
  `codpago` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `es_basico` tinyint(1) NOT NULL DEFAULT 0,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`codpago`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for impuestos
-- ----------------------------
DROP TABLE IF EXISTS `impuestos`;
CREATE TABLE `impuestos`  (
  `codimpuesto` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codsubcuentaacr` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuentadeu` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuentaivadedadue` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuentaivadevadue` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuentaivadeventue` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuentaivarepexe` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuentaivarepexp` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuentaivarepre` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuentaivasopagra` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuentaivasopexe` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuentaivasopimp` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuentarep` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuentasop` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `descripcion` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idsubcuentaacr` int(11) NULL DEFAULT NULL,
  `idsubcuentadeu` int(11) NULL DEFAULT NULL,
  `idsubcuentaivadedadue` int(11) NULL DEFAULT NULL,
  `idsubcuentaivadevadue` int(11) NULL DEFAULT NULL,
  `idsubcuentaivadeventue` int(11) NULL DEFAULT NULL,
  `idsubcuentaivarepexe` int(11) NULL DEFAULT NULL,
  `idsubcuentaivarepexp` int(11) NULL DEFAULT NULL,
  `idsubcuentaivarepre` int(11) NULL DEFAULT NULL,
  `idsubcuentaivasopagra` int(11) NULL DEFAULT NULL,
  `idsubcuentaivasopexe` int(11) NULL DEFAULT NULL,
  `idsubcuentaivasopimp` int(11) NULL DEFAULT NULL,
  `idsubcuentarep` int(11) NULL DEFAULT NULL,
  `idsubcuentasop` int(11) NULL DEFAULT NULL,
  `iva` double NOT NULL,
  `recargo` double NOT NULL,
  PRIMARY KEY (`codimpuesto`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lineasalbaranescli
-- ----------------------------
DROP TABLE IF EXISTS `lineasalbaranescli`;
CREATE TABLE `lineasalbaranescli`  (
  `cantidad` double NOT NULL DEFAULT 0,
  `codimpuesto` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `dtolineal` double NULL DEFAULT 0,
  `dtopor` double NOT NULL DEFAULT 0,
  `dtopor2` double NOT NULL DEFAULT 0,
  `dtopor3` double NOT NULL DEFAULT 0,
  `dtopor4` double NOT NULL DEFAULT 0,
  `idalbaran` int(11) NOT NULL,
  `idlinea` int(11) NOT NULL AUTO_INCREMENT,
  `idlineapedido` int(11) NULL DEFAULT NULL,
  `idpedido` int(11) NULL DEFAULT NULL,
  `irpf` double NULL DEFAULT NULL,
  `iva` double NOT NULL DEFAULT 0,
  `porcomision` double NULL DEFAULT NULL,
  `pvpsindto` double NOT NULL DEFAULT 0,
  `pvptotal` double NOT NULL DEFAULT 0,
  `pvpunitario` double NOT NULL DEFAULT 0,
  `recargo` double NULL DEFAULT 0,
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcombinacion` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `orden` int(11) NULL DEFAULT 0,
  `mostrar_cantidad` tinyint(1) NULL DEFAULT 1,
  `mostrar_precio` tinyint(1) NULL DEFAULT 1,
  `cantidad_um` double NULL DEFAULT NULL,
  `codum` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idlinea`) USING BTREE,
  INDEX `ca_lineasalbaranescli_albaranescli2`(`idalbaran`) USING BTREE,
  CONSTRAINT `ca_lineasalbaranescli_albaranescli2` FOREIGN KEY (`idalbaran`) REFERENCES `albaranescli` (`idalbaran`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lineasalbaranesprov
-- ----------------------------
DROP TABLE IF EXISTS `lineasalbaranesprov`;
CREATE TABLE `lineasalbaranesprov`  (
  `cantidad` double NOT NULL DEFAULT 0,
  `codimpuesto` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `dtolineal` double NULL DEFAULT 0,
  `dtopor` double NOT NULL DEFAULT 0,
  `idalbaran` int(11) NOT NULL,
  `idlinea` int(11) NOT NULL AUTO_INCREMENT,
  `idlineapedido` int(11) NULL DEFAULT NULL,
  `idpedido` int(11) NULL DEFAULT NULL,
  `irpf` double NULL DEFAULT NULL,
  `iva` double NOT NULL DEFAULT 0,
  `pvpsindto` double NOT NULL DEFAULT 0,
  `pvptotal` double NOT NULL DEFAULT 0,
  `pvpunitario` double NOT NULL DEFAULT 0,
  `recargo` double NULL DEFAULT 0,
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcombinacion` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `cantidad_um` double NULL DEFAULT NULL,
  `codum` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idlinea`) USING BTREE,
  INDEX `ca_lineasalbaranesprov_albaranesprov2`(`idalbaran`) USING BTREE,
  CONSTRAINT `ca_lineasalbaranesprov_albaranesprov2` FOREIGN KEY (`idalbaran`) REFERENCES `albaranesprov` (`idalbaran`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lineasfacturascli
-- ----------------------------
DROP TABLE IF EXISTS `lineasfacturascli`;
CREATE TABLE `lineasfacturascli`  (
  `cantidad` double NOT NULL DEFAULT 0,
  `codimpuesto` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `dtolineal` double NULL DEFAULT 0,
  `dtopor` double NOT NULL DEFAULT 0,
  `dtopor2` double NOT NULL DEFAULT 0,
  `dtopor3` double NOT NULL DEFAULT 0,
  `dtopor4` double NOT NULL DEFAULT 0,
  `idalbaran` int(11) NULL DEFAULT NULL,
  `idfactura` int(11) NOT NULL,
  `idlinea` int(11) NOT NULL AUTO_INCREMENT,
  `idlineaalbaran` int(11) NULL DEFAULT NULL,
  `irpf` double NULL DEFAULT NULL,
  `iva` double NOT NULL,
  `porcomision` double NULL DEFAULT NULL,
  `pvpsindto` double NOT NULL,
  `pvptotal` double NOT NULL,
  `pvpunitario` double NOT NULL,
  `recargo` double NULL DEFAULT NULL,
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcombinacion` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `orden` int(11) NULL DEFAULT 0,
  `mostrar_cantidad` tinyint(1) NULL DEFAULT 1,
  `mostrar_precio` tinyint(1) NULL DEFAULT 1,
  `cantidad_um` double NULL DEFAULT NULL,
  `codum` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idlinea`) USING BTREE,
  INDEX `ca_linea_facturascli2`(`idfactura`) USING BTREE,
  CONSTRAINT `ca_linea_facturascli2` FOREIGN KEY (`idfactura`) REFERENCES `facturascli` (`idfactura`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lineasfacturasprov
-- ----------------------------
DROP TABLE IF EXISTS `lineasfacturasprov`;
CREATE TABLE `lineasfacturasprov`  (
  `cantidad` double NOT NULL,
  `codimpuesto` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuenta` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `dtolineal` double NULL DEFAULT 0,
  `dtopor` double NOT NULL,
  `idalbaran` int(11) NULL DEFAULT NULL,
  `idfactura` int(11) NOT NULL,
  `idlinea` int(11) NOT NULL AUTO_INCREMENT,
  `idlineaalbaran` int(11) NULL DEFAULT NULL,
  `idsubcuenta` int(11) NULL DEFAULT NULL,
  `irpf` double NULL DEFAULT NULL,
  `iva` double NOT NULL,
  `pvpsindto` double NOT NULL,
  `pvptotal` double NULL DEFAULT NULL,
  `pvpunitario` double NOT NULL,
  `recargo` double NULL DEFAULT NULL,
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcombinacion` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `cantidad_um` double NULL DEFAULT NULL,
  `codum` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idlinea`) USING BTREE,
  INDEX `ca_linea_facturasprov2`(`idfactura`) USING BTREE,
  CONSTRAINT `ca_linea_facturasprov2` FOREIGN KEY (`idfactura`) REFERENCES `facturasprov` (`idfactura`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lineasivafactcli
-- ----------------------------
DROP TABLE IF EXISTS `lineasivafactcli`;
CREATE TABLE `lineasivafactcli`  (
  `codimpuesto` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idfactura` int(11) NOT NULL,
  `idlinea` int(11) NOT NULL AUTO_INCREMENT,
  `iva` double NOT NULL DEFAULT 0,
  `neto` double NOT NULL DEFAULT 0,
  `recargo` double NOT NULL DEFAULT 0,
  `totaliva` double NOT NULL DEFAULT 0,
  `totallinea` double NOT NULL DEFAULT 0,
  `totalrecargo` double NOT NULL DEFAULT 0,
  PRIMARY KEY (`idlinea`) USING BTREE,
  INDEX `ca_lineaiva_facturascli2`(`idfactura`) USING BTREE,
  CONSTRAINT `ca_lineaiva_facturascli2` FOREIGN KEY (`idfactura`) REFERENCES `facturascli` (`idfactura`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lineasregstocks
-- ----------------------------
DROP TABLE IF EXISTS `lineasregstocks`;
CREATE TABLE `lineasregstocks`  (
  `cantidadfin` double NOT NULL DEFAULT 0,
  `cantidadini` double NOT NULL DEFAULT 0,
  `codalmacendest` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time(0) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idstock` int(11) NOT NULL,
  `motivo` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `nick` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ca_lineasregstocks_stocks`(`idstock`) USING BTREE,
  CONSTRAINT `ca_lineasregstocks_stocks` FOREIGN KEY (`idstock`) REFERENCES `stocks` (`idstock`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for lineastransstock
-- ----------------------------
DROP TABLE IF EXISTS `lineastransstock`;
CREATE TABLE `lineastransstock`  (
  `cantidad` double NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `idlinea` int(11) NOT NULL AUTO_INCREMENT,
  `idtrans` int(11) NOT NULL,
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idlinea`) USING BTREE,
  UNIQUE INDEX `uniq_referencia_transferencia`(`idtrans`, `referencia`) USING BTREE,
  INDEX `ca_linea_transstock_articulos`(`referencia`) USING BTREE,
  CONSTRAINT `ca_linea_transstock` FOREIGN KEY (`idtrans`) REFERENCES `transstock` (`idtrans`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ca_linea_transstock_articulos` FOREIGN KEY (`referencia`) REFERENCES `articulos` (`referencia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for paises
-- ----------------------------
DROP TABLE IF EXISTS `paises`;
CREATE TABLE `paises`  (
  `validarprov` tinyint(1) NULL DEFAULT NULL,
  `codiso` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `bandera` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpais` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`codpais`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pedidoscli
-- ----------------------------
DROP TABLE IF EXISTS `pedidoscli`;
CREATE TABLE `pedidoscli`  (
  `apartado` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `cifnif` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ciudad` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcliente` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `coddir` int(11) NULL DEFAULT NULL,
  `coddivisa` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codpago` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codpais` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpostal` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codserie` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `direccion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `editable` tinyint(1) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time(0) NULL DEFAULT '00:00:00',
  `fechasalida` date NULL DEFAULT NULL,
  `femail` date NULL DEFAULT NULL,
  `idpedido` int(11) NOT NULL AUTO_INCREMENT,
  `idalbaran` int(11) NULL DEFAULT NULL,
  `idprovincia` int(11) NULL DEFAULT NULL,
  `irpf` double NOT NULL DEFAULT 0,
  `netosindto` double NOT NULL DEFAULT 0,
  `neto` double NOT NULL DEFAULT 0,
  `nombrecliente` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `numero` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `numero2` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `porcomision` double NULL DEFAULT NULL,
  `provincia` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `recfinanciero` double NULL DEFAULT NULL,
  `servido` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `tasaconv` double NOT NULL DEFAULT 1,
  `total` double NOT NULL DEFAULT 0,
  `totaleuros` double NOT NULL DEFAULT 0,
  `totalirpf` double NOT NULL DEFAULT 0,
  `totaliva` double NOT NULL DEFAULT 0,
  `totalrecargo` double NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `codtrans` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codigoenv` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `nombreenv` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `apellidosenv` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `direccionenv` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpostalenv` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `ciudadenv` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `provinciaenv` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `apartadoenv` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpaisenv` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `numdocs` int(11) NULL DEFAULT 0,
  `idoriginal` int(11) NULL DEFAULT NULL,
  `dtopor1` double NOT NULL DEFAULT 0,
  `dtopor2` double NOT NULL DEFAULT 0,
  `dtopor3` double NOT NULL DEFAULT 0,
  `dtopor4` double NOT NULL DEFAULT 0,
  `dtopor5` double NOT NULL DEFAULT 0,
  `codruta` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codvendedor` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idpedido`) USING BTREE,
  UNIQUE INDEX `uniq_codigo_pedidoscli`(`codigo`) USING BTREE,
  INDEX `ca_pedidoscli_series`(`codserie`) USING BTREE,
  INDEX `ca_pedidoscli_ejercicios`(`codejercicio`) USING BTREE,
  CONSTRAINT `ca_pedidoscli_ejercicios` FOREIGN KEY (`codejercicio`) REFERENCES `ejercicios` (`codejercicio`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `ca_pedidoscli_series` FOREIGN KEY (`codserie`) REFERENCES `series` (`codserie`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pedidosprov
-- ----------------------------
DROP TABLE IF EXISTS `pedidosprov`;
CREATE TABLE `pedidosprov`  (
  `codigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `totaleuros` double NOT NULL,
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpago` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `tasaconv` double NOT NULL,
  `total` double NOT NULL,
  `irpf` double NULL DEFAULT NULL,
  `idpedido` int(11) NOT NULL AUTO_INCREMENT,
  `idalbaran` int(11) NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `servido` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `editable` tinyint(1) NOT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `numproveedor` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `cifnif` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codproveedor` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fechaentrada` date NULL DEFAULT NULL,
  `totalrecargo` double NULL DEFAULT NULL,
  `recfinanciero` double NULL DEFAULT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time(0) NULL DEFAULT '00:00:00',
  `neto` double NOT NULL,
  `totalirpf` double NULL DEFAULT NULL,
  `codserie` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `totaliva` double NOT NULL,
  `numero` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `coddivisa` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `numdocs` int(11) NULL DEFAULT 0,
  `idoriginal` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`idpedido`) USING BTREE,
  UNIQUE INDEX `uniq_codigo_pedidosprov`(`codigo`) USING BTREE,
  INDEX `ca_pedidosprov_series`(`codserie`) USING BTREE,
  INDEX `ca_pedidosprov_ejercicios`(`codejercicio`) USING BTREE,
  CONSTRAINT `ca_pedidosprov_ejercicios` FOREIGN KEY (`codejercicio`) REFERENCES `ejercicios` (`codejercicio`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `ca_pedidosprov_series` FOREIGN KEY (`codserie`) REFERENCES `series` (`codserie`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for presupuestoscli
-- ----------------------------
DROP TABLE IF EXISTS `presupuestoscli`;
CREATE TABLE `presupuestoscli`  (
  `apartado` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `cifnif` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `ciudad` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcliente` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `coddir` int(11) NULL DEFAULT NULL,
  `coddivisa` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codoportunidad` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpago` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codpais` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpostal` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codserie` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `direccion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `editable` tinyint(1) NOT NULL,
  `estado` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time(0) NOT NULL DEFAULT '00:00:00',
  `finoferta` date NULL DEFAULT NULL,
  `fechasalida` date NULL DEFAULT NULL,
  `femail` date NULL DEFAULT NULL,
  `idpresupuesto` int(11) NOT NULL AUTO_INCREMENT,
  `idpedido` int(11) NULL DEFAULT NULL,
  `idprovincia` int(11) NULL DEFAULT NULL,
  `irpf` double NOT NULL DEFAULT 0,
  `netosindto` double NOT NULL DEFAULT 0,
  `neto` double NOT NULL DEFAULT 0,
  `nombrecliente` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `numero` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `numero2` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `porcomision` double NULL DEFAULT NULL,
  `provincia` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `recfinanciero` double NULL DEFAULT NULL,
  `tasaconv` double NOT NULL DEFAULT 1,
  `total` double NOT NULL DEFAULT 0,
  `totaleuros` double NOT NULL DEFAULT 0,
  `totalirpf` double NOT NULL DEFAULT 0,
  `totaliva` double NOT NULL DEFAULT 0,
  `totalrecargo` double NULL DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `codtrans` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codigoenv` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `nombreenv` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `apellidosenv` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `direccionenv` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpostalenv` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `ciudadenv` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `provinciaenv` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `apartadoenv` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpaisenv` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `numdocs` int(11) NULL DEFAULT 0,
  `idoriginal` int(11) NULL DEFAULT NULL,
  `dtopor1` double NOT NULL DEFAULT 0,
  `dtopor2` double NOT NULL DEFAULT 0,
  `dtopor3` double NOT NULL DEFAULT 0,
  `dtopor4` double NOT NULL DEFAULT 0,
  `dtopor5` double NOT NULL DEFAULT 0,
  PRIMARY KEY (`idpresupuesto`) USING BTREE,
  UNIQUE INDEX `uniq_codigo_presupuestoscli`(`codigo`) USING BTREE,
  INDEX `ca_presupuestoscli_series`(`codserie`) USING BTREE,
  INDEX `ca_presupuestoscli_ejercicios`(`codejercicio`) USING BTREE,
  CONSTRAINT `ca_presupuestoscli_ejercicios` FOREIGN KEY (`codejercicio`) REFERENCES `ejercicios` (`codejercicio`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `ca_presupuestoscli_series` FOREIGN KEY (`codserie`) REFERENCES `series` (`codserie`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for proveedores
-- ----------------------------
DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE `proveedores`  (
  `cifnif` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codcontacto` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcuentadom` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcuentapago` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `coddivisa` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpago` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codproveedor` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codserie` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codsubcuenta` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `contacto` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fax` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idsubcuenta` int(11) NULL DEFAULT NULL,
  `ivaportes` double NULL DEFAULT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `razonsocial` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `recfinanciero` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `regimeniva` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `telefono1` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `telefono2` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `tipoidfiscal` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'NIF',
  `web` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `acreedor` tinyint(1) NULL DEFAULT 0,
  `personafisica` tinyint(1) NULL DEFAULT 1,
  `debaja` tinyint(1) NULL DEFAULT 0,
  `fechabaja` date NULL DEFAULT NULL,
  `codcliente` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`codproveedor`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for secuencias
-- ----------------------------
DROP TABLE IF EXISTS `secuencias`;
CREATE TABLE `secuencias`  (
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `id` int(11) NOT NULL,
  `idsec` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `valor` int(11) NULL DEFAULT NULL,
  `valorout` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`idsec`) USING BTREE,
  INDEX `ca_secuencias_secuenciasejercicios`(`id`) USING BTREE,
  CONSTRAINT `ca_secuencias_secuenciasejercicios` FOREIGN KEY (`id`) REFERENCES `secuenciasejercicios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for secuenciasejercicios
-- ----------------------------
DROP TABLE IF EXISTS `secuenciasejercicios`;
CREATE TABLE `secuenciasejercicios`  (
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codserie` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nalbarancli` int(11) NOT NULL,
  `nalbaranprov` int(11) NOT NULL,
  `nfacturacli` int(11) NOT NULL,
  `nfacturaprov` int(11) NOT NULL,
  `npedidocli` int(11) NOT NULL,
  `npedidoprov` int(11) NOT NULL,
  `npresupuestocli` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ca_secuenciasejercicios_ejercicios`(`codejercicio`) USING BTREE,
  CONSTRAINT `ca_secuenciasejercicios_ejercicios` FOREIGN KEY (`codejercicio`) REFERENCES `ejercicios` (`codejercicio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for series
-- ----------------------------
DROP TABLE IF EXISTS `series`;
CREATE TABLE `series`  (
  `irpf` double NULL DEFAULT NULL,
  `idcuenta` int(11) NULL DEFAULT NULL,
  `codserie` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `siniva` tinyint(1) NULL DEFAULT NULL,
  `codcuenta` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `numfactura` int(11) NULL DEFAULT 1,
  PRIMARY KEY (`codserie`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for servicioscli
-- ----------------------------
DROP TABLE IF EXISTS `servicioscli`;
CREATE TABLE `servicioscli`  (
  `apartado` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `prioridad` int(11) NULL DEFAULT NULL,
  `cifnif` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `ciudad` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcliente` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `coddir` int(11) NULL DEFAULT NULL,
  `coddivisa` varchar(3) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codejercicio` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codigo` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpago` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpais` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpostal` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codserie` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `direccion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `editable` tinyint(1) NOT NULL,
  `garantia` tinyint(1) NULL DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time(0) NULL DEFAULT '00:00:00',
  `femail` date NULL DEFAULT NULL,
  `fechafin` date NULL DEFAULT NULL,
  `horafin` time(0) NULL DEFAULT NULL,
  `fechainicio` date NULL DEFAULT NULL,
  `horainicio` time(0) NULL DEFAULT NULL,
  `idservicio` int(11) NOT NULL AUTO_INCREMENT,
  `idalbaran` int(11) NULL DEFAULT NULL,
  `idprovincia` int(11) NULL DEFAULT NULL,
  `irpf` double NULL DEFAULT NULL,
  `neto` double NOT NULL,
  `nombrecliente` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `numero` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `numero2` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `solucion` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `material` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `material_estado` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `accesorios` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `porcomision` double NULL DEFAULT NULL,
  `provincia` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `recfinanciero` double NULL DEFAULT NULL,
  `tasaconv` double NOT NULL,
  `total` double NOT NULL,
  `totaleuros` double NULL DEFAULT NULL,
  `totalirpf` double NOT NULL,
  `totaliva` double NOT NULL,
  `totalrecargo` double NULL DEFAULT NULL,
  `idestado` int(11) NULL DEFAULT NULL,
  `numdocs` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`idservicio`) USING BTREE,
  UNIQUE INDEX `uniq_codigo_servicioscli`(`codigo`) USING BTREE,
  INDEX `ca_servicioscli_series`(`codserie`) USING BTREE,
  INDEX `ca_servicioscli_ejercicios`(`codejercicio`) USING BTREE,
  INDEX `ca_servicios_albaranescli`(`idalbaran`) USING BTREE,
  CONSTRAINT `ca_servicios_albaranescli` FOREIGN KEY (`idalbaran`) REFERENCES `albaranescli` (`idalbaran`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `ca_servicioscli_ejercicios` FOREIGN KEY (`codejercicio`) REFERENCES `ejercicios` (`codejercicio`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `ca_servicioscli_series` FOREIGN KEY (`codserie`) REFERENCES `series` (`codserie`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for stocks
-- ----------------------------
DROP TABLE IF EXISTS `stocks`;
CREATE TABLE `stocks`  (
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `disponible` double NOT NULL,
  `stockmin` double NOT NULL DEFAULT 0,
  `reservada` double NOT NULL,
  `horaultreg` time(0) NULL DEFAULT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `pterecibir` double NOT NULL,
  `fechaultreg` date NULL DEFAULT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `cantidadultreg` double NOT NULL DEFAULT 0,
  `idstock` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` double NOT NULL DEFAULT 0,
  `stockmax` double NOT NULL DEFAULT 0,
  `ubicacion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idstock`) USING BTREE,
  UNIQUE INDEX `uniq_stocks_almacen_referencia`(`codalmacen`, `referencia`) USING BTREE,
  INDEX `ca_stocks_articulos2`(`referencia`) USING BTREE,
  CONSTRAINT `ca_stocks_almacenes3` FOREIGN KEY (`codalmacen`) REFERENCES `almacenes` (`codalmacen`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ca_stocks_articulos2` FOREIGN KEY (`referencia`) REFERENCES `articulos` (`referencia`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 65536 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tarifas
-- ----------------------------
DROP TABLE IF EXISTS `tarifas`;
CREATE TABLE `tarifas`  (
  `incporcentual` double NOT NULL,
  `inclineal` double NOT NULL,
  `aplicar_a` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mincoste` tinyint(1) NULL DEFAULT 0,
  `maxpvp` tinyint(1) NULL DEFAULT 0,
  `codtarifa` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`codtarifa`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tpv_arqueos
-- ----------------------------
DROP TABLE IF EXISTS `tpv_arqueos`;
CREATE TABLE `tpv_arqueos`  (
  `abierta` tinyint(1) NOT NULL,
  `b10` int(11) NULL DEFAULT NULL,
  `b100` int(11) NULL DEFAULT NULL,
  `b20` int(11) NULL DEFAULT NULL,
  `b200` int(11) NULL DEFAULT NULL,
  `b5` int(11) NULL DEFAULT NULL,
  `b50` int(11) NULL DEFAULT NULL,
  `b500` int(11) NULL DEFAULT NULL,
  `b1000` int(11) NULL DEFAULT NULL,
  `b2000` int(11) NULL DEFAULT NULL,
  `b5000` int(11) NULL DEFAULT NULL,
  `b10000` int(11) NULL DEFAULT NULL,
  `b20000` int(11) NULL DEFAULT NULL,
  `b50000` int(11) NULL DEFAULT NULL,
  `b100000` int(11) NULL DEFAULT NULL,
  `diadesde` date NOT NULL,
  `diahasta` date NULL DEFAULT NULL,
  `idasiento` int(11) NULL DEFAULT NULL,
  `idtpv_arqueo` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `inicio` double NOT NULL,
  `m001` int(11) NULL DEFAULT NULL,
  `m002` int(11) NULL DEFAULT NULL,
  `m005` int(11) NULL DEFAULT NULL,
  `m010` int(11) NULL DEFAULT NULL,
  `m020` int(11) NULL DEFAULT NULL,
  `m050` int(11) NULL DEFAULT NULL,
  `m1` int(11) NULL DEFAULT NULL,
  `m2` int(11) NULL DEFAULT NULL,
  `m50` int(11) NULL DEFAULT NULL,
  `m100` int(11) NULL DEFAULT NULL,
  `m200` int(11) NULL DEFAULT NULL,
  `m500` int(11) NULL DEFAULT NULL,
  `m1000` int(11) NULL DEFAULT NULL,
  `nogenerarasiento` tinyint(1) NOT NULL,
  `ptoventa` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `sacadodecaja` double NULL DEFAULT NULL,
  `totalcaja` double NULL DEFAULT NULL,
  `totalmov` double NULL DEFAULT NULL,
  `totaltarjeta` double NULL DEFAULT NULL,
  `totalvale` double NULL DEFAULT NULL,
  `idterminal` int(11) NULL DEFAULT NULL,
  `codagente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idtpv_arqueo`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tpv_articulos_favoritos
-- ----------------------------
DROP TABLE IF EXISTS `tpv_articulos_favoritos`;
CREATE TABLE `tpv_articulos_favoritos`  (
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `posicion` tinyint(2) NULL DEFAULT NULL,
  PRIMARY KEY (`referencia`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tpv_comandas
-- ----------------------------
DROP TABLE IF EXISTS `tpv_comandas`;
CREATE TABLE `tpv_comandas`  (
  `cifnif` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `ciudad` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codalmacen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcliente` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `coddir` int(11) NULL DEFAULT NULL,
  `codpago` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `totalpago` double NULL DEFAULT 0,
  `codpago2` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `totalpago2` double NULL DEFAULT 0,
  `numero2` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `codpais` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codpostal` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `direccion` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time(0) NOT NULL,
  `idfactura` int(11) NULL DEFAULT NULL,
  `idtpv_arqueo` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `idtpv_comanda` int(11) NOT NULL AUTO_INCREMENT,
  `neto` double NULL DEFAULT NULL,
  `nombrecliente` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `provincia` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `total` double NOT NULL,
  `totaliva` double NULL DEFAULT NULL,
  `ultcambio` double NULL DEFAULT NULL,
  `ultentregado` double NULL DEFAULT NULL,
  PRIMARY KEY (`idtpv_comanda`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tpv_comandas_marcaje
-- ----------------------------
DROP TABLE IF EXISTS `tpv_comandas_marcaje`;
CREATE TABLE `tpv_comandas_marcaje`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_agente` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fecha_inicio` datetime(0) NULL DEFAULT NULL,
  `fecha_fin` datetime(0) NULL DEFAULT NULL,
  `finalizado` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `tpv_comandas_marcaje_cod_agente_index`(`cod_agente`) USING BTREE,
  INDEX `tpv_comandas_marcaje_finalizado_index`(`finalizado`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 134 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tpv_lineas_comanda_marcaje
-- ----------------------------
DROP TABLE IF EXISTS `tpv_lineas_comanda_marcaje`;
CREATE TABLE `tpv_lineas_comanda_marcaje`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idtpv_comanda` int(11) NOT NULL,
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `cantidad` double NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ca_linea_comanda`(`idtpv_comanda`) USING BTREE,
  INDEX `tpv_lineas_comanda_marcaje_referencia_index`(`referencia`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 265 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tpv_lineascomanda
-- ----------------------------
DROP TABLE IF EXISTS `tpv_lineascomanda`;
CREATE TABLE `tpv_lineascomanda`  (
  `cantidad` double NOT NULL,
  `codimpuesto` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_bin NULL,
  `dtopor` double NOT NULL,
  `idlinea` int(11) NOT NULL AUTO_INCREMENT,
  `idtpv_comanda` int(11) NOT NULL,
  `irpf` double NULL DEFAULT NULL,
  `iva` double NOT NULL,
  `porcomision` double NULL DEFAULT NULL,
  `pvpsindto` double NOT NULL,
  `pvptotal` double NOT NULL,
  `pvpunitario` double NOT NULL,
  `recargo` double NULL DEFAULT NULL,
  `referencia` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codcombinacion` varchar(18) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  PRIMARY KEY (`idlinea`) USING BTREE,
  INDEX `ca_linea_comanda`(`idtpv_comanda`) USING BTREE,
  CONSTRAINT `ca_linea_comanda` FOREIGN KEY (`idtpv_comanda`) REFERENCES `tpv_comandas` (`idtpv_comanda`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tpv_movimientos
-- ----------------------------
DROP TABLE IF EXISTS `tpv_movimientos`;
CREATE TABLE `tpv_movimientos`  (
  `cantidad` double NOT NULL,
  `codtpv_agente` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `fecha` date NOT NULL,
  `idtpv_arqueo` varchar(8) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `idtpv_movimiento` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idtpv_movimiento`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for transstock
-- ----------------------------
DROP TABLE IF EXISTS `transstock`;
CREATE TABLE `transstock`  (
  `usuario` varchar(12) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL,
  `codalmadestino` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `codalmaorigen` varchar(4) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `fecha` date NOT NULL,
  `hora` time(0) NOT NULL,
  `idtrans` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idtrans`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for unidadmedida
-- ----------------------------
DROP TABLE IF EXISTS `unidadmedida`;
CREATE TABLE `unidadmedida`  (
  `cantidad` decimal(10, 0) NOT NULL,
  `codum` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `nombre` varchar(60) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`codum`) USING BTREE,
  UNIQUE INDEX `unidadmedida_ukey`(`nombre`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Triggers structure for table articulos
-- ----------------------------
DROP TRIGGER IF EXISTS `normaliza_referencia_codbarras_numericos_insert`;
delimiter ;;
CREATE TRIGGER `normaliza_referencia_codbarras_numericos_insert` BEFORE INSERT ON `articulos` FOR EACH ROW SET
    NEW.codbarras_numerico = IF(NEW.codbarras IS NULL, NULL,
                                IF(NEW.codbarras = '', '',
                                   IF(TRIM(LEADING '0' FROM NEW.codbarras) = '', '0',
                                      TRIM(LEADING '0' FROM NEW.codbarras)))),
    NEW.referencia_numerica =
        IF(NEW.referencia IS NULL, NULL,
           IF(NEW.referencia = '', '',
              IF(TRIM(LEADING '0' FROM REPLACE(REPLACE(NEW.referencia, '1.', ''), '2.', '')) = '', '0',
                 TRIM(LEADING '0' FROM REPLACE(REPLACE(NEW.referencia, '1.', ''), '2.', '')))))
;;
delimiter ;

-- ----------------------------
-- Triggers structure for table articulos
-- ----------------------------
DROP TRIGGER IF EXISTS `normaliza_referencia_codbarras_numericos_update`;
delimiter ;;
CREATE TRIGGER `normaliza_referencia_codbarras_numericos_update` BEFORE UPDATE ON `articulos` FOR EACH ROW SET
    NEW.codbarras_numerico = IF(NEW.codbarras IS NULL, NULL,
                                IF(NEW.codbarras = '', '',
                                   IF(TRIM(LEADING '0' FROM NEW.codbarras) = '', '0',
                                      TRIM(LEADING '0' FROM NEW.codbarras)))),
    NEW.referencia_numerica =
        IF(NEW.referencia IS NULL, NULL,
           IF(NEW.referencia = '', '',
              IF(TRIM(LEADING '0' FROM REPLACE(REPLACE(NEW.referencia, '1.', ''), '2.', '')) = '', '0',
                 TRIM(LEADING '0' FROM REPLACE(REPLACE(NEW.referencia, '1.', ''), '2.', '')))))
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
