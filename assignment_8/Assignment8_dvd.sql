-- Assignment 8: Full SQL Statements
-- Benjamin Rubin 2406404158
-- ID: benjamfr

-- DVD
-- 1
CREATE OR REPLACE VIEW dramas AS
	SELECT dvd_titles.dvd_title_id, dvd_titles.title, dvd_titles.release_date, dvd_titles.award, formats.format, genres.genre, labels.label, ratings.rating, sounds.sound
    FROM dvd_titles
    JOIN formats
    ON dvd_titles.format_id = formats.format_id
    JOIN genres
    ON dvd_titles.genre_id = genres.genre_id
    JOIN labels
    ON dvd_titles.label_id = labels.label_id
    JOIN ratings
    ON dvd_titles.rating_id = ratings.rating_id
    JOIN sounds
    ON dvd_titles.sound_id = sounds.sound_id
    WHERE dvd_titles.release_date IS NOT NULL
    AND dvd_titles.genre_id = 9;
    
-- 2
INSERT INTO dvd_titles (title, release_date, award, format_id, genre_id, label_id, rating_id, sound_id)
values ('The Godfather', '1972-03-24', '45th Academy Award for Best Picture', 2, 9, 92, 7, 4);

-- 3
UPDATE dvd_titles
SET label_id = 24, genre_id = 7, format_id = 4
WHERE dvd_title_id = 5131;

-- 4
DELETE 
FROM dvd_titles
WHERE dvd_titles.title = 'Major League 3: Back To The Minors';

-- 5
SELECT MAX(CHAR_LENGTH(dvd_titles.title)) AS longest_title, MIN(CHAR_LENGTH(dvd_titles.title)) AS shortest_title
FROM dvd_titles;

-- 6
SELECT genres.genre_id, genres.genre, COUNT(dvd_titles.genre_id) AS dvd_count
FROM genres
JOIN dvd_titles
ON dvd_titles.genre_id = genres.genre_id
GROUP BY (genres.genre);