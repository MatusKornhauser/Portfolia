CREATE TABLE files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    portfolio_id INT,
    name VARCHAR(255) NOT NULL,
    path VARCHAR(255) NOT NULL,
    size INT,
    FOREIGN KEY (portfolio_id) REFERENCES portfolios(id)
);
