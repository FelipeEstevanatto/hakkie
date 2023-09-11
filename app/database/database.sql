CREATE TABLE users (
  id_user BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  name_user VARCHAR(64) NOT NULL,
  user_email VARCHAR(256) NOT NULL,
  user_password VARCHAR(72),
  auth_type VARCHAR(128) DEFAULT 'PASSWORD',
  user_info VARCHAR(256) DEFAULT NULL,
  user_picture VARCHAR(256),
  user_banner VARCHAR(256),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  darkmode TINYINT(1) DEFAULT TRUE
);

CREATE TABLE posts (
  id_post BIGINT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  post_text TEXT,
  post_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fk_owner BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (fk_owner) REFERENCES users (id_user)
);

CREATE TABLE files (
  id_file BIGINT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  file_name VARCHAR(255) NOT NULL,
  file_type VARCHAR(8) NOT NULL,
  file_upload_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fk_post BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (fk_post) REFERENCES posts (id_post),
  UNIQUE(fk_post, id_file),
  fk_owner BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (fk_owner) REFERENCES users (id_user)
);

CREATE TABLE likes (
  id_like BIGINT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  fk_post BIGINT UNSIGNED NOT NULL,
  type_like VARCHAR(32) DEFAULT 'POST',
  FOREIGN KEY (fk_post) REFERENCES posts (id_post),
  fk_like_owner BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (fk_like_owner) REFERENCES users (id_user),
  UNIQUE(fk_post, fk_like_owner)
);

CREATE TABLE comments (
  id_comment BIGINT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  comment_text TEXT,
  comment_media VARCHAR(255) DEFAULT NULL,
  comment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  comment_likes INT DEFAULT 0,
  fk_post BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (fk_post) REFERENCES posts (id_post),
  fk_owner BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (fk_owner) REFERENCES users (id_user)
);

CREATE TABLE follows (
  id_follow BIGINT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  user_followed BIGINT UNSIGNED NOT NULL,
  follow_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fk_user BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (fk_user) REFERENCES users (id_user),
  UNIQUE(user_followed, fk_user)
);

CREATE TABLE messages (
  id_message BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  message_text TEXT,
  message_media TEXT,
  message_target BIGINT UNSIGNED NOT NULL,
  message_owner BIGINT UNSIGNED NOT NULL,
  message_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (message_owner) REFERENCES users (id_user)
);

CREATE TABLE blocks (
  id_block BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  user_blocked BIGINT UNSIGNED NOT NULL,
  block_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fk_user BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (fk_user) REFERENCES users (id_user),
  UNIQUE(user_blocked, fk_user)
);

CREATE TABLE notifications (
  id_notice BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  notifications_message VARCHAR(256),
  fk_user BIGINT UNSIGNED NOT NULL,
  FOREIGN KEY (fk_user) REFERENCES users (id_user)
);

CREATE TABLE pwdreset (
  id_pwdReset BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
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