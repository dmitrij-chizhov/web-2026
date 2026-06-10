CREATE TABLE faculty (
    id INT NOT NULL AUTO_INCREMENT,
    faculty VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE mentor (
    id INT NOT NULL AUTO_INCREMENT,
    faculty_id INT NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (faculty_id) REFERENCES faculty(id)
);

CREATE TABLE student (
    id INT NOT NULL AUTO_INCREMENT,
    faculty_id INT NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    year_apply INT NOT NULL,
    mentor_id INT,
    PRIMARY KEY (id),
    FOREIGN KEY (faculty_id) REFERENCES faculty(id),
    FOREIGN KEY (mentor_id) REFERENCES mentor(id)
);