-- Assignment 7: SELECT SQL Statements
-- Benjamin Rubin 2406404158
-- ID: benjamfr

-- DVD
-- 4
SELECT dvd_titles.title, dvd_titles.award, genres.genre, labels.label, ratings.rating
FROM dvd_titles
JOIN genres
ON dvd_titles.genre_id = genres.genre_id
JOIN labels
ON dvd_titles.label_id = labels.label_id
JOIN ratings
ON dvd_titles.rating_id = ratings.rating_id
WHERE dvd_titles.award IS NOT NULL AND dvd_titles.genre_id = 9
ORDER BY dvd_titles.award;

-- 5
SELECT dvd_titles.title, sounds.sound, labels.label, genres.genre, ratings.rating
FROM dvd_titles
JOIN sounds
ON dvd_titles.sound_id = sounds.sound_id
JOIN labels
ON dvd_titles.label_id = labels.label_id
JOIN genres
ON dvd_titles.genre_id = genres.genre_id
JOIN ratings
ON dvd_titles.rating_id = ratings.rating_id
WHERE labels.label = 'Universal' AND sounds.sound = 'DTS'
ORDER BY dvd_titles.title;

-- 6
SELECT dvd_titles.title, dvd_titles.release_date, ratings.rating, genres.genre, sounds.sound, labels.label
FROM dvd_titles
JOIN ratings
ON dvd_titles.rating_id = ratings.rating_id
JOIN sounds
ON dvd_titles.sound_id = sounds.sound_id
JOIN labels
ON dvd_titles.label_id = labels.label_id
JOIN genres
ON dvd_titles.genre_id = genres.genre_id
WHERE genres.genre = 'Sci-Fi' AND ratings.rating = 'R'
ORDER BY dvd_titles.release_date DESC;