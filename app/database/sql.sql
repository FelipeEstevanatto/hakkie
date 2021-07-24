CREATE TABLE users (
  id_user SERIAL PRIMARY KEY NOT NULL,
  name_user VARCHAR(256),
  email_user VARCHAR(256),
  user_password VARCHAR(72),
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

CREATE TABLE messages (
  id_message SERIAL NOT NULL PRIMARY KEY,
  message_text TEXT,
  message_media TEXT,
  message_target BIGINT NOT NULL,
  message_owner BIGINT NOT NULL,
  message_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (message_owner) REFERENCES users (id_user)
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

CREATE TABLE blocks (
  id_block SERIAL PRIMARY KEY NOT NULL,
  user_blocked BIGINT NOT NULL,
  fk_user BIGINT NOT NULL,
  FOREIGN KEY (fk_user) REFERENCES users (id_user)
);

/* Drop tables

DROP TABLE blocks,pwdreset,messages,posts,users;

*/