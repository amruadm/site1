--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.2
-- Dumped by pg_dump version 9.6.2

-- Started on 2017-08-29 01:28:15

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 2186 (class 1262 OID 12401)
-- Dependencies: 2185
-- Name: postgres; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON DATABASE postgres IS 'default administrative connection database';


--
-- TOC entry 2 (class 3079 OID 12387)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2188 (class 0 OID 0)
-- Dependencies: 2
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- TOC entry 1 (class 3079 OID 16384)
-- Name: adminpack; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS adminpack WITH SCHEMA pg_catalog;


--
-- TOC entry 2189 (class 0 OID 0)
-- Dependencies: 1
-- Name: EXTENSION adminpack; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION adminpack IS 'administrative functions for PostgreSQL';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 192 (class 1259 OID 16446)
-- Name: entities; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE entities (
    id bigint NOT NULL,
    world_id bigint NOT NULL,
    uclass character varying NOT NULL,
    "worldX" double precision NOT NULL,
    "worldY" double precision NOT NULL
);


ALTER TABLE entities OWNER TO postgres;

--
-- TOC entry 2190 (class 0 OID 0)
-- Dependencies: 192
-- Name: COLUMN entities.world_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN entities.world_id IS 'entity place';


--
-- TOC entry 2191 (class 0 OID 0)
-- Dependencies: 192
-- Name: COLUMN entities.uclass; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN entities.uclass IS 'entity class reference';


--
-- TOC entry 2192 (class 0 OID 0)
-- Dependencies: 192
-- Name: COLUMN entities."worldX"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN entities."worldX" IS 'x position';


--
-- TOC entry 2193 (class 0 OID 0)
-- Dependencies: 192
-- Name: COLUMN entities."worldY"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN entities."worldY" IS 'y position';


--
-- TOC entry 189 (class 1259 OID 16403)
-- Name: players; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE players (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    name character varying(16) NOT NULL,
    creation_date timestamp without time zone DEFAULT now() NOT NULL,
    world_id bigint
);


ALTER TABLE players OWNER TO postgres;

--
-- TOC entry 2194 (class 0 OID 0)
-- Dependencies: 189
-- Name: COLUMN players.world_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN players.world_id IS 'current place of player';


--
-- TOC entry 188 (class 1259 OID 16401)
-- Name: players_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE players_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE players_id_seq OWNER TO postgres;

--
-- TOC entry 2195 (class 0 OID 0)
-- Dependencies: 188
-- Name: players_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE players_id_seq OWNED BY players.id;


--
-- TOC entry 194 (class 1259 OID 24580)
-- Name: post; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE post (
    id integer NOT NULL,
    title character varying(128) DEFAULT 'Empty'::character varying NOT NULL,
    added_by bigint,
    added_date timestamp without time zone DEFAULT now() NOT NULL,
    body text
);


ALTER TABLE post OWNER TO postgres;

--
-- TOC entry 2196 (class 0 OID 0)
-- Dependencies: 194
-- Name: COLUMN post.added_by; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN post.added_by IS 'id from users';


--
-- TOC entry 2197 (class 0 OID 0)
-- Dependencies: 194
-- Name: COLUMN post.added_date; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN post.added_date IS 'creating date';


--
-- TOC entry 193 (class 1259 OID 24578)
-- Name: post_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE post_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE post_id_seq OWNER TO postgres;

--
-- TOC entry 2198 (class 0 OID 0)
-- Dependencies: 193
-- Name: post_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE post_id_seq OWNED BY post.id;


--
-- TOC entry 187 (class 1259 OID 16395)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE users (
    id bigint NOT NULL,
    login character varying(16) NOT NULL,
    pass character varying(64) NOT NULL,
    reg_date timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE users OWNER TO postgres;

--
-- TOC entry 186 (class 1259 OID 16393)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE users_id_seq OWNER TO postgres;

--
-- TOC entry 2199 (class 0 OID 0)
-- Dependencies: 186
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- TOC entry 191 (class 1259 OID 16422)
-- Name: worlds; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE worlds (
    id bigint NOT NULL,
    dedicated_ip character varying,
    dedicated_port integer,
    owner_id bigint,
    "positionX" double precision NOT NULL,
    "positionY" double precision NOT NULL
);


ALTER TABLE worlds OWNER TO postgres;

--
-- TOC entry 2200 (class 0 OID 0)
-- Dependencies: 191
-- Name: TABLE worlds; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE worlds IS 'generated worlds';


--
-- TOC entry 2201 (class 0 OID 0)
-- Dependencies: 191
-- Name: COLUMN worlds.dedicated_ip; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN worlds.dedicated_ip IS 'ip addr of dedicated server';


--
-- TOC entry 2202 (class 0 OID 0)
-- Dependencies: 191
-- Name: COLUMN worlds.owner_id; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN worlds.owner_id IS 'id from players';


--
-- TOC entry 2203 (class 0 OID 0)
-- Dependencies: 191
-- Name: COLUMN worlds."positionX"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN worlds."positionX" IS 'global x coordinate';


--
-- TOC entry 2204 (class 0 OID 0)
-- Dependencies: 191
-- Name: COLUMN worlds."positionY"; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN worlds."positionY" IS 'global Y coordinate';


--
-- TOC entry 190 (class 1259 OID 16420)
-- Name: worlds_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE worlds_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE worlds_id_seq OWNER TO postgres;

--
-- TOC entry 2205 (class 0 OID 0)
-- Dependencies: 190
-- Name: worlds_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE worlds_id_seq OWNED BY worlds.id;


--
-- TOC entry 2029 (class 2604 OID 16406)
-- Name: players id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY players ALTER COLUMN id SET DEFAULT nextval('players_id_seq'::regclass);


--
-- TOC entry 2032 (class 2604 OID 24583)
-- Name: post id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY post ALTER COLUMN id SET DEFAULT nextval('post_id_seq'::regclass);


--
-- TOC entry 2027 (class 2604 OID 16398)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- TOC entry 2031 (class 2604 OID 16431)
-- Name: worlds id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY worlds ALTER COLUMN id SET DEFAULT nextval('worlds_id_seq'::regclass);


--
-- TOC entry 2178 (class 0 OID 16446)
-- Dependencies: 192
-- Data for Name: entities; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY entities (id, world_id, uclass, "worldX", "worldY") FROM stdin;
\.


--
-- TOC entry 2175 (class 0 OID 16403)
-- Dependencies: 189
-- Data for Name: players; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY players (id, user_id, name, creation_date, world_id) FROM stdin;
\.


--
-- TOC entry 2206 (class 0 OID 0)
-- Dependencies: 188
-- Name: players_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('players_id_seq', 1, false);


--
-- TOC entry 2180 (class 0 OID 24580)
-- Dependencies: 194
-- Data for Name: post; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY post (id, title, added_by, added_date, body) FROM stdin;
\.


--
-- TOC entry 2207 (class 0 OID 0)
-- Dependencies: 193
-- Name: post_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('post_id_seq', 1, false);


--
-- TOC entry 2173 (class 0 OID 16395)
-- Dependencies: 187
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY users (id, login, pass, reg_date) FROM stdin;
7	lalka	$2y$13$XlmDu1GoWW7Ps/Dj8V.tJ.lh3HKgQq.VFSS8tXB9MdnVI2eSBpxqq	2017-08-26 15:18:52
11	Lalka	$2y$13$kpKCJAJoce2iGXETUqoyLexBSNsFvAKB8BUg3k1rCM6ix/eMJ/7NC	2017-08-28 12:08:58
\.


--
-- TOC entry 2208 (class 0 OID 0)
-- Dependencies: 186
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('users_id_seq', 11, true);


--
-- TOC entry 2177 (class 0 OID 16422)
-- Dependencies: 191
-- Data for Name: worlds; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY worlds (id, dedicated_ip, dedicated_port, owner_id, "positionX", "positionY") FROM stdin;
\.


--
-- TOC entry 2209 (class 0 OID 0)
-- Dependencies: 190
-- Name: worlds_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('worlds_id_seq', 1, false);


--
-- TOC entry 2046 (class 2606 OID 16450)
-- Name: entities entities_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY entities
    ADD CONSTRAINT entities_pkey PRIMARY KEY (id);


--
-- TOC entry 2042 (class 2606 OID 16408)
-- Name: players players_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY players
    ADD CONSTRAINT players_pkey PRIMARY KEY (id);


--
-- TOC entry 2050 (class 2606 OID 24585)
-- Name: post post_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY post
    ADD CONSTRAINT post_pkey PRIMARY KEY (id);


--
-- TOC entry 2036 (class 2606 OID 24577)
-- Name: users users_login_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_login_key UNIQUE (login);


--
-- TOC entry 2038 (class 2606 OID 16400)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 2044 (class 2606 OID 16433)
-- Name: worlds worlds_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY worlds
    ADD CONSTRAINT worlds_pkey PRIMARY KEY (id);


--
-- TOC entry 2047 (class 1259 OID 16459)
-- Name: fki_entities_wid_fkey; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_entities_wid_fkey ON entities USING btree (world_id);


--
-- TOC entry 2039 (class 1259 OID 16465)
-- Name: fki_players_wid_fkey; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_players_wid_fkey ON players USING btree (world_id);


--
-- TOC entry 2040 (class 1259 OID 16419)
-- Name: fki_user_id_fkey; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX fki_user_id_fkey ON players USING btree (user_id);


--
-- TOC entry 2048 (class 1259 OID 24604)
-- Name: fki_ф; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX "fki_ф" ON post USING btree (added_by);


--
-- TOC entry 2053 (class 2606 OID 16454)
-- Name: entities entities_wid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY entities
    ADD CONSTRAINT entities_wid_fkey FOREIGN KEY (world_id) REFERENCES worlds(id);


--
-- TOC entry 2052 (class 2606 OID 16460)
-- Name: players players_wid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY players
    ADD CONSTRAINT players_wid_fkey FOREIGN KEY (world_id) REFERENCES worlds(id);


--
-- TOC entry 2054 (class 2606 OID 24599)
-- Name: post post_added_by_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY post
    ADD CONSTRAINT post_added_by_fkey FOREIGN KEY (added_by) REFERENCES users(id);


--
-- TOC entry 2051 (class 2606 OID 16414)
-- Name: players user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY players
    ADD CONSTRAINT user_id_fkey FOREIGN KEY (user_id) REFERENCES users(id);


-- Completed on 2017-08-29 01:28:15

--
-- PostgreSQL database dump complete
--

