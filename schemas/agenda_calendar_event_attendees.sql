-- PostgreSQL

CREATE TABLE agenda_calendar_event_attendees (
    id                        integer NOT NULL DEFAULT nextval('agenda_calendar_event_attendees_id_seq'::regclass),
    uuid                      uuid DEFAULT gen_random_uuid(),
    name                      character varying,
    email                     character varying,
    response_status           character varying,
    is_organizer              boolean DEFAULT false,
    is_optional               boolean DEFAULT false,
    comment                   text,
    agenda_calendar_event_id  bigint NOT NULL,
    iam_user_id               bigint,
    iam_account_id            bigint,
    created_at                timestamp with time zone DEFAULT now(),
    updated_at                timestamp with time zone DEFAULT now(),
    deleted_at                timestamp with time zone,
    CONSTRAINT agenda_calendar_event_attendees_pkey PRIMARY KEY (id),
    CONSTRAINT agenda_calendar_event_attendees_uuid_key UNIQUE (uuid)
);
