CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  username VARCHAR(64) NOT NULL,
  email VARCHAR(256) NOT NULL,
  password VARCHAR(72),
  auth_type VARCHAR(128) DEFAULT 'PASSWORD',
  user_info VARCHAR(256) DEFAULT NULL,
  picture VARCHAR(256),
  banner VARCHAR(256),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  darkmode TINYINT(1) DEFAULT TRUE
);

CREATE TABLE posts (
  id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  content TEXT,
  date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fk_owner BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (fk_owner) REFERENCES users (id)
);

CREATE TABLE files (
  id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  file_name VARCHAR(255) NOT NULL,
  file_type VARCHAR(8) NOT NULL,
  upload_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fk_post BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (fk_post) REFERENCES posts (id),
  UNIQUE(fk_post, id),
  fk_owner BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (fk_owner) REFERENCES users (id)
);

CREATE TABLE likes (
  id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  fk_post BIGINT UNSIGNED NOT NULL,
  type_like VARCHAR(32) DEFAULT 'POST',
  FOREIGN KEY (fk_post) REFERENCES posts (id),
  fk_like_owner BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (fk_like_owner) REFERENCES users (id),
  UNIQUE(fk_post, fk_like_owner)
);

CREATE TABLE comments (
  id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  comment_text TEXT,
  comment_media VARCHAR(255) DEFAULT NULL,
  comment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  comment_likes INT DEFAULT 0,
  fk_post BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (fk_post) REFERENCES posts (id),
  fk_owner BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (fk_owner) REFERENCES users (id)
);

CREATE TABLE follows (
  id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  user_followed BIGINT UNSIGNED NOT NULL,
  follow_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fk_user BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (fk_user) REFERENCES users (id),
  UNIQUE(user_followed, fk_user)
);

CREATE TABLE messages (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  message_text TEXT,
  message_media TEXT,
  message_target BIGINT UNSIGNED NOT NULL,
  message_owner BIGINT UNSIGNED NOT NULL,
  message_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (message_owner) REFERENCES users (id)
);

CREATE TABLE blocks (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  user_blocked BIGINT UNSIGNED NOT NULL,
  block_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fk_user BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (fk_user) REFERENCES users (id),
  UNIQUE(user_blocked, fk_user)
);

CREATE TABLE notifications (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  notifications_message VARCHAR(256),
  fk_user BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (fk_user) REFERENCES users (id)
);

CREATE TABLE pwdreset (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  ipRequest VARCHAR(46) NOT NULL,
  dateRequest TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  cityRequest VARCHAR(128),
  regionRequest VARCHAR(128),
  countryRequest VARCHAR(128),
  pwdResetEmail VARCHAR(256) NOT NULL,
  pwdResetSelector TEXT NOT NULL,
  pwdResetToken TEXT NOT NULL,
  pwdResetExpires VARCHAR(32) NOT NULL
);

/* Drop tables

DROP TABLE comments,likes,files,posts,messages,blocks,pwdreset,follows,notifications,users;

*/