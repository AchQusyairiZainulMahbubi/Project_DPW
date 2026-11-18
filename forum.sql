-- 1. Tabel user
CREATE TABLE `user` (
    `id_User` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(250),
    `email` VARCHAR(250),
    `password` VARCHAR(250), -- Disesuaikan dengan nama kolom di gambar (bisa diubah ke 'password')
    `role` VARCHAR(250),
    `avatar` VARCHAR(250),
    PRIMARY KEY (`id_User`)
);

-- 2. Tabel category
CREATE TABLE `category` (
    `id_categori` INT NOT NULL AUTO_INCREMENT,
    `nama_kategori` VARCHAR(250),
    PRIMARY KEY (`id_categori`)
);

-- 3. Tabel POST
CREATE TABLE `POST` (
    `id_post` INT NOT NULL AUTO_INCREMENT,
    `id_User` INT,
    `id_categori` INT,
    `title` VARCHAR(250),
    `content` TEXT,
    `created_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_post`),
    CONSTRAINT `fk_post_user` FOREIGN KEY (`id_User`) REFERENCES `user`(`id_User`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_post_category` FOREIGN KEY (`id_categori`) REFERENCES `category`(`id_categori`) ON DELETE SET NULL ON UPDATE CASCADE
);

-- 4. Tabel comments
CREATE TABLE `comments` (
    `id_komen` INT NOT NULL AUTO_INCREMENT,
    `id_User` INT,
    `id_post` INT,
    `parent_id` INT NULL,
    `isi` TEXT,
    `waktu_buat` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_komen`),
    CONSTRAINT `fk_comments_user` FOREIGN KEY (`id_User`) REFERENCES `user`(`id_User`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_comments_post` FOREIGN KEY (`id_post`) REFERENCES `POST`(`id_post`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_comments_parent` FOREIGN KEY (`parent_id`) REFERENCES `comments`(`id_komen`) ON DELETE CASCADE ON UPDATE CASCADE
);