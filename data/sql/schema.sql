CREATE TABLE comments (id INT AUTO_INCREMENT, article_id INT, author_name VARCHAR(255) NOT NULL, author_email VARCHAR(255), author_url VARCHAR(255), content TEXT NOT NULL, is_active TINYINT(1) DEFAULT '0' NOT NULL, created_at DATETIME, updated_at DATETIME, INDEX article_id_idx (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE content_types (id INT AUTO_INCREMENT, name VARCHAR(255) NOT NULL, description TEXT, db_name VARCHAR(255), module VARCHAR(20), is_active TINYINT(1) DEFAULT '0' NOT NULL, created_at DATETIME, updated_at DATETIME, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE catalogs (id INT AUTO_INCREMENT, name VARCHAR(255), description TEXT, is_active TINYINT(1) DEFAULT '0' NOT NULL, locked_by INT, created_at DATETIME, updated_at DATETIME, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE content_type_catalog (ctype_id INT, catalog_id INT, PRIMARY KEY(ctype_id, catalog_id)) ENGINE = INNODB;
CREATE TABLE article_label (article_id INT, label_id INT, PRIMARY KEY(article_id, label_id)) ENGINE = INNODB;
CREATE TABLE labels (id INT AUTO_INCREMENT, catalog_id INT, name VARCHAR(255) NOT NULL, title VARCHAR(255), description TEXT, meta_title VARCHAR(255), meta_robots VARCHAR(255), meta_descr TEXT, meta_keys TEXT, is_active TINYINT(1) DEFAULT '0' NOT NULL, created_by INT, updated_by INT, created_at DATETIME, updated_at DATETIME, slug VARCHAR(255), root_id INT, lft INT, rgt INT, level SMALLINT, UNIQUE INDEX sluggable_idx (slug), INDEX catalog_id_idx (catalog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE articles (id INT AUTO_INCREMENT, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255), summary LONGTEXT, content LONGTEXT, meta_title VARCHAR(255), meta_descr TEXT, meta_keys TEXT, meta_robots VARCHAR(255), is_active TINYINT(1) DEFAULT '0' NOT NULL, is_featured TINYINT(1) DEFAULT '0' NOT NULL, is_sticky TINYINT(1) DEFAULT '0' NOT NULL, publish_start DATETIME, publish_end DATETIME, status TINYINT DEFAULT 0 NOT NULL, options TEXT, created_by INT, updated_by INT, locked_by INT, created_at DATETIME, updated_at DATETIME, slug VARCHAR(255), UNIQUE INDEX article_slug_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
ALTER TABLE comments ADD FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE;
ALTER TABLE content_type_catalog ADD FOREIGN KEY (ctype_id) REFERENCES content_types(id) ON DELETE CASCADE;
ALTER TABLE content_type_catalog ADD FOREIGN KEY (catalog_id) REFERENCES catalogs(id) ON DELETE CASCADE;
ALTER TABLE article_label ADD FOREIGN KEY (label_id) REFERENCES labels(id) ON DELETE CASCADE;
ALTER TABLE article_label ADD FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE;
ALTER TABLE labels ADD FOREIGN KEY (catalog_id) REFERENCES catalogs(id) ON DELETE CASCADE;
