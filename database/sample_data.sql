START TRANSACTION;

INSERT INTO `categories` (`name`) VALUES ('Information Technology'), ('Marketing'), ('Human Resources'), ('Finance');
INSERT INTO `departments` (`name`) VALUES ('Staff Selection Commission (SSC)'), ('Union Public Service Commission (UPSC)'), ('Indian Railways'), ('State Bank of India (SBI)');
INSERT INTO `qualifications` (`name`) VALUES ('10th Pass'), ('12th Pass'), ('Graduate'), ('Post Graduate');

-- Password for all is 'password123'
INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `is_sarkari_hr`, `status`) VALUES
(1, 'Admin User', 'admin@example.com', '$2y$10$w/yGqG.d/aI25a1Xk1gTj.oF6B.M5zXp8E5Z.vC.yqI.Qc6z3iG3u', 'admin', 1, 'active'),
(2, 'HR Manager', 'hr@example.com', '$2y$10$w/yGqG.d/aI25a1Xk1gTj.oF6B.M5zXp8E5Z.vC.yqI.Qc6z3iG3u', 'hr', 0, 'active'),
(3, 'Sarkari HR', 'sarkari.hr@example.com', '$2y$10$w/yGqG.d/aI25a1Xk1gTj.oF6B.M5zXp8E5Z.vC.yqI.Qc6z3iG3u', 'hr', 1, 'active'),
(4, 'John Doe', 'user@example.com', '$2y$10$w/yGqG.d/aI25a1Xk1gTj.oF6B.M5zXp8E5Z.vC.yqI.Qc6z3iG3u', 'user', 'active');

INSERT INTO `private_jobs` (`hr_id`, `title`, `description`, `category_id`, `location`, `expiry_date`) VALUES
(2, 'Senior PHP Developer', 'We are looking for an experienced PHP developer to join our team. Must have 5+ years of experience with modern PHP frameworks.', 1, 'Remote', '2024-12-31');

INSERT INTO `sarkari_notifications` (`posted_by`, `type`, `title`, `description`, `department_id`, `qualification_id`, `official_link`) VALUES
(3, 'job', 'Combined Graduate Level (CGL) Examination 2024', 'SSC CGL notification for various Group B and Group C posts.', 1, 3, 'https://ssc.nic.in/'),
(1, 'result', 'Final Result for Constable (GD) in CAPFs', 'The final result for the Constable GD exam has been declared.', 1);

COMMIT;
