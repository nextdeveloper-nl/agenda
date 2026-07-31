-- PostgreSQL
-- Individual task items that can have subtasks

CREATE TABLE agenda_task_items (
    id              integer NOT NULL DEFAULT nextval('agenda_task_items_id_seq'::regclass),
    uuid            uuid NOT NULL DEFAULT gen_random_uuid(),
    agenda_task_id  bigint NOT NULL, -- Reference to the task group this item belongs to
    google_id       text, -- Google Task ID for syncing with Google Tasks
    title           text NOT NULL, -- Title of the task item
    notes           text, -- Detailed notes for the task item
    status          text DEFAULT 'needsAction'::text, -- Status of the task (needsAction, completed)
    due             timestamp with time zone,
    completed_at    timestamp with time zone, -- Timestamp when the task was completed
    priority        integer DEFAULT 0, -- Priority level of the task item (higher number means higher priority)
    position        integer DEFAULT 0, -- Position of the task item in the list for ordering
    iam_user_id     bigint, -- User who created or owns the task item
    iam_account_id  bigint, -- Account associated with the task item
    created_at      timestamp with time zone NOT NULL DEFAULT now(),
    updated_at      timestamp with time zone NOT NULL DEFAULT now(),
    deleted_at      timestamp with time zone,
    CONSTRAINT agenda_task_items_pkey PRIMARY KEY (id)
);
