-- PostgreSQL

CREATE TABLE agenda_contacts (
    id                      bigint NOT NULL DEFAULT nextval('agenda_contacts_id_seq'::regclass),
    uuid                    uuid DEFAULT gen_random_uuid(),
    name                    text,
    surname                 text,
    email                   text,
    home_phone              text,
    cell_phone              text,
    fax_number              text,
    email_work              text,
    website                 text,
    notes                   text,
    description             text, -- [ui:markdown]
    agenda_address_book_id  bigint NOT NULL,
    iam_user_id             bigint,
    iam_account_id          bigint,
    created_at              timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at              timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at              timestamp with time zone,
    CONSTRAINT agenda_contacts_pkey PRIMARY KEY (id)
);
