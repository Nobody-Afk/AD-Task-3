CREATE TABLE IF NOT EXISTS tasks (
    id uuid NOT NULL PRIMARY KEY DEFAULT gen_random_uuid(),
    title varchar(225) NOT NULL,
    description text,
    status varchar(50) DEFAULT 'pending',
    project_id uuid REFERENCES projects(id),
    assigned_user_id uuid REFERENCES users(id),
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP
);
