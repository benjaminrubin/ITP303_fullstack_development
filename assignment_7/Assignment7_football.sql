-- Assignment 7: SELECT SQL Statements
-- Benjamin Rubin 2406404158
-- ID: benjamfr

-- Football Schedule
-- 1
SELECT schedule.date, venues.name AS venue
FROM schedule
JOIN venues
ON schedule.venue_id = venues.id
ORDER BY date;

-- 2
SELECT schedule.date, day.day, venues.name AS venue
FROM schedule
JOIN day
ON schedule.day_id = day.id
JOIN venues
ON schedule.venue_id = venues.id
WHERE MONTH(schedule.date) = 10
ORDER BY date DESC;

-- 3
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