CREATE TABLE interest
(
	id BIGSERIAL PRIMARY KEY,
	name TEXT NOT NULL,
	description TEXT
);
CREATE TABLE source
(
	id BIGSERIAL PRIMARY KEY,
	name TEXT NOT NULL
);
CREATE TABLE status
(
	id BIGSERIAL PRIMARY KEY,
	name TEXT NOT NULL
);
CREATE TABLE operator
(
	id BIGSERIAL PRIMARY KEY,
	name TEXT NOT NULL,
	login TEXT NOT NULL UNIQUE,
	password TEXT NOT NULL,
	is_admin BOOLEAN,
	is_active BOOLEAN
);
CREATE TABLE note
(
	id BIGSERIAL PRIMARY KEY,
	description TEXT NOT NULL,
	creation TIMESTAMP NOT NULL,
	owner_id BIGINT REFERENCES operator(id)
);
CREATE TABLE product
(
	id BIGSERIAL PRIMARY KEY,
	name TEXT NOT NULL,
	description TEXT,
	creation TIMESTAMP NOT NULL,
	is_active BOOLEAN,
	owner_id BIGINT REFERENCES operator(id)
);
CREATE TABLE note_product
(
	note_id  BIGINT REFERENCES note(id),
	product_id BIGINT REFERENCES product(id)
);
CREATE TABLE lead
(
	id BIGSERIAL PRIMARY KEY,
	name TEXT NOT NULL,
	mail TEXT,
	phone TEXT,
	address TEXT,
	birth DATE,
	creation TIMESTAMP NOT NULL,
	observation TEXT,
	is_active BOOLEAN,
	owner_id  BIGINT REFERENCES operator(id) NOT NULL,
	source_id BIGINT REFERENCES source(id) NOT NULL,
	status_id BIGINT REFERENCES status(id) NOT NULL,
	parent_id BIGINT REFERENCES lead(id)
);
CREATE TABLE deal
(
	id BIGSERIAL PRIMARY KEY,
	sale_date TIMESTAMP NOT NULL,
	owner_id  BIGINT REFERENCES operator(id),
	lead_id BIGINT REFERENCES lead(id),
	product_id BIGINT REFERENCES product(id)
);
CREATE TABLE lead_note
(
	lead_id BIGINT REFERENCES lead(id),
	note_id BIGINT REFERENCES note(id)
);
CREATE TABLE interest_lead
(
	creation TIMESTAMP NOT NULL,
	interest_id BIGINT REFERENCES interest(id),
	lead_id BIGINT REFERENCES lead(id)
);