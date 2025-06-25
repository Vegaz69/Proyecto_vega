-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-06-2025 a las 21:52:12
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_hardware`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) GENERATED ALWAYS AS (`cantidad` * `precio_unitario`) STORED,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id_carrito`, `id_producto`, `id_usuario`, `nombre_producto`, `cantidad`, `precio_unitario`, `activo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(95, 47, 11, 'Gabinete ASUS ROG STRIX GX601 Helios Aluminum Black RGB USB-C', 3, 2000.00, 1, '2025-06-25 00:36:35', '2025-06-25 00:36:35', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `activo`) VALUES
(1, 'Monitores', 1),
(2, 'Notebooks', 1),
(3, 'Procesadores', 1),
(4, 'Placas Madre', 1),
(5, 'Memorias RAM', 1),
(6, 'Tarjetas Gráficas', 1),
(7, 'Fuentes de Poder', 1),
(8, 'Discos SSD', 0),
(9, 'Discos HDD', 0),
(10, 'Gabinetes', 1),
(11, 'Refrigeracion', 1),
(12, 'Teclados', 0),
(13, 'Mouses', 0),
(14, 'Auriculares', 0),
(15, 'Micrófonos', 0),
(16, 'Impresoras', 1),
(17, 'Sillas gamer', 1),
(18, 'DEMO19999', 0),
(20, 'Almacenamiento', 1),
(21, 'Periféricos', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id_detalle` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`id_detalle`, `id_venta`, `id_producto`, `nombre_producto`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(29, 26, 54, 'Memoria Patriot DDR5 16GB 6000MHz Viper Black CL30', 2, 2000.00, 4000.00),
(30, 27, 47, 'Gabinete ASUS ROG STRIX GX601 Helios Aluminum Black RGB USB-C', 1, 2000.00, 2000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_contacto`
--

CREATE TABLE `mensajes_contacto` (
  `id_mensaje` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `nombre_completo` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `asunto` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` datetime NOT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT 0,
  `tipo_mensaje` enum('cliente','contacto') NOT NULL DEFAULT 'contacto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `id_categoria` int(100) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `descripcion` mediumtext DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `marca`, `id_categoria`, `precio`, `descripcion`, `imagen`, `stock`, `activo`) VALUES
(26, 'Monitor Gamer LG 27 27GP750-B FHD 240Hz', 'LG', 1, 120.00, 'Monitor de alta resolución', '1749109429_47602369786eac05020e.jpg', 3, 0),
(27, 'Monitor Gamer LG 27 27GP750-B FHD 240Hz', 'LG', 1, 1000.00, 'CARACTERISTICAS GENERALES\r\nColor: Gris Claro\r\nTipo: Notebook\r\nSistema Operativo: Windows 11 Home\r\nBatería Extraible: No\r\nTipo De Cpu: AMD\r\nModelo Cpu: Ryzen 7 5825U\r\nTipo De Gpu: AMD Integrated Graphics\r\nModelo Gpu: Radeon RX Vega 8\r\nLector De Huellas: No\r\nFamilia Del Procesador: AMD RYZEN 7\r\n\r\nCONECTIVIDAD\r\nPuertos Hdmi: 1\r\nPuertos Mini Hdmi: 0\r\nPuerto Mini Dp: 0\r\nPuertos Usb 2.0 Tipo A: 1\r\nPuertos Usb 3.0 Tipo A: 0\r\nPuertos Usb 3.2 Tipo A: 2\r\nPuertos Usb 3.2 Tipo C: 1\r\nPuertos Ethernet: No\r\nBluetooth: Si\r\nWifi: Norma AC\r\nTipo De Thunderbolt: No incluye\r\n\r\nPANTALLA\r\nTamaño De La Pantalla: 15.60 \"\r\nTipo De Display: IPS\r\nResolución: 1920x1080\r\nTouch: No\r\nFrecuencia De Actualizacion: 60 hz\r\n\r\nMEMORIA\r\nFormato De Memorias: SODIMM\r\nGeneración De Memorias: DDR4\r\nRam Soldada: 8 gb\r\nSlot 1 Ram Disponible: No\r\nRam En El Slot 1: 8 gb\r\nSlot 2 Ram Disponible: No\r\nRam Máxima: 16', '1750783138_6c9246259de07fb9753e.jpg', 5, 1),
(28, 'Monitor Gamer LG Ultragear 27GS85Q-B 27 QHD NANO IPS 180Hz ', 'LG', 1, 1500.00, 'CARACTERISTICAS GENERALES\r\nTipo De Iluminación: LED\r\nTipo De Panel: NANO IPS\r\nPantalla Curva: No\r\n\r\nCONECTIVIDAD\r\nTotal De Puertos Hdmi: 2\r\nTotal De Puertos Display Port: 1\r\nMini Display Port: 0\r\nVga: 0\r\nDvi: 0\r\nPuertos Usb 2.0: 0\r\nPuertos Usb 3.0: 0\r\nPuertos Usb 3.1: 0\r\nConexión 3.5 Mm - Entrada: No\r\nConector Auriculares: Si\r\n\r\nDIMENSIONES\r\nAncho: 614 mm\r\nAlto: 372 mm\r\nEspesor: 51 mm\r\nCurvatura: 0 r\r\n\r\nPANTALLA\r\nPulgadas: 27 \"\r\nPulgadas Visibles: 27 \"\r\nResolución Máxima: 2560x1440\r\nHdr: 0\r\nMáxima Frecuencia: 180 hz\r\nCantidad De Colores: 16.7 m\r\nTiempo De Respuesta: 1 ms\r\nAngulo De Visión Horizontal: 178 º\r\nAngulo De Visión Vertical: 178 º\r\nPantalla Touch: No\r\nCaracteristicas Especiales: 0\r\nNvidia G-sync: Si\r\nAmd Freesync: No\r\nRadio De Contraste Estático: 1000 :1', '1750783478_0e22b2f1288cfb81a65c.jpg', 5, 1),
(29, 'Monitor Gamer Samsung Odyssey G4 25 FHD IPS 240Hz G', 'Samsung', 1, 2000.00, 'CARACTERISTICAS GENERALES\r\nTipo De Iluminación: LED\r\nTipo De Panel: IPS\r\nPantalla Curva: No\r\n\r\nCONECTIVIDAD\r\nTotal De Puertos Hdmi: 2\r\nTotal De Puertos Display Port: 1\r\nMini Display Port: 0\r\nVga: 0\r\nDvi: 0\r\nPuertos Usb 2.0: 0\r\nPuertos Usb 3.0: 0\r\nPuertos Usb 3.1: 0\r\nConexión 3.5 Mm - Entrada: No\r\nConector Auriculares: Si\r\n\r\nPANTALLA\r\nPulgadas: 25 \"\r\nPulgadas Visibles: 25 \"\r\nResolución Máxima: 1920x1080\r\nHdr: 0\r\nMáxima Frecuencia: 240 hz\r\nCantidad De Colores: 16.7 m\r\nTiempo De Respuesta: 1 ms\r\nAngulo De Visión Horizontal: 178 º\r\nAngulo De Visión Vertical: 178 º\r\nPantalla Touch: No\r\nCaracteristicas Especiales: 0\r\nNvidia G-sync: Si\r\nAmd Freesync: Si\r\nRadio De Contraste Estático: 1000 :1\r\n\r\nDIMENSIONES\r\nAncho: 558 mm\r\nAlto: 341 mm\r\nEspesor: 85 mm', '1750783646_540cb0611b1a7fee1b53.jpg', 4, 1),
(30, 'Monitor LG 29WQ600-W 29 UltraWide', 'LG', 1, 1600.00, 'PANTALLA\r\nPulgadas: 27 \"\r\nPulgadas Visibles: 27 \"\r\nResolución Máxima: 1920x1080\r\nMáxima Frecuencia: 240 hz\r\nCantidad De Colores: 16.7 m\r\nTiempo De Respuesta: 1 ms\r\nAngulo De Visión Horizontal: 178 º\r\nAngulo De Visión Vertical: 178 º\r\nPantalla Touch: No\r\nCaracteristicas Especiales: 0\r\nNvidia G-sync: Si\r\nAmd Freesync: Si\r\nRadio De Contraste Estático: 1000 :1\r\nRadio De Contraste Dinamico: 1000000 m:1\r\n\r\nCONECTIVIDAD\r\nTotal De Puertos Hdmi: 2\r\nTotal De Puertos Display Port: 1\r\nMini Display Port: 0\r\nVga: 0\r\nDvi: 0\r\nPuertos Usb 2.0: 0\r\nPuertos Usb 3.0: 0\r\nPuertos Usb 3.1: 0\r\nConexión 3.5 Mm - Entrada: No\r\nConector Auriculares: Si\r\n\r\nCARACTERISTICAS GENERALES\r\nTipo De Iluminación: LED\r\nTipo De Panel: IPS\r\nPantalla Curva: No\r\n\r\nDIMENSIONES\r\nAncho: 615 mm\r\nAlto: 366 mm\r\nEspesor: 51 mm', '1750783817_c5bf6a985678d055b440.jpg', 6, 1),
(31, 'Monitor Samsung 22 T350FH FHD IPS 75Hz', 'Samsung', 1, 2500.00, 'PANTALLA\r\nPulgadas: 22 \"\r\nPulgadas Visibles: 21.5 \"\r\nResolución Máxima: 1920x1080\r\nMáxima Frecuencia: 75 hz\r\nCantidad De Colores: 16.7 m\r\nTiempo De Respuesta: 5 ms\r\nAngulo De Visión Horizontal: 178 º\r\nAngulo De Visión Vertical: 178 º\r\nPantalla Touch: No\r\nCaracteristicas Especiales: 0\r\nNvidia G-sync: No\r\nAmd Freesync: Si\r\n\r\nCONECTIVIDAD\r\nTotal De Puertos Hdmi: 1\r\nTotal De Puertos Display Port: 0\r\nMini Display Port: 0\r\nVga: 1\r\nDvi: 0\r\nPuertos Usb 2.0: 0\r\nPuertos Usb 3.0: 0\r\nPuertos Usb 3.1: 0\r\nConexión 3.5 Mm - Entrada: No\r\nConector Auriculares: No\r\n\r\nCARACTERISTICAS GENERALES\r\nTipo De Iluminación: LED\r\nTipo De Panel: IPS\r\nPantalla Curva: No\r\n\r\nDIMENSIONES\r\nAncho: 488 mm\r\nAlto: 369 mm\r\nEspesor: 65 mm', '1750783998_a124e442f4cc69a04313.jpg', 6, 1),
(32, 'Notebook Acer Aspire Go 15 AG15-31P-3947 15.6 i3-N305 8GB SSD 128GB FHD Win11', 'Acer', 2, 2500.00, 'CARACTERISTICAS GENERALES\r\nColor: Plateado\r\nTipo: Notebook\r\nSistema Operativo: Windows 11 Home\r\nBatería Extraible: No\r\nIdioma Sistema Operativo: Ingles\r\nTipo De Cpu: Intel\r\nModelo Cpu: Core i3 N305\r\nTipo De Gpu: Intel Integrated Graphics\r\nModelo Gpu: Intel UHD Graphics\r\nLector De Huellas: No\r\nFamilia Del Procesador: Intel Core i3\r\n\r\nCONECTIVIDAD\r\nPuertos Hdmi: 1\r\nPuertos Mini Hdmi: 0\r\nPuerto Mini Dp: 0\r\nPuertos Usb 2.0 Tipo A: 0\r\nPuertos Usb 3.0 Tipo A: 0\r\nPuertos Usb 3.2 Tipo A: 2\r\nPuertos Usb 3.2 Tipo C: 1\r\nPuertos Ethernet: No\r\nBluetooth: Si\r\nWifi: Norma AX\r\n\r\nDIMENSIONES\r\nPeso: 1.8 kg\r\nAncho: 363 mm\r\nProfundidad: 248 mm\r\nAlto: 18 mm\r\n\r\nCARACTERISTICAS GENERALES\r\nColor: Plateado\r\nTipo: Notebook\r\nSistema Operativo: Windows 11 Home\r\nBatería Extraible: No\r\nIdioma Sistema Operativo: Ingles\r\nTipo De Cpu: Intel\r\nModelo Cpu: Core i3 N305\r\nTipo De Gpu: Intel Integrated Graphics\r\nModelo Gpu: Intel UHD Graphics\r\nLector De Huellas: No\r\nFamilia Del Procesador: Intel Core i3', '1750784232_755681ebdd1a6af72ff6.jpg', 8, 1),
(33, 'Notebook Asus ', 'Asus', 2, 3000.00, 'CARACTERISTICAS GENERALES\r\nColor: Gris Oscuro\r\nTipo: Notebook\r\nSistema Operativo: Windows 11 Home\r\nBatería Extraible: No\r\nIdioma Sistema Operativo: Multiples Idiomas\r\nTipo De Cpu: AMD\r\nModelo Cpu: Ryzen 7 7735HS\r\nTipo De Gpu: Nvidia GeForce\r\nModelo Gpu: GeForce RTX 4050\r\nMemoria Gpu: 6 gb\r\nLector De Huellas: No\r\nFamilia Del Procesador: AMD RYZEN 7\r\n\r\nCONECTIVIDAD\r\nPuertos Hdmi: 1\r\nPuertos Mini Hdmi: 0\r\nPuerto Mini Dp: 0\r\nPuertos Usb 2.0 Tipo A: 0\r\nPuertos Usb 3.0 Tipo A: 0\r\nPuertos Usb 3.2 Tipo A: 2\r\nPuertos Usb 3.2 Tipo C: 2\r\nPuertos Ethernet: Si\r\nBluetooth: Si\r\nWifi: Norma AX\r\nTipo De Thunderbolt: No incluye\r\n\r\nDIMENSIONES\r\nPeso: 2.2 kg\r\nAncho: 354 mm\r\nProfundidad: 250 mm\r\nAlto: 25 mm\r\n\r\nDIMENSIONES\r\nPeso: 2.2 kg\r\nAncho: 354 mm\r\nProfundidad: 250 mm\r\nAlto: 25 mm\r\n\r\nALMACENAMIENTO\r\nCapacidad Hd: 0 gb\r\nSlot M2: Si\r\nTipo De M.2: NVME\r\nCapacidad Sólido: 512 gb\r\nLector De Memorias: No\r\n\r\nPANTALLA\r\nTamaño De La Pantalla: 15.60 \"\r\nTipo De Display: IPS\r\nResolución: 2560x1440\r\nTouch: No', '1750784431_f8fae3595b5b0873889a.jpg', 13, 1),
(34, 'Notebook Asus Vivobook 15', 'Asus', 2, 1900.00, 'CARACTERISTICAS GENERALES\r\nColor: Gris Claro\r\nTipo: Notebook\r\nSistema Operativo: Windows 11 Home\r\nBatería Extraible: No\r\nTipo De Cpu: AMD\r\nModelo Cpu: Ryzen 7 5825U\r\nTipo De Gpu: AMD Integrated Graphics\r\nModelo Gpu: Radeon RX Vega 8\r\nLector De Huellas: No\r\nFamilia Del Procesador: AMD RYZEN 7\r\n\r\nDIMENSIONES\r\nPeso: 1.7 kg\r\nAncho: 359 mm\r\nProfundidad: 232 mm\r\nAlto: 20 mm\r\n\r\nPANTALLA\r\nTamaño De La Pantalla: 15.60 \"\r\nTipo De Display: IPS\r\nResolución: 1920x1080\r\nTouch: No\r\nFrecuencia De Actualizacion: 60 hz\r\n\r\nALMACENAMIENTO\r\nCapacidad Hd: 0 gb\r\nSlot M2: Si\r\nTipo De M.2: NVME\r\nCapacidad Sólido: 512 gb\r\nLector De Memorias: No', '1750784659_78c386a5563e5b5f63ea.jpg', 5, 1),
(35, 'Notebook Gamer MSI Cyborg 14 A13VF-018US 14', 'Msi', 2, 2300.00, 'CARACTERISTICAS GENERALES\r\nColor: Negro\r\nTipo: Notebook\r\nSistema Operativo: Windows 11 Home\r\nBatería Extraible: No\r\nIdioma Sistema Operativo: Multiples Idiomas\r\nTipo De Cpu: Intel\r\nModelo Cpu: Core i7 13620H\r\nTipo De Gpu: Nvidia GeForce\r\nModelo Gpu: GeForce RTX 4060\r\nMemoria Gpu: 8 gb\r\nLector De Huellas: No\r\nFamilia Del Procesador: Intel Core i7\r\n\r\nPANTALLA\r\nTamaño De La Pantalla: 14.00 \"\r\nTipo De Display: IPS\r\nResolución: 1920x1200\r\nTouch: No\r\nFrecuencia De Actualizacion: 144 hz\r\n\r\nALMACENAMIENTO\r\nCapacidad Hd: 0 gb\r\nSlot M2: Si\r\nTipo De M.2: NVME\r\nCapacidad Sólido: 512 gb\r\nLector De Memorias: No\r\n\r\nDIMENSIONES\r\nPeso: 2 kg\r\nAncho: 314 mm\r\nProfundidad: 233 mm\r\nAlto: 22 mm', '1750786985_2f943295e2f9ff5465f9.jpg', 7, 1),
(36, 'Notebook MSI Vector 16 HX AI A2XWIG-050US 16 ', 'Msi', 2, 2100.00, 'CARACTERISTICAS GENERALES\r\nColor: Negro\r\nTipo: Notebook\r\nSistema Operativo: Windows 11 Home\r\nBatería Extraible: No\r\nIdioma Sistema Operativo: Multiples Idiomas\r\nTipo De Cpu: Intel\r\nModelo Cpu: Core i7 13620H\r\nTipo De Gpu: Nvidia GeForce\r\nModelo Gpu: GeForce RTX 4060\r\nMemoria Gpu: 8 gb\r\nLector De Huellas: No\r\nFamilia Del Procesador: Intel Core i7\r\n\r\nPANTALLA\r\nTamaño De La Pantalla: 14.00 \"\r\nTipo De Display: IPS\r\nResolución: 1920x1200\r\nTouch: No\r\nFrecuencia De Actualizacion: 144 hz\r\n\r\nALMACENAMIENTO\r\nCapacidad Hd: 0 gb\r\nSlot M2: Si\r\nTipo De M.2: NVME\r\nCapacidad Sólido: 512 gb\r\nLector De Memorias: No\r\n\r\nMEMORIA\r\nFormato De Memorias: SODIMM\r\nGeneración De Memorias: DDR5\r\nSlot 1 Ram Disponible: No\r\nRam En El Slot 1: 8 gb\r\nSlot 2 Ram Disponible: No\r\nRam En El Slot 2: 8 gb\r\nRam Máxima: 32', '1750787144_a9a6069a16e75c5721cf.jpg', 10, 1),
(37, 'Mother Asrock Z890 RIPTIDE WIFI LGA1851 DDR5', 'Asrock', 4, 3000.00, 'CARACTERISTICAS GENERALES\r\nSocket: 1851 Arrow Lake\r\nChipsets Principal: Intel Z890\r\nPlataforma: Intel\r\nBoton Bios Flashback: Si\r\nBack Connect: No\r\n\r\nCONECTIVIDAD\r\nCantidad De Slot Pci-e 16x: 1\r\nCantidad De Slot Pci-e 1x: 0\r\nTecnología Multi Gpu: 0\r\nSalidas Vga: 0\r\nSalidas Hdmi: 1\r\nSalidas Dvi: 0\r\nSalidas Display Ports: 0\r\nCantidad De Slot M.2 Totales: 5\r\nCantidad De Slot M.2 Nvme: 5\r\nCantidad De Slot M.2 Sata: 1\r\nPuertos Sata: 4\r\nPlaca Wifi Integrada: Si\r\nPlaca De Red: 2.5 Gb/s\r\nPuertos Usb 2.0 Traseros: 2\r\nPuertos Usb 3.0 Traseros: 0\r\nPuertos Usb 3.1 Traseros: 0\r\nSistema De Conexión Rgb: ARGB Header,RGB Header\r\nPuerto Ps/2: No\r\nPuertos Usb 3.2 Traseros: 6\r\nPuertos Usb Type-c: 2\r\nCantidad De Slot Pci-e 4x: 1\r\n\r\nENERGIA\r\nConector 24pines: 1\r\nConsumo: 50 w\r\nConectos Cpu 4pines: 1\r\nConector Cpu 4pines Plus: 1\r\nWatts Máximos Para Cpu: 125\r\nProcesador Integrado: No\r\n\r\nMEMORIA\r\nTipo De Memoria: DDR5\r\nCantidad De Slot De Memorias: 4', '1750787721_31b1177eed1165018e1c.jpg', 5, 1),
(38, 'Mother ASUS ROG CROSSHAIR X870E HERO DDR5 AM5', 'Asus', 4, 2000.00, 'CARACTERISTICAS GENERALES\r\nSocket: AM5 Ryzen 7000,AM5 Ryzen 8000,AM5 Ryzen 9000\r\nChipsets Principal: AMD X870E\r\nPlataforma: AMD\r\nBoton Bios Flashback: Si\r\nBack Connect: No\r\n\r\nCONECTIVIDAD\r\nCantidad De Slot Pci-e 16x: 2\r\nCantidad De Slot Pci-e 1x: 0\r\nTecnología Multi Gpu: 0\r\nSalidas Vga: 0\r\nSalidas Hdmi: 1\r\nSalidas Dvi: 0\r\nSalidas Display Ports: 0\r\nCantidad De Slot M.2 Totales: 5\r\nCantidad De Slot M.2 Nvme: 5\r\nCantidad De Slot M.2 Sata: 0\r\nPuertos Sata: 4\r\nPlaca Wifi Integrada: Si\r\nPlaca De Red: 5 Gb/s\r\nPuertos Usb 2.0 Traseros: 0\r\nPuertos Usb 3.0 Traseros: 0\r\nPuertos Usb 3.1 Traseros: 0\r\nSistema De Conexión Rgb: ARGB Header\r\nPuerto Ps/2: No\r\nPuertos Usb 3.2 Traseros: 6\r\nPuertos Usb Type-c: 4\r\nCantidad De Slot Pci-e 4x: 0\r\n\r\nDIMENSIONES\r\nFactor: ATX\r\n\r\nENERGIA\r\nConector 24pines: 1\r\nConsumo: 50 w\r\nConectos Cpu 4pines: 1\r\nConector Cpu 4pines Plus: 1\r\nWatts Máximos Para Cpu: 170\r\nProcesador Integrado: No\r\n\r\nMEMORIA\r\nTipo De Memoria: DDR5\r\nCantidad De Slot De Memorias: 4\r\n\r\nSONIDO\r\nPlaca De Sonido: 7.1 ROG SupremeFX ALC4082 CODEC', '1750789055_f49cf0192f37a8c6ea55.jpg', 7, 1),
(39, 'Mother ASUS TUF GAMING B550M-PLUS WIFI II AM4', 'Asus', 4, 3000.00, 'CARACTERISTICAS GENERALES\r\nSocket: AM4 Ryzen 3th Gen,AM4 Ryzen 4th Gen,AM4 APU 5000,AM4 APU 3th Gen\r\nChipsets Principal: AMD B550\r\nPlataforma: AMD\r\nBoton Bios Flashback: Si\r\nBack Connect: No\r\n\r\nCONECTIVIDAD\r\nCantidad De Slot Pci-e 16x: 2\r\nCantidad De Slot Pci-e 1x: 1\r\nTecnología Multi Gpu: 0\r\nSalidas Vga: 0\r\nSalidas Hdmi: 1\r\nSalidas Dvi: 0\r\nSalidas Display Ports: 1\r\nCantidad De Slot M.2 Totales: 2\r\nCantidad De Slot M.2 Nvme: 2\r\nCantidad De Slot M.2 Sata: 2\r\nPuertos Sata: 4\r\nPlaca Wifi Integrada: Si\r\nPlaca De Red: 2.5 Gb/s\r\nPuertos Usb 2.0 Traseros: 2\r\nPuertos Usb 3.0 Traseros: 0\r\nPuertos Usb 3.1 Traseros: 0\r\nSistema De Conexión Rgb: ARGB Header,RGB Header\r\nPuerto Ps/2: No\r\nPuertos Usb 3.2 Traseros: 5\r\nPuertos Usb Type-c: 0\r\nCantidad De Slot Pci-e 4x: 0\r\n\r\nDIMENSIONES\r\nFactor: M-ATX\r\n\r\nENERGIA\r\nConector 24pines: 1\r\nConsumo: 45 w\r\nConectos Cpu 4pines: 1\r\nConector Cpu 4pines Plus: 1\r\nWatts Máximos Para Cpu: 105\r\nProcesador Integrado: No\r\n\r\nMEMORIA\r\nTipo De Memoria: DDR4\r\nCantidad De Slot De Memorias: 4\r\n\r\nSONIDO\r\nPlaca De Sonido: Realtek 7.1 CODEC', '1750789151_b3e140162f4774dd6339.jpg', 7, 1),
(40, 'Mother Gigabyte B840M-A AORUS ELITE WIFI 6E AM5 DDR5', 'Gigabyte', 4, 2500.00, 'Aquí tienes el texto formateado correctamente a Clave: Valor y con las líneas en blanco necesarias para que lo copies y pegues en el campo descripcion de tu base de datos:\r\n\r\nCARACTERISTICAS GENERALES\r\nSocket: AM5 Ryzen 7000,AM5 Ryzen 8000,AM5 Ryzen 9000\r\nChipsets Principal: AMD B840\r\nPlataforma: AMD\r\nBoton Bios Flashback: Si\r\nBack Connect: No\r\n\r\nCONECTIVIDAD\r\nCantidad De Slot Pci-e 16x: 2\r\nCantidad De Slot Pci-e 1x: 0\r\nTecnología Multi Gpu: 0\r\nSalidas Vga: 0\r\nSalidas Hdmi: 1\r\nSalidas Dvi: 0\r\nSalidas Display Ports: 1\r\nCantidad De Slot M.2 Totales: 2\r\nCantidad De Slot M.2 Nvme: 2\r\nCantidad De Slot M.2 Sata: 0\r\nPuertos Sata: 4\r\nPlaca Wifi Integrada: Si\r\nPlaca De Red: 2.5 Gb/s\r\nPuertos Usb 2.0 Traseros: 4\r\nPuertos Usb 3.0 Traseros: 0\r\nPuertos Usb 3.1 Traseros: 0\r\nSistema De Conexión Rgb: ARGB Header,RGB Header\r\nPuerto Ps/2: Si\r\nPuertos Usb 3.2 Traseros: 3\r\nPuertos Usb Type-c: 1\r\nCantidad De Slot Pci-e 4x: 0\r\n\r\nDIMENSIONES\r\nFactor: M-ATX\r\n\r\nENERGIA\r\nConector 24pines: 1\r\nConsumo: 45 w\r\nConectos Cpu 4pines: 1\r\nConector Cpu 4pines Plus: 1\r\nWatts Máximos Para Cpu: 170\r\nProcesador Integrado: No\r\n\r\nMEMORIA\r\nTipo De Memoria: DDR5\r\nCantidad De Slot De Memorias: 4\r\n\r\nSONIDO\r\nPlaca De Sonido: Realtek 7.1 CODEC', '1750789253_2439c763152fb2726d82.jpg', 13, 1),
(41, 'Mother MSI B650M GAMING WIFI AM5 DDR5', 'Msi', 4, 1500.00, 'Aquí tienes el texto formateado correctamente a Clave: Valor y con las líneas en blanco necesarias para que lo copies y pegues en el campo descripcion de tu base de datos:\r\n\r\nCARACTERISTICAS GENERALES\r\nSocket: AM5 Ryzen 7000,AM5 Ryzen 8000,AM5 Ryzen 9000\r\nChipsets Principal: AMD B650\r\nPlataforma: AMD\r\nBoton Bios Flashback: Si\r\nBack Connect: No\r\n\r\nCONECTIVIDAD\r\nCantidad De Slot Pci-e 16x: 1\r\nCantidad De Slot Pci-e 1x: 1\r\nTecnología Multi Gpu: 0\r\nSalidas Vga: 0\r\nSalidas Hdmi: 1\r\nSalidas Dvi: 0\r\nSalidas Display Ports: 1\r\nCantidad De Slot M.2 Totales: 2\r\nCantidad De Slot M.2 Nvme: 2\r\nCantidad De Slot M.2 Sata: 0\r\nPuertos Sata: 4\r\nPlaca Wifi Integrada: Si\r\nPlaca De Red: 2.5 Gb/s\r\nPuertos Usb 2.0 Traseros: 2\r\nPuertos Usb 3.0 Traseros: 0\r\nPuertos Usb 3.1 Traseros: 0\r\nSistema De Conexión Rgb: ARGB Header,RGB Header\r\nPuerto Ps/2: No\r\nPuertos Usb 3.2 Traseros: 3\r\nPuertos Usb Type-c: 1\r\nCantidad De Slot Pci-e 4x: 0\r\n\r\nDIMENSIONES\r\nFactor: M-ATX\r\n\r\nENERGIA\r\nConector 24pines: 1\r\nConsumo: 45 w\r\nConectos Cpu 4pines: 1\r\nConector Cpu 4pines Plus: 1\r\nWatts Máximos Para Cpu: 170\r\nProcesador Integrado: No\r\n\r\nMEMORIA\r\nTipo De Memoria: DDR5\r\nCantidad De Slot De Memorias: 2\r\n\r\nSONIDO\r\nPlaca De Sonido: 7.1 Realtek ALC 897 Codec', '1750789309_99c9d54425ba583ca190.jpg', 10, 1),
(42, 'Procesador AMD Ryzen 5 5600G 4.4GHz Turbo', 'Amd', 3, 3000.00, 'CARACTERISTICAS GENERALES\r\nModelo: 5600G\r\nSocket: AM4 APU 5000\r\nProceso De Fabricación: 7 nm\r\nChipset Gpu: Radeon Vega 7\r\nFamilia: AMD RYZEN 5\r\n\r\nESPECIFICACIONES DE LA CPU\r\nNúcleos: 6\r\nFrecuencia: 3900.00 mhz\r\nHilos: 12\r\nFrecuencia Turbo: 4400 mhz\r\n\r\nCOOLERS Y DISIPADORES\r\nIncluye Cooler Cpu: Si\r\nTdp Predeterminada: 65 w\r\n\r\nMEMORIA\r\nL2: 3 mb\r\nL3: 16 mb', '1750789421_a89ade1ab9253c1b6d91.jpg', 15, 1),
(43, 'Procesador AMD Ryzen 5 7600 5.1GHz Turbo AM5', 'Amd', 3, 2500.00, 'CARACTERISTICAS GENERALES\r\nModelo: Ryzen 5 7600\r\nSocket: AM5 Ryzen 7000\r\nProceso De Fabricación: 5 nm\r\nChipset Gpu: AMD Radeon Graphics\r\nFamilia: AMD RYZEN 5\r\n\r\nESPECIFICACIONES DE LA CPU\r\nNúcleos: 6\r\nFrecuencia: 3800.00 mhz\r\nHilos: 12\r\nFrecuencia Turbo: 5100 mhz\r\n\r\nCOOLERS Y DISIPADORES\r\nIncluye Cooler Cpu: Si\r\nTdp Predeterminada: 65 w\r\n\r\nMEMORIA\r\nL1: 0.384 mb\r\nL2: 6 mb\r\nL3: 32 mb', '1750789491_39d378e0a896bb259387.jpg', 11, 1),
(44, 'Procesador AMD Ryzen 5 9600X 5.4GHz Turbo AM5', 'Amd', 3, 4000.00, 'CARACTERISTICAS GENERALES\r\nModelo: Ryzen 5 9600X\r\nSocket: AM5 Ryzen 9000\r\nProceso De Fabricación: 6 nm\r\nChipset Gpu: AMD Radeon Graphics\r\nFamilia: AMD RYZEN 5\r\nRequiere Gpu Obligatoria: No\r\nGeneración De Memorias Compatibles: DDR5\r\n\r\nESPECIFICACIONES DE LA CPU\r\nNúcleos: 6\r\nFrecuencia: 3900.00 mhz\r\nHilos: 12\r\nFrecuencia Turbo: 5400 mhz\r\n\r\nCOOLERS Y DISIPADORES\r\nIncluye Cooler Cpu: No\r\nTdp Predeterminada: 105 w\r\n\r\nMEMORIA\r\nL2: 6 mb\r\nL3: 32 mb', '1750789591_dad83fd5c75be34d2066.jpg', 14, 1),
(45, 'Procesador AMD Ryzen 7 9800X3D 5.2GHz Turbo AM5', 'Amd', 3, 5000.00, 'CARACTERISTICAS GENERALES\r\nModelo: Ryzen 7 9800X3D\r\nSocket: AM5 Ryzen 9000\r\nProceso De Fabricación: 6 nm\r\nChipset Gpu: AMD Radeon Graphics\r\nFamilia: AMD RYZEN 7\r\n\r\nESPECIFICACIONES DE LA CPU\r\nNúcleos: 8\r\nFrecuencia: 4700.00 mhz\r\nHilos: 16\r\nFrecuencia Turbo: 5200 mhz\r\n\r\nCOOLERS Y DISIPADORES\r\nIncluye Cooler Cpu: No\r\nTdp Predeterminada: 200 w\r\n\r\nMEMORIA\r\nL2: 8 mb\r\nL3: 96 mb', '1750789658_3105026d4818998f9568.jpg', 10, 1),
(46, 'Procesador AMD Ryzen 9 9950X 5.7GHz Turbo AM5 ', 'Amd', 3, 5000.00, 'Aquí tienes el texto formateado correctamente a Clave: Valor y con las líneas en blanco necesarias para que lo copies y pegues en el campo descripcion de tu base de datos:\r\n\r\nCARACTERISTICAS GENERALES\r\nModelo: Ryzen 9 9950X\r\nSocket: AM5 Ryzen 9000\r\nProceso De Fabricación: 6 nm\r\nChipset Gpu: AMD Radeon Graphics\r\nFamilia: AMD RYZEN 9\r\n\r\nESPECIFICACIONES DE LA CPU\r\nNúcleos: 16\r\nFrecuencia: 4300.00 mhz\r\nHilos: 32\r\nFrecuencia Turbo: 5700 mhz\r\n\r\nCOOLERS Y DISIPADORES\r\nIncluye Cooler Cpu: No\r\nTdp Predeterminada: 170 w\r\n\r\nMEMORIA\r\nL2: 16 mb\r\nL3: 64 mb', '1750789720_e91f9efa184e1931e8a3.jpg', 15, 1),
(47, 'Gabinete ASUS ROG STRIX GX601 Helios Aluminum Black RGB USB-C', 'Asus', 10, 2000.00, 'Aquí tienes el texto formateado correctamente a Clave: Valor y con las líneas en blanco necesarias para que lo copies y pegues en el campo descripcion de tu base de datos:\r\n\r\nCARACTERISTICAS GENERALES\r\nFactor Mother: ITX,M-ATX,ATX,E-ATX\r\nCon Ventana: Si\r\nTipo De Ventana: Vidrio templado\r\nColores: Negro\r\nFuente En Posición Superior: No\r\nTamaño Del Gabinete: Mid Tower\r\nApto Para Mothers Back Connect: No\r\n\r\nCONECTIVIDAD\r\nUsb 2.0 Frontal: 0\r\nUsb 3.0 Frontal: 4\r\nUsb Tipo C: 1\r\nUsb Tipo C Interno: 1\r\nAudio Hd Frontal: Si\r\nLector De Tarjetas Frontal: No\r\n\r\nDIMENSIONES\r\nAncho: 250 mm\r\nAlto: 591 mm\r\nProfundidad: 565 mm\r\nLargo Máximo Vga: 450 mm\r\nAltura Máxima Del Cooler Cpu: 190.00 mm\r\n\r\nUNIDADES SOPORTADAS\r\nUnidades 5.25\'\' Soportadas: 0\r\nCantidad De Slots: 8\r\nUnidades 2.5\'\' Soportadas: 6\r\nUnidades 3.5\'\' Soportadas: 2\r\nUnidades 3.25\'\' Soportadas: 0\r\n\r\nENERGIA\r\nTipo De Fuente Admitida: ATX\r\n\r\nCOOLERS Y DISIPADORES\r\nCoolers Fan De 80mm Soportados: 0\r\nCoolers Fan De 80mm Incluidos: 0\r\nCoolers Fan De 120mm Soportados: 7\r\nCoolers Fan De 120mm Incluidos: 0\r\nCoolers Fan De 140mm Soportados: 6\r\nCoolers Fan De 140mm Incluidos: 4\r\nCoolers Fan De 200mm Soportados: 0\r\nCoolers Fan De 200mm Incluidos: 0\r\nSoporte Radiador 240mm: 2\r\nSoporte Radiador 280mm: 2\r\nSoporte Radiador 360mm: 1\r\nSoporte Radiador 420mm: 0\r\nIluminación: No Incluye\r\nControlador De Fans: externo\r\nControlador De La Iluminación: Si\r\nEspacio Para Radiador Water: Si\r\n\r\nDETALLE DEL KIT\r\nIncluye Kit De Perifericos: No\r\nIncluye Fuente Kit: No\r\n\r\nACCESORIOS\r\nSoporta Gpu Vertical: Si\r\nRiser Incluido: No\r\nCover Para La Fuente: Si\r\n', '1750789877_55019994bf1069189a39.jpg', 2, 1),
(48, 'Gabinete Corsair 3000D TG Airflow White 2x120mm SP120 Fans USB-A ATX', 'Corsair', 10, 3000.00, 'Aquí tienes el texto formateado correctamente a Clave: Valor y con las líneas en blanco necesarias para que lo copies y pegues en el campo descripcion de tu base de datos:\r\n\r\nCARACTERISTICAS GENERALES\r\nFactor Mother: ITX,M-ATX,ATX\r\nCon Ventana: Si\r\nTipo De Ventana: Vidrio templado\r\nColores: Blanco\r\nFuente En Posición Superior: No\r\nTamaño Del Gabinete: Mid Tower\r\nApto Para Mothers Back Connect: No\r\n\r\nCONECTIVIDAD\r\nUsb 2.0 Frontal: 0\r\nUsb 3.0 Frontal: 2\r\nUsb Tipo C: 0\r\nUsb Tipo C Interno: 0\r\nAudio Hd Frontal: Si\r\nLector De Tarjetas Frontal: No\r\n\r\nDIMENSIONES\r\nAncho: 230 mm\r\nAlto: 466 mm\r\nProfundidad: 462 mm\r\nLargo Máximo Vga: 360 mm\r\nAltura Máxima Del Cooler Cpu: 170.00 mm\r\n\r\nUNIDADES SOPORTADAS\r\nUnidades 5.25\'\' Soportadas: 0\r\nCantidad De Slots: 7\r\nUnidades 2.5\'\' Soportadas: 2\r\nUnidades 3.5\'\' Soportadas: 2\r\nUnidades 3.25\'\' Soportadas: 0\r\n\r\nENERGIA\r\nTipo De Fuente Admitida: ATX\r\n\r\nCOOLERS Y DISIPADORES\r\nCoolers Fan De 80mm Soportados: 0\r\nCoolers Fan De 80mm Incluidos: 0\r\nCoolers Fan De 120mm Soportados: 8\r\nCoolers Fan De 120mm Incluidos: 2\r\nCoolers Fan De 140mm Soportados: 4\r\nCoolers Fan De 140mm Incluidos: 0\r\nCoolers Fan De 200mm Soportados: 0\r\nCoolers Fan De 200mm Incluidos: 0\r\nSoporte Radiador 240mm: 1\r\nSoporte Radiador 280mm: 2\r\nSoporte Radiador 360mm: 1\r\nSoporte Radiador 420mm: 0\r\nIluminación: No Incluye\r\nControlador De La Iluminación: No\r\nEspacio Para Radiador Water: Si\r\n\r\nDETALLE DEL KIT\r\nIncluye Kit De Perifericos: No\r\nIncluye Fuente Kit: No\r\n\r\nACCESORIOS\r\nSoporta Gpu Vertical: No\r\nRiser Incluido: No\r\nCover Para La Fuente: Si', '1750789932_099472c67b9e2f09620d.jpg', 7, 1),
(49, 'Gabinete Corsair 6500D Airflow TG Super Mid-Tower White', 'Corsair', 10, 4000.00, 'Aquí tienes el texto formateado correctamente a Clave: Valor y con las líneas en blanco necesarias para que lo copies y pegues en el campo descripcion de tu base de datos:\r\n\r\nCARACTERISTICAS GENERALES\r\nFactor Mother: ITX,M-ATX,ATX\r\nCon Ventana: Si\r\nTipo De Ventana: Vidrio templado\r\nColores: Blanco\r\nFuente En Posición Superior: No\r\nTamaño Del Gabinete: Mid Tower\r\nApto Para Mothers Back Connect: Si\r\n\r\nCONECTIVIDAD\r\nUsb 2.0 Frontal: 0\r\nUsb 3.0 Frontal: 4\r\nUsb Tipo C: 1\r\nUsb Tipo C Interno: 1\r\nAudio Hd Frontal: Si\r\nLector De Tarjetas Frontal: No\r\n\r\nDIMENSIONES\r\nAncho: 328 mm\r\nAlto: 496 mm\r\nProfundidad: 481 mm\r\nLargo Máximo Vga: 400 mm\r\nAltura Máxima Del Cooler Cpu: 190.00 mm\r\n\r\nUNIDADES SOPORTADAS\r\nUnidades 5.25\'\' Soportadas: 0\r\nCantidad De Slots: 8\r\nUnidades 2.5\'\' Soportadas: 2\r\nUnidades 3.5\'\' Soportadas: 2\r\nUnidades 3.25\'\' Soportadas: 0\r\n\r\nENERGIA\r\nTipo De Fuente Admitida: ATX\r\n\r\nCOOLERS Y DISIPADORES\r\nCoolers Fan De 80mm Soportados: 0\r\nCoolers Fan De 80mm Incluidos: 0\r\nCoolers Fan De 120mm Soportados: 13\r\nCoolers Fan De 120mm Incluidos: 0\r\nCoolers Fan De 140mm Soportados: 6\r\nCoolers Fan De 140mm Incluidos: 0\r\nCoolers Fan De 200mm Soportados: 0\r\nCoolers Fan De 200mm Incluidos: 0\r\nSoporte Radiador 240mm: 3\r\nSoporte Radiador 280mm: 3\r\nSoporte Radiador 360mm: 3\r\nSoporte Radiador 420mm: 0\r\nIluminación: No Incluye\r\nControlador De La Iluminación: No\r\nEspacio Para Radiador Water: Si\r\n\r\nDETALLE DEL KIT\r\nIncluye Kit De Perifericos: No\r\nIncluye Fuente Kit: No\r\n\r\nACCESORIOS\r\nSoporta Gpu Vertical: No\r\nRiser Incluido: No\r\nCover Para La Fuente: Si\r\n', '1750790016_c2dd1614311341c35bfb.jpg', 0, 1),
(50, 'Gabinete Lian Li O11 Dynamic EVO White', 'Lian Li', 10, 2000.00, 'Aquí tienes el texto formateado correctamente a Clave: Valor y con las líneas en blanco necesarias para que lo copies y pegues en el campo descripcion de tu base de datos:\r\n\r\nCARACTERISTICAS GENERALES\r\nFactor Mother: ITX,M-ATX,ATX,E-ATX\r\nCon Ventana: Si\r\nTipo De Ventana: Vidrio templado\r\nColores: Blanco\r\nFuente En Posición Superior: No\r\nApto Para Mothers Back Connect: No\r\n\r\nCONECTIVIDAD\r\nUsb 2.0 Frontal: 0\r\nUsb 3.0 Frontal: 2\r\nUsb Tipo C: 1\r\nUsb Tipo C Interno: 1\r\nAudio Hd Frontal: Si\r\nLector De Tarjetas Frontal: No\r\n\r\nDIMENSIONES\r\nAncho: 285 mm\r\nAlto: 459 mm\r\nProfundidad: 465 mm\r\nLargo Máximo Vga: 426 mm\r\nAltura Máxima Del Cooler Cpu: 167.00 mm\r\n\r\nUNIDADES SOPORTADAS\r\nUnidades 5.25\'\' Soportadas: 0\r\nCantidad De Slots: 7\r\nUnidades 2.5\'\' Soportadas: 9\r\nUnidades 3.5\'\' Soportadas: 6\r\nUnidades 3.25\'\' Soportadas: 0\r\n\r\nENERGIA\r\nTipo De Fuente Admitida: ATX\r\n\r\nCOOLERS Y DISIPADORES\r\nCoolers Fan De 80mm Soportados: 0\r\nCoolers Fan De 80mm Incluidos: 0\r\nCoolers Fan De 120mm Soportados: 10\r\nCoolers Fan De 120mm Incluidos: 0\r\nCoolers Fan De 140mm Soportados: 6\r\nCoolers Fan De 140mm Incluidos: 0\r\nCoolers Fan De 200mm Soportados: 0\r\nCoolers Fan De 200mm Incluidos: 0\r\nSoporte Radiador 240mm: 3\r\nSoporte Radiador 280mm: 3\r\nSoporte Radiador 360mm: 3\r\nSoporte Radiador 420mm: 0\r\nIluminación: No Incluye\r\nControlador De La Iluminación: No\r\nEspacio Para Radiador Water: Si\r\n\r\nDETALLE DEL KIT\r\nIncluye Kit De Perifericos: No\r\nIncluye Fuente Kit: No\r\n\r\nACCESORIOS\r\nSoporta Gpu Vertical: No\r\nRiser Incluido: No\r\nCover Para La Fuente: Si', '1750790125_bc3019294a2422567b93.jpg', 0, 1),
(51, 'Gabinete Lian Li O11 Dynamic Mini Snow Solo fuente SFXSFX-L ITX', 'Lian Li', 10, 2500.00, 'Aquí tienes el texto formateado correctamente a Clave: Valor y con las líneas en blanco necesarias para que lo copies y pegues en el campo descripcion de tu base de datos:\r\n\r\nCARACTERISTICAS GENERALES\r\nFactor Mother: ITX,M-ATX,ATX,E-ATX\r\nCon Ventana: Si\r\nTipo De Ventana: Vidrio templado\r\nColores: Blanco\r\nFuente En Posición Superior: No\r\nTamaño Del Gabinete: Mid Tower\r\nApto Para Mothers Back Connect: No\r\n\r\nCONECTIVIDAD\r\nUsb 2.0 Frontal: 0\r\nUsb 3.0 Frontal: 2\r\nUsb Tipo C: 1\r\nUsb Tipo C Interno: 1\r\nAudio Hd Frontal: Si\r\nLector De Tarjetas Frontal: No\r\n\r\nDIMENSIONES\r\nAncho: 269 mm\r\nAlto: 380 mm\r\nProfundidad: 420 mm\r\nLargo Máximo Vga: 370 mm\r\nAltura Máxima Del Cooler Cpu: 170.00 mm\r\n\r\nUNIDADES SOPORTADAS\r\nUnidades 5.25\'\' Soportadas: 0\r\nCantidad De Slots: 5\r\nUnidades 2.5\'\' Soportadas: 4\r\nUnidades 3.5\'\' Soportadas: 2\r\nUnidades 3.25\'\' Soportadas: 0\r\n\r\nENERGIA\r\nTipo De Fuente Admitida: SFX\r\n\r\nCOOLERS Y DISIPADORES\r\nCoolers Fan De 80mm Soportados: 0\r\nCoolers Fan De 80mm Incluidos: 0\r\nCoolers Fan De 120mm Soportados: 9\r\nCoolers Fan De 120mm Incluidos: 0\r\nCoolers Fan De 140mm Soportados: 6\r\nCoolers Fan De 140mm Incluidos: 0\r\nCoolers Fan De 200mm Soportados: 0\r\nCoolers Fan De 200mm Incluidos: 0\r\nSoporte Radiador 240mm: 3\r\nSoporte Radiador 280mm: 3\r\nSoporte Radiador 360mm: 2\r\nSoporte Radiador 420mm: 0\r\nIluminación: No Incluye\r\nControlador De La Iluminación: No\r\nEspacio Para Radiador Water: Si\r\n\r\nDETALLE DEL KIT\r\nIncluye Kit De Perifericos: No\r\nIncluye Fuente Kit: No\r\n\r\nACCESORIOS\r\nSoporta Gpu Vertical: Si\r\nRiser Incluido: No\r\nCover Para La Fuente: Si', '1750790205_a18e5c7e640270f440eb.jpg', 0, 1),
(52, 'Memoria ADATA DDR4 32GB 3200MHz XPG Spectrix D35 Black CL16', 'Adata', 5, 1000.00, 'CARACTERISTICAS GENERALES\r\nCapacidad: 32 gb\r\nVelocidad: 3200 mhz\r\nTipo: DDR4\r\nCantidad De Memorias: 1\r\nLatencia: 16 cl\r\nVoltaje: 1.20 v\r\n\r\nCOMPATIBILIDAD\r\nTipo Sodimm: No\r\n\r\nCOOLERS Y DISIPADORES\r\nDisipador: Si\r\nDisipador Alto: Si\r\n', '1750790286_05ed84520e4d7d0e51ad.jpg', 15, 1),
(53, 'Memoria Corsair DDR5 64GB (2x32GB) 6000MHz Dominator Titanium ', 'Corsair', 5, 1500.00, 'CARACTERISTICAS GENERALES\r\nCapacidad: 64 gb\r\nVelocidad: 6000 mhz\r\nTipo: DDR5\r\nCantidad De Memorias: 2\r\nLatencia: 30 cl\r\nVoltaje: 1.40 v\r\n\r\nCOMPATIBILIDAD\r\nTipo Sodimm: No\r\n\r\nCOOLERS Y DISIPADORES\r\nDisipador: Si\r\nDisipador Alto: Si', '1750790346_e2a557b060ba291ae685.jpg', 14, 1),
(54, 'Memoria Patriot DDR5 16GB 6000MHz Viper Black CL30', 'Patriot', 5, 2000.00, 'Aquí tienes el texto formateado correctamente a Clave: Valor y con las líneas en blanco necesarias para que lo copies y pegues en el campo descripcion de tu base de datos:\r\n\r\nCARACTERISTICAS GENERALES\r\nCapacidad: 16 gb\r\nVelocidad: 6000 mhz\r\nTipo: DDR5\r\nCantidad De Memorias: 1\r\nLatencia: 30 cl\r\nVoltaje: 0.00 v\r\n\r\nCOMPATIBILIDAD\r\nTipo Sodimm: No\r\n\r\nCOOLERS Y DISIPADORES\r\nDisipador: Si\r\nDisipador Alto: Si', '1750790443_f40275e72ed660a8738f.jpg', 0, 1),
(55, 'Memoria Team DDR4 8GB 3200MHz T-Force Vulcan Z Grey CL16', 'Team', 5, 2000.00, 'CARACTERISTICAS GENERALES\r\nCapacidad: 8 gb\r\nVelocidad: 3200 mhz\r\nTipo: DDR4\r\nCantidad De Memorias: 1\r\nLatencia: 16 cl\r\nVoltaje: 1.35 v\r\n\r\nCOMPATIBILIDAD\r\nTipo Sodimm: No\r\n\r\nCOOLERS Y DISIPADORES\r\nDisipador: Si\r\nDisipador Alto: No', '1750790504_34fc649173270175da98.jpg', 1, 1),
(56, 'Memoria Team DDR5 32GB ', 'Team', 5, 1000.00, 'CARACTERISTICAS GENERALES\r\nCapacidad: 32 gb\r\nVelocidad: 7200 mhz\r\nTipo: DDR5\r\nCantidad De Memorias: 2\r\nLatencia: 34 cl\r\nVoltaje: 1.40 v\r\n\r\nCOMPATIBILIDAD\r\nTipo Sodimm: No\r\n\r\nCOOLERS Y DISIPADORES\r\nDisipador: Si\r\nDisipador Alto: Si', '1750790560_5cff67423b9287b9c62d.jpg', 12, 1),
(57, 'CAJA1', 'Amd', 1, 99999999.99, '234546gfdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsa                           fdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsafdgfdgfdddddddddfdg463453^&%%^$#%^&^(**()*)()(*<\":>\":>\":,;\',p[l,;\',ewfwefsa', '1750806217_23984d5ad8305f85f3c9.png', 2147483647, 1),
(58, 'Teclado Hipermagnético Steel Series Apex PRO TKL 3 Wireless 2.4Ghz ', 'Steel Series', 21, 1000.00, 'CARACTERISTICAS GENERALES\r\nTipo De Teclado: Compacto TKL\r\nTipo De Mecanismo: Mecánico\r\nTipo De Switch: Hyper Magnetic\r\nSwitch Especifico: Omni Point 3.0\r\nColor: Negro\r\nMaterial: Plástico, Aluminio\r\nIdioma: Inglés\r\nDistribución: Estados Unidos\r\nTouchpad: No\r\nPad Numérico: No\r\n\r\nRENDIMIENTO\r\nAnti Salpicaduras: Si\r\nPolling Rate: 1000 hz\r\nTiempo De Respuesta: 0.7 ms\r\nN-key Rollover: No\r\nAntighosting: Si\r\n\r\nCONECTIVIDAD\r\nPuertos Usb Requeridos: 1\r\nPuertos Ps/2 Requeridos: No\r\nAudio Hub: No\r\nConexión Bluetooth: Si\r\nReceptor Bluetooth Incluido: No\r\nConexión Wireless Con Receptor: Si\r\n\r\nDIMENSIONES\r\nPeso: 0.974 kg\r\nAncho: 355 mm\r\nProfundidad: 129 mm\r\nAlto: 42 mm\r\nReposamuñecas: Si\r\nReposamuñecas Extraíble: Si\r\n\r\nCABLEADO\r\nTipo Cable: Mallado de tela\r\nCable Extraíble: Si\r\nLargo Del Cable: 1.8 metros\r\n\r\nCOMPATIBILIDAD\r\nTecnologías Compatibles: Software propio\r\n\r\nENERGIA\r\nAlimentación: Batería interna\r\nPilas Incluidas: No\r\n\r\nEXTRAS\r\nFunda: No\r\n\r\nILUMINACIÓN\r\nColor Led: RGB', '1750807501_2e7e3bdd4aafc2b70bab.jpg', 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','cliente') NOT NULL DEFAULT 'cliente',
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `email`, `password`, `rol`, `activo`, `created_at`, `updated_at`) VALUES
(16, 'Samuel', 'Zini', 'zini@live.com', '$2y$10$Zs0XW00ZUFODl.lk.d6CPu1MOn4xMEBRDI4aE5XVRfUWyFESHteXO', 'admin', 1, '2025-06-15 11:33:07', '2025-06-15 11:33:07'),
(27, 'Jose', 'Vega', 'vega@live.com', '$2y$10$PWUmwL.N6QhST1tY0TuxoOsOCSpWlmreFYL/JLw93NXqPOrVaNe5m', 'admin', 1, '2025-06-25 15:07:36', '2025-06-25 12:08:06'),
(28, 'Cliente', 'Cliente', 'Cliente@live.com', '$2y$10$UI6DRNn76ycOjRErCL4Pp.fNcF87X4bGZcYK04vu/FzWp0SL9.tdC', 'cliente', 1, '2025-06-25 19:20:21', '2025-06-25 19:20:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha_venta` datetime DEFAULT current_timestamp(),
  `total_venta` decimal(10,2) NOT NULL,
  `estado_venta` varchar(50) DEFAULT 'completada',
  `datos_cliente` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_usuario`, `fecha_venta`, `total_venta`, `estado_venta`, `datos_cliente`, `created_at`, `updated_at`, `deleted_at`) VALUES
(26, 22, '2025-06-25 13:02:13', 4000.00, 'pendiente', '{\"nombre\":\"Cliente\",\"apellido\":\"Cliente\",\"email\":\"Cliente@live.com\",\"dni\":\"1212121212\",\"telefono\":\"1212121212\",\"direccion\":\"121221 dede\"}', '2025-06-25 16:02:13', '2025-06-25 16:02:13', NULL),
(27, 28, '2025-06-25 16:20:54', 2000.00, 'pendiente', '{\"nombre\":\"Cliente\",\"apellido\":\"Cliente\",\"email\":\"Cliente@live.com\",\"dni\":\"12121212\",\"telefono\":\"12121212\",\"direccion\":\"dedede12\"}', '2025-06-25 19:20:54', '2025-06-25 19:20:54', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  ADD PRIMARY KEY (`id_mensaje`),
  ADD KEY `fk_mensajes_usuario` (`id_usuario`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  ADD CONSTRAINT `fk_mensajes_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
