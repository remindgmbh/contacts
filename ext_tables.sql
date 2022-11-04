CREATE TABLE tx_contacts_domain_model_contact (
    first_name varchar(255),
    last_name varchar(255),
    middle_name varchar(255),
    salutation tinyint(11) DEFAULT '0' NOT NULL,
    title varchar(255),
    phone varchar(255),
    email varchar(255),
    mobile varchar(255),
    address text,
    slug varchar(255),
    groups int(11) unsigned,
);

CREATE TABLE tx_contacts_domain_model_group (
    name varchar(255),
    description text,
    contacts int(11) unsigned,
);
