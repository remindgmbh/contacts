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
    image int(11) unsigned DEFAULT '0' NOT NULL,
    position varchar(255),
    vcard int(11) unsigned DEFAULT '0' NOT NULL,
);

CREATE TABLE tx_contacts_domain_model_group (
    name varchar(255),
    description text,
    slug varchar(255),
    contacts int(11) unsigned,
);
