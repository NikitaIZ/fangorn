DROP VIEW IF EXISTS view_tanks_report;
CREATE VIEW view_tanks_report as
SELECT tanks_reports.id,
    users.name as `Usuario`,
    tanks_reports.tank_id as `Nr. Tanque`,
    tanks.location as `Ubicación`,
    tanks_reports.liters as `Litros`,
    tanks_reports.created_at as `Subido`,
    tanks_reports.updated_at as `Actualizado`
FROM tanks_reports
    LEFT JOIN users ON users.id = tanks_reports.user_id
    LEFT JOIN tanks ON tanks.id = tanks_reports.tank_id;