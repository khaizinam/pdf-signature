-- Create uuid-ossp if does not exist
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- Create the database
CREATE DATABASE dev_pnjp;

-- Create the user
CREATE USER dev_pnjp WITH PASSWORD 'DKjZywAde';

-- Grant all privileges on the database to the user
GRANT ALL PRIVILEGES ON DATABASE dev_pnjp TO dev_pnjp;

-- Connect to the database
\c dev_pnjp;

-- Grant privileges on the public schema
GRANT ALL PRIVILEGES ON SCHEMA public TO dev_pnjp;

-- Grant privileges on all tables in the public schema
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO dev_pnjp;

-- Grant privileges on all sequences in the public schema
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO dev_pnjp;

-- Grant privileges on all functions in the public schema
GRANT ALL PRIVILEGES ON ALL FUNCTIONS IN SCHEMA public TO dev_pnjp;

-- Grant ownership of the uuid_generate_v1 function
ALTER FUNCTION public.uuid_generate_v1() OWNER TO dev_pnjp;
