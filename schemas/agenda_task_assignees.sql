-- PostgreSQL
-- Assignees for task items

CREATE TABLE agenda_task_assignees (
    id                   integer NOT NULL DEFAULT nextval('agenda_task_assignees_id_seq'::regclass),
    uuid                 uuid NOT NULL DEFAULT gen_random_uuid(),
    agenda_task_item_id  bigint NOT NULL, -- Reference to the task item this assignee is associated with
    iam_user_id          bigint NOT NULL, -- User ID of the assignee from the users table
    comment              text, -- Additional comments about the assignee
    iam_account_id       bigint, -- Account associated with the assignee
    created_at           timestamp with time zone NOT NULL DEFAULT now(),
    updated_at           timestamp with time zone NOT NULL DEFAULT now(),
    deleted_at           timestamp with time zone,
    CONSTRAINT agenda_task_assignees_pkey PRIMARY KEY (id)
);
