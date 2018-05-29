-- Assignment 8: Full SQL Statements
-- Benjamin Rubin 2406404158
-- ID: benjamfr

-- Football Schedule
-- 1
CREATE OR REPLACE VIEW football_schedule AS
	SELECT day.day, schedule.date, home.name AS home, away.name AS away, venues.name AS venue
	FROM schedule
	JOIN day
		ON schedule.day_id = day.id
	INNER JOIN teams home
		ON schedule.home_id = home.id 
	INNER JOIN teams away
		ON schedule.away_id = away.id
	JOIN venues
	ON venues.id = schedule.venue_id
	ORDER BY date;

-- 2
INSERT INTO venues (name)
VALUES ('Folsom Field');

INSERT INTO schedule (date, day_id, home_id, away_id, venue_id)
VALUES ('2017-11-18', 7, 9, 4, 10) ,('2017-11-18', 7, 10, 7, 8);

-- 3
UPDATE schedule
SET date = '2017-11-11', away_id = 1
WHERE id = 20;

-- 4
DELETE
FROM schedule
WHERE id = 21;

-- 5
SELECT venues.id AS venue_id, venues.name AS venue, COUNT(schedule.venue_id) AS game_count
FROM venues
JOIN
schedule
ON schedule.venue_id = venues.id
GROUP BY venues.name
ORDER BY venues.id;