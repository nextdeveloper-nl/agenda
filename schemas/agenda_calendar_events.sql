-- PostgreSQL

CREATE TABLE agenda_calendar_events (
    id                   bigint NOT NULL DEFAULT nextval('agenda_calendar_events_id_seq'::regclass),
    uuid                 uuid DEFAULT gen_random_uuid(),
    title                text,
    description          text, -- [ui:markdown]
    location             text,
    guests               bigint[],
    starts_at            timestamp with time zone NOT NULL,
    ends_at              timestamp with time zone NOT NULL,
    iam_user_id          bigint,
    iam_account_id       bigint,
    agenda_calendar_id   bigint NOT NULL,
    is_out_of_office     boolean DEFAULT false,
    is_appointment_slot  boolean DEFAULT false,
    tags                 text[],
    created_at           timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at           timestamp with time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at           timestamp with time zone,
    timezone             text,
    is_all_day           boolean DEFAULT false,
    status               text,
    meeting_link         text,
    data                 json,
    external_event_id    text,
    CONSTRAINT agenda_calendar_items_pkey PRIMARY KEY (id)
);
