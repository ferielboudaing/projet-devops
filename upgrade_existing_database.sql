-- SAUVEGARDEZ nova_db AVANT D'IMPORTER CE FICHIER.
USE nova_db;
ALTER TABLE users ADD COLUMN class_id INT NULL;
ALTER TABLE subjects ADD COLUMN td_weight DECIMAL(5,4) NOT NULL DEFAULT 0.2000;
ALTER TABLE subjects ADD COLUMN tp_weight DECIMAL(5,4) NOT NULL DEFAULT 0.2000;
ALTER TABLE subjects ADD COLUMN exam_weight DECIMAL(5,4) NOT NULL DEFAULT 0.6000;
ALTER TABLE grades ADD UNIQUE KEY unique_student_subject_eval(student_id,subject_id,evaluation);
ALTER TABLE users ADD INDEX idx_user_class(class_id);
ALTER TABLE users ADD CONSTRAINT fk_user_class FOREIGN KEY(class_id) REFERENCES classes(id) ON DELETE SET NULL;
