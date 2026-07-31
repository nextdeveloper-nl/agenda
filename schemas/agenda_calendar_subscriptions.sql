-- PostgreSQL
-- By default if the record exists, user can see but cannot write

CREATE TABLE agenda_calendar_subscriptions (
    agenda_calendar_id  bigint NOT NULL,
    iam_user_id         bigint NOT NULL,
    can_write           boolean DEFAULT false
);
