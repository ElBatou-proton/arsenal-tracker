-- Allow connections from any host in the Docker network
-- This is necessary for some Windows Docker Desktop configurations
CREATE USER IF NOT EXISTS 'arsenal_user'@'%' IDENTIFIED BY 'arsenal_secure_password';
GRANT ALL PRIVILEGES ON arsenal_tracker.* TO 'arsenal_user'@'%';

-- Also grant root access from any host for Docker environment
CREATE USER IF NOT EXISTS 'root'@'%' IDENTIFIED BY 'arsenal_root_secure_password';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;

FLUSH PRIVILEGES;
