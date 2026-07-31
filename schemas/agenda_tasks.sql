-- PostgreSQL
-- Task groups for organizing todo items (like "Work", "Personal")

CREATE TABLE agenda_tasks (
    id              integer NOT NULL DEFAULT nextval('agenda_tasks_id_seq'::regclass),
    uuid            uuid NOT NULL DEFAULT gen_random_uuid(),
    name            text NOT NULL, -- Name of the task group
    description     text, -- Detailed description of the task group
    color           text, -- Color associated with the task group for UI display
    google_id       text, -- Google Task List ID for syncing with Google Tasks
    is_default      boolean DEFAULT false, -- Indicates whether this is the default task group
    object_type     text, -- Type of object this task group is associated with (for polymorphic relationships)
    object_id       integer, -- ID of the object this task group is associated with (for polymorphic relationships)
    iam_user_id     bigint, -- User who created or owns the task group
    iam_account_id  bigint, -- Account associated with the task group
    created_at      timestamp with time zone NOT NULL DEFAULT now(),
    updated_at      timestamp with time zone NOT NULL DEFAULT now(),
    deleted_at      timestamp with time zone,
    CONSTRAINT agenda_tasks_pkey PRIMARY KEY (id)
);
