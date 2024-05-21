CREATE TABLE IF NOT EXISTS up_cache
(
	cache_key   VARCHAR(255) NOT NULL PRIMARY KEY,
	cache_value TEXT         NOT NULL
);

CREATE TABLE IF NOT EXISTS up_cache_ttl
(
	cache_key VARCHAR(255) NOT NULL PRIMARY KEY,
	ttl       VARCHAR(225)
);