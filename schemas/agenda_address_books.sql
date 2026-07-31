-- PostgreSQL

CREATE TABLE agenda_address_books (
    id              bigint NOT NULL DEFAULT nextval('agenda_address_books_id_seq'::regclass),
    uuid            uuid DEFAULT gen_random_uuid(),
    name            text NOT NULL,
    description     text, -- [ui:markdown]
    iam_user_id     bigint NOT NULL,
    iam_account_id  bigint NOT NULL,
    created_at      timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at      timestamp with time zone,
    tags            text[],
    CONSTRAINT agenda_address_books_pkey PRIMARY KEY (id)
);
