CREATE TABLE users (
  id_user SERIAL PRIMARY KEY NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email_user VARCHAR(256),
  user_password VARCHAR(72),
  user_picture VARCHAR(255),
  user_banner VARCHAR(255),
  darkmode BOOLEAN DEFAULT TRUE
  );
  
CREATE TABLE posts (
  id_post SERIAL NOT NULL PRIMARY KEY,
  post_text TEXT,
  post_media TEXT,
  fk_user BIGINT NOT NULL,
  FOREIGN KEY (fk_user) REFERENCES users (id_user)
  );

CREATE TABLE messages (
  id_message SERIAL NOT NULL PRIMARY KEY,
  message_text TEXT,
  message_media TEXT,
  message_target BIGINT NOT NULL,
  message_owner BIGINT NOT NULL,
  FOREIGN KEY (message_owner) REFERENCES users (id_user)
  );
  
CREATE TABLE pwdreset (
  id_pwdReset SERIAL PRIMARY KEY NOT NULL,
  ipRequest VARCHAR(46) NOT NULL,
  dateRequest TIMESTAMP NOT NULL DEFAULT now(),
  pwdResetEmail VARCHAR(128) NOT NULL,
  pwdResetSelector VARCHAR(256) NOT NULL,
  pwdResetToken VARCHAR(256) NOT NULL,
  pwdResetExpires VARCHAR(256) NOT NULL
  );