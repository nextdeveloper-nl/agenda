-- PostgreSQL

CREATE TABLE agenda_calendars (
    id                bigint NOT NULL DEFAULT nextval('agenda_calendars_id_seq'::regclass),
    uuid              uuid DEFAULT gen_random_uuid(),
    name              text NOT NULL,
    description       text, -- [ui:markdown]
    iam_account_id    bigint,
    iam_user_id       bigint,
    object_id         bigint,
    object_type       text,
    timezone          text NOT NULL,
    is_public         boolean DEFAULT false,
    tags              text[] NOT NULL DEFAULT '{}'::text[],
    color             text,
    created_at        timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at        timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at        timestamp with time zone,
    calendar_key      text, -- The calendar Key used for importing a specific calendar, e.g., Google Calendar. The default value is "primary".
    source            text,
    sync_enabled      boolean DEFAULT true,
    last_sync_status  text,
    last_sync_at      timestamp with time zone,
    sync_start_date   date,
    CONSTRAINT agenda_calendars_pkey PRIMARY KEY (id)
);
