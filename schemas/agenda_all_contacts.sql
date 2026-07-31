-- PostgreSQL
-- VIEW (read-only; re-run this file with CREATE OR REPLACE VIEW whenever the SELECT needs to change)

CREATE OR REPLACE VIEW agenda_all_contacts AS
SELECT id,
    uuid,
    concat(name, ' ', surname, ' / ', email) AS search_string,
    iam_user_id
   FROM agenda_contacts ac;
