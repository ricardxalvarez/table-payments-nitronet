--
-- PostgreSQL database dump
--

-- Dumped from database version 16.3
-- Dumped by pg_dump version 16.3

-- Started on 2024-06-26 13:33:21

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 2 (class 3079 OID 16402)
-- Name: uuid-ossp; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS "uuid-ossp" WITH SCHEMA public;


--
-- TOC entry 4800 (class 0 OID 0)
-- Dependencies: 2
-- Name: EXTENSION "uuid-ossp"; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION "uuid-ossp" IS 'generate universally unique identifiers (UUIDs)';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 216 (class 1259 OID 16413)
-- Name: payments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.payments (
    id uuid DEFAULT public.uuid_generate_v4() NOT NULL,
    created_at date DEFAULT CURRENT_DATE,
    ticket_type character varying(255),
    id_card character varying(255),
    amount_message double precision,
    amount double precision NOT NULL,
    usd_exchange double precision,
    usd_amount double precision,
    date character varying(50) NOT NULL,
    ref character varying(255) NOT NULL,
    phone character varying(255),
    dispositivo character varying(255),
    geolocalizacion character varying(255),
    nombre_zona character varying(255),
    charged boolean DEFAULT false NOT NULL
);


ALTER TABLE public.payments OWNER TO postgres;

--
-- TOC entry 4794 (class 0 OID 16413)
-- Dependencies: 216
-- Data for Name: payments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.payments (id, created_at, ticket_type, id_card, amount_message, amount, usd_exchange, usd_amount, date, ref, phone, dispositivo, geolocalizacion, nombre_zona, charged) FROM stdin;
e6f3d25b-f635-43f7-9c2e-1f53034411f8	2024-06-17	2h	12345678	100	100	1	100	2024-06-06	234123456	1234567890	hfgfds3455	Location1	Zone1	f
ff8f7993-1e0e-4f9b-910d-7639b9c00e70	2024-06-17	1s	23456789	300	300	1	300	2024-06-08	123123458	1122334455	fdgfdg45345	Location3	Zone3	f
ee6b28b2-3f64-4a9d-899b-6b5a85e6630a	2024-06-17	1m	34567890	400	400	1	400	2024-06-09	54345123459	2233445566	fdgdfgfd345345	Location4	Zone4	f
88c11c2f-5d0b-4ea0-9657-b2a8e9b3a27f	2024-06-17	2h	45678901	500	500	1	500	2024-06-10	890123460	3344556677	bvcbcf45345	Location5	Zone5	f
4b16c795-8b5f-4326-bf3f-1e13e3e85f39	2024-06-17	2d	56789012	600	600	1	600	2024-06-11	464123461	4455667788	tryrty546	Location6	Zone6	f
1b4f38e7-75a4-426f-ae15-8dbaf6ae5de1	2024-06-17	1s	67890123	700	700	1	700	2024-06-12	128123462	5566778899	dsfasda657787	Location7	Zone7	f
95bb1328-50e3-4d19-99f2-df762a6e3df7	2024-06-17	1m	78901234	800	800	1	800	2024-06-13	534123463	6677889900	fghfghf87676	Location8	Zone8	f
a1a3b5f1-d1c2-41b9-91da-640f6ff6f716	2024-06-17	2h	89012345	900	900	1	900	2024-06-14	786123464	7788990011	fgfgd76567	Location9	Zone9	f
fb8345e1-5b2a-4e7b-b446-972e603569d4	2024-06-17	2d	90123456	1000	1000	1	1000	2024-06-15	789123465	8899001122	asdsd123132	Location10	Zone10	f
7ae2d420-c181-437d-9f21-a12cf8f24872	2023-05-10	2h	12345678	50	50	7.5	10	2023-05-10	123456789	5551234567	abcd123132	San José	Zona Este	t
f682f5c7-529b-4774-b142-d97bc47ea220	2023-05-11	1d	87654321	30	30	7.8	15	2023-05-11	987654321	5559876543	abcd456789	Heredia	Zona Norte	f
87c2480e-27ba-4f69-a433-f50dfd9a79ca	2023-05-12	1s	11112222	20	20	7.7	14	2023-05-12	1111222233	5551111222	abcd789012	Alajuela	Zona Oeste	t
24d7b38f-73df-4026-99cf-ec556a23a09f	2023-05-13	2h	44445555	40	40	7.9	18	2023-05-13	44445555666	5554444555	abcd234567	Cartago	Zona Central	f
28563a54-8277-4018-8487-5c1badd4cdad	2023-05-14	2d	99998888	60	60	8	20	2023-05-14	99998888777	5559999888	abcd890123	Guanacaste	Zona Pacífico	t
7aca827b-7d7e-466f-9e3f-b245c7f48ffd	2023-05-15	1m	66667777	80	80	7.6	12	2023-05-15	66667777888	5556666777	abcd345678	Puntarenas	Zona Sur	f
b8b70f4d-e6b1-42b8-b7d5-4d6805fddf08	2023-05-16	2h	33334444	45	45	7.85	16	2023-05-16	33334444555	5553333444	abcd901234	Limón	Zona Caribe	t
105307eb-178b-440a-b831-9e6238d386c1	2023-05-17	1d	77776666	35	35	7.95	17	2023-05-17	77776666999	5557777666	abcd456789	San José	Zona Este	f
47ee674b-822a-40b2-8499-4af1d7bb5533	2023-05-18	1s	88889999	25	25	7.75	13	2023-05-18	88889999000	5558888999	abcd012345	Heredia	Zona Norte	t
709e645f-ae38-43a1-aad7-a53c529b23f3	2023-05-19	2h	22221111	55	55	8.1	19	2023-05-19	2221111222	5552222111	abcd567890	Alajuela	Zona Oeste	f
28d20f1b-7da1-4e7e-a5fa-47587377ae3d	2023-05-20	2d	33332222	65	65	8.2	21	2023-05-20	3332222333	5553333222	abcd678901	Cartago	Zona Central	t
da294def-3cac-420b-b981-ea9076e02acd	2023-05-21	1m	44443333	75	75	8.3	22	2023-05-21	4443333444	5554444333	abcd789012	Guanacaste	Zona Pacífico	f
5ed88661-22d7-4ddb-b2c0-059c68b49be5	2023-05-22	2h	55554444	85	85	8.4	23	2023-05-22	55554444555	5555555444	abcd890123	Puntarenas	Zona Sur	t
6c7e3402-362b-45d5-bde9-066b18ab5ab1	2023-05-23	1d	66665555	95	95	8.5	24	2023-05-23	66665555666	5556666555	abcd901234	Limón	Zona Caribe	f
bdf315f6-9765-46ba-9805-0e6c274cc01a	2023-05-24	1s	77776666	105	105	8.6	25	2023-05-24	77776666777	5557777666	abcd012345	San José	Zona Este	t
61386690-3e86-47c4-8a86-5cd18fdf63b6	2023-05-25	2h	88887777	115	115	8.7	26	2023-05-25	88887777888	5558888777	abcd123456	Heredia	Zona Norte	f
0c5d925b-b4ec-48ef-9370-93a7a2ed42ab	2023-05-26	2d	99998888	125	125	8.8	27	2023-05-26	99998888999	5559999888	abcd234567	Alajuela	Zona Oeste	t
4ef5643f-9395-4073-be2d-29fd7cf7f104	2023-05-27	1m	11112222	135	135	8.9	28	2023-05-27	11112222333	5551111222	abcd345678	Cartago	Zona Central	f
c24b2df8-400b-457c-ad21-16e69982c68c	2023-05-28	1s	22221111	145	145	9	29	2023-05-28	22221111222	5552222111	abcd456789	Guanacaste	Zona Pacífico	t
91aea8e0-fc52-486b-ba98-e84bfd01dd2f	2023-05-29	2h	33332222	155	155	9.1	30	2023-05-29	33332222333	5553333222	abcd567890	Puntarenas	Zona Sur	f
c63e3e90-0af7-44f9-ae9b-6de7e83597cd	2023-05-30	2d	44443333	165	165	9.2	31	2023-05-30	44443333444	5554444333	abcd678901	Limón	Zona Caribe	t
\.


--
-- TOC entry 4648 (class 2606 OID 16422)
-- Name: payments payments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_pkey PRIMARY KEY (id);


--
-- TOC entry 4650 (class 2606 OID 16424)
-- Name: payments payments_ref_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_ref_key UNIQUE (ref);


-- Completed on 2024-06-26 13:33:21

--
-- PostgreSQL database dump complete
--

