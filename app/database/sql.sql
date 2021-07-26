/*Using POSTGRESQL 13*/

CREATE TABLE users (
  id_user SERIAL PRIMARY KEY NOT NULL,
  name_user VARCHAR(64),
  email_user VARCHAR(256) NOT NULL,
  user_password VARCHAR(72),
  auth_type VARCHAR(128) DEFAULT 'PASSWORD',
  user_picture VARCHAR(256),
  user_banner VARCHAR(256),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  darkmode BOOLEAN DEFAULT TRUE
);
  
CREATE TABLE posts (
  id_post SERIAL NOT NULL PRIMARY KEY,
  post_text TEXT,
  post_media TEXT,
  post_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fk_user BIGINT NOT NULL,
  FOREIGN KEY (fk_user) REFERENCES users (id_user)
);

CREATE TABLE comments (
  id_comment SERIAL NOT NULL PRIMARY KEY,
  comment_text TEXT,
  comment_media TEXT,
  comment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  likes INT DEFAULT 0,
  fk_post BIGINT NOT NULL,
  FOREIGN KEY (fk_post) REFERENCES posts (id_post),
  fk_user BIGINT NOT NULL,
  FOREIGN KEY (fk_user) REFERENCES users (id_user)
);

CREATE TABLE follows (
  id_friend SERIAL NOT NULL PRIMARY KEY,
  user_friend BIGINT NOT NULL,
  friend_date TIMESTAMP DEFAULT CURRENT_DATE,
  fk_user BIGINT NOT NULL,
  FOREIGN KEY (fk_user) REFERENCES users (id_user)
);

CREATE TABLE messages (
  id_message SERIAL NOT NULL PRIMARY KEY,
  message_text TEXT,
  message_media TEXT,
  message_target BIGINT NOT NULL,
  message_owner BIGINT NOT NULL,
  message_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (message_owner) REFERENCES users (id_user)
);

CREATE TABLE blocks (
  id_block SERIAL PRIMARY KEY NOT NULL,
  user_blocked BIGINT NOT NULL,
  block_date TIMESTAMP DEFAULT CURRENT_DATE,
  fk_user BIGINT NOT NULL,
  FOREIGN KEY (fk_user) REFERENCES users (id_user)
);

CREATE TABLE pwdreset (
  id_pwdReset SERIAL PRIMARY KEY NOT NULL,
  ipRequest VARCHAR(46) NOT NULL,
  dateRequest TIMESTAMP NOT NULL DEFAULT now(),
  cityRequest VARCHAR(128),
  regionRequest VARCHAR(128),
  countryRequest VARCHAR(128),
  pwdResetEmail VARCHAR(256) NOT NULL,
  pwdResetSelector TEXT NOT NULL,
  pwdResetToken TEXT NOT NULL,
  pwdResetExpires VARCHAR(32) NOT NULL
);

/* Drop tables

DROP TABLE pwdreset,blocks,messages,follows,comments,posts,users;

*/