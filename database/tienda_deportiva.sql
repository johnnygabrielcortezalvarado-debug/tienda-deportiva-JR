-- ============================================================
-- tienda_deportiva.sql
-- Base de datos: Tienda de Ropa Deportiva
-- Cortez Alvarado Johnny Gabriel
-- Desarrollo de Aplicaciones Web — 2026A
-- ============================================================

-- ── TABLA: categorias ──────────────────────────────────────
CREATE TABLE IF NOT EXISTS categorias (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(100) NOT NULL,
    descripcion TEXT,
    estado      TINYINT(1) NOT NULL DEFAULT 1,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ── TABLA: productos ───────────────────────────────────────
CREATE TABLE IF NOT EXISTS productos (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id    INT NOT NULL,
    nombre          VARCHAR(150) NOT NULL,
    descripcion     TEXT,
    precio          DECIMAL(10,2) NOT NULL,
    stock           INT NOT NULL DEFAULT 0,
    talla           VARCHAR(20),
    imagen_url      VARCHAR(255),
    estado          TINYINT(1) NOT NULL DEFAULT 1,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_categoria
        FOREIGN KEY (categoria_id)
        REFERENCES categorias(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ── DATOS DE PRUEBA ────────────────────────────────────────
INSERT INTO categorias (nombre, descripcion) VALUES
('Camisetas',    'Camisetas deportivas de alto rendimiento'),
('Pantalonetas', 'Pantalonetas y shorts para todo deporte'),
('Zapatillas',   'Calzado deportivo para distintas disciplinas'),
('Chaquetas',    'Chaquetas y cortavientos para entrenamiento'),
('Accesorios',   'Medias, gorras, guantes y más');

INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, talla) VALUES
(1, 'Camiseta Running Pro',     'Tejido transpirable de secado rápido', 24.99,  50, 'M'),
(1, 'Camiseta Gym Flex',        'Diseño ajustado para entrenamiento',   19.99,  40, 'L'),
(2, 'Pantaloneta Fútbol Elite', 'Con bolsillos laterales y cintura elástica', 18.50, 35, 'M'),
(2, 'Short Training Plus',      'Doble capa interior para mayor soporte',     22.00, 20, 'S'),
(3, 'Zapatilla Sprint X200',    'Suela de agarre para pista y calle',   89.99,  15, '42'),
(3, 'Zapatilla Trail Force',    'Refuerzo de tobillo para terreno irregular',  95.00, 10, '41'),
(4, 'Chaqueta Wind Pro',        'Cortavientos ultraligera impermeable', 55.00,  25, 'L'),
(5, 'Gorra Performance',        'Con banda antisudor y ajuste trasero', 12.99, 100, 'Única');
