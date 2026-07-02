-- Allow root to connect from anywhere (for Render to use)
-- First check the current policy level and lower it temporarily if needed
SET GLOBAL validate_password.policy = LOW;
SET GLOBAL validate_password.length = 6;

-- Create a dedicated app user
CREATE USER IF NOT EXISTS 'dsl_app'@'%' IDENTIFIED BY 'Dsl@App2026!';
GRANT ALL PRIVILEGES ON dslclinic_dslDB.* TO 'dsl_app'@'%';

-- Also allow root from anywhere as fallback
UPDATE mysql.user SET host='%' WHERE user='root' AND host='localhost';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;

FLUSH PRIVILEGES;
SELECT user, host FROM mysql.user WHERE user IN ('root', 'dsl_app');
