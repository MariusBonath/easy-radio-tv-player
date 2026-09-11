-- ==================================================================
--  TV-Player: Tabellen anlegen und mit Beispiel-Sendern fuellen
--  In phpMyAdmin (bplaced) einfach in die vorhandene Datenbank
--  importieren / ausfuehren.
-- ==================================================================

-- ---------- Kategorien (entspricht "genres" beim Radio) ----------
CREATE TABLE IF NOT EXISTS tv_categories (
    id   INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------- Sender (entspricht "stations" beim Radio) ------------
CREATE TABLE IF NOT EXISTS tv_channels (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(150) NOT NULL,
    category_id INT NOT NULL,
    stream_url  VARCHAR(500) NOT NULL,   -- HLS-Stream (.m3u8) oder .mp4
    web_url     VARCHAR(500),
    logo        VARCHAR(500),
    FOREIGN KEY (category_id) REFERENCES tv_categories(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------- Kategorien einfuegen ----------
INSERT INTO tv_categories (name) VALUES
('Nachrichten'),
('Doku'),
('Unterhaltung'),
('Sport'),
('Musik');

-- ---------- Sender einfuegen (mind. 6) ----------
-- Hinweis: Live-Stream-Adressen aendern sich ab und zu. Falls ein
-- Sender nicht laeuft, einfach im tv-admin die stream_url anpassen.
-- Der "Demo"-Sender (Big Buck Bunny) laeuft als HLS-Test immer.

INSERT INTO tv_channels (name, category_id, stream_url, web_url, logo) VALUES
('Al Jazeera English', 1, 'https://live-hls-web-aje.getaj.net/AJE/01.m3u8',            'https://www.aljazeera.com',      ''),
('DW Deutsch',         1, 'https://dwamdstream104.akamaized.net/hls/live/2015530/dwstream104/index.m3u8', 'https://www.dw.com', ''),
('France 24 English',  1, 'https://static.france24.com/live/F24_EN_HI_HLS/live_web.m3u8', 'https://www.france24.com',    ''),
('NASA TV',            2, 'https://ntv1.akamaihd.net/hls/live/2014075/NASA-NTV1-HLS/master.m3u8', 'https://www.nasa.gov',  ''),
('Red Bull TV',        4, 'https://rbmn-live.akamaized.net/hls/live/590964/BoRB-AT/master.m3u8', 'https://www.redbull.com/tv', ''),
('Demo TV (Testbild)', 3, 'https://test-streams.mux.dev/x36xhzz/x36xhzz.m3u8',          'https://mux.com',                '');
