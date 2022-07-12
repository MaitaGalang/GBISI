--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- Name: pgcrypto; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA public;


--
-- Name: EXTENSION pgcrypto; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: company; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE public.company (
    id integer NOT NULL,
    date_created timestamp without time zone DEFAULT now(),
    created_by character varying,
    modified_at timestamp without time zone,
    is_active smallint DEFAULT 1,
    deleted_at timestamp without time zone,
    code character varying,
    name character varying
);


ALTER TABLE public.company OWNER TO postgres;

--
-- Name: company_created_by_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.company_created_by_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.company_created_by_seq OWNER TO postgres;

--
-- Name: company_created_by_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.company_created_by_seq OWNED BY public.company.created_by;


--
-- Name: company_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.company_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.company_id_seq OWNER TO postgres;

--
-- Name: company_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.company_id_seq OWNED BY public.company.id;


--
-- Name: customers; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE public.customers (
    id integer NOT NULL,
    date_created timestamp without time zone DEFAULT now() NOT NULL,
    created_by character varying,
    modified_at timestamp without time zone,
    is_active smallint DEFAULT 1 NOT NULL,
    deleted_at timestamp without time zone,
    company_id integer,
    cbb_code character varying,
    ax_code character varying,
    name character varying,
    search_name character varying,
    address character varying,
    store_type character varying,
    tin character varying,
    payment_terms character varying,
    price_code character varying
);


ALTER TABLE public.customers OWNER TO postgres;

--
-- Name: customers_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.customers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.customers_id_seq OWNER TO postgres;

--
-- Name: customers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.customers_id_seq OWNED BY public.customers.id;


--
-- Name: invoice_dtl_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.invoice_dtl_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.invoice_dtl_id_seq OWNER TO postgres;

--
-- Name: invoice_dtl; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE public.invoice_dtl (
    id integer DEFAULT nextval('public.invoice_dtl_id_seq'::regclass) NOT NULL,
    date_created timestamp without time zone DEFAULT now() NOT NULL,
    created_by character varying,
    modified_at timestamp without time zone,
    is_active smallint DEFAULT 1 NOT NULL,
    deleted_at timestamp without time zone,
    company_id integer,
    transaction_no character varying,
    items_id integer,
    cbb_code character varying,
    ax_code character varying,
    description character varying,
    uom character varying,
    quantity integer DEFAULT 0,
    price double precision DEFAULT 0,
    amount double precision NOT NULL
);


ALTER TABLE public.invoice_dtl OWNER TO postgres;

--
-- Name: invoice_hdr_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.invoice_hdr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.invoice_hdr_id_seq OWNER TO postgres;

--
-- Name: invoice_hdr; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE public.invoice_hdr (
    id integer DEFAULT nextval('public.invoice_hdr_id_seq'::regclass) NOT NULL,
    date_created timestamp without time zone DEFAULT now() NOT NULL,
    created_by character varying,
    modified_at timestamp without time zone,
    is_active smallint DEFAULT 1 NOT NULL,
    deleted_at timestamp without time zone,
    company_id integer,
    transaction_no character varying NOT NULL,
    invoice_series character varying DEFAULT 0 NOT NULL,
    customer_id integer NOT NULL,
    customer_cbb_code character varying NOT NULL,
    customer_ax_code character varying NOT NULL,
    invoice_date date NOT NULL,
    remarks character varying(255),
    gross double precision DEFAULT 0 NOT NULL,
    lprinted boolean DEFAULT false NOT NULL,
    order_no character varying,
    order_type character varying
);


ALTER TABLE public.invoice_hdr OWNER TO postgres;

--
-- Name: items; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE public.items (
    id integer NOT NULL,
    date_created timestamp without time zone DEFAULT now() NOT NULL,
    created_by character varying,
    modified_at timestamp without time zone,
    is_active smallint DEFAULT 1 NOT NULL,
    deleted_at timestamp without time zone,
    company_id integer,
    cbb_code character varying,
    ax_code character varying,
    description character varying,
    uom character varying,
    classification character varying
);


ALTER TABLE public.items OWNER TO postgres;

--
-- Name: items_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.items_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.items_id_seq OWNER TO postgres;

--
-- Name: items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.items_id_seq OWNED BY public.items.id;


--
-- Name: logfile; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE public.logfile (
    id integer NOT NULL,
    date_created timestamp without time zone DEFAULT now(),
    created_by character varying,
    machine character varying,
    "table" character varying,
    event character varying,
    remarks text,
    trans_id integer
);


ALTER TABLE public.logfile OWNER TO postgres;

--
-- Name: logfile_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.logfile_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.logfile_id_seq OWNER TO postgres;

--
-- Name: logfile_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.logfile_id_seq OWNED BY public.logfile.id;


--
-- Name: nav_menu; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE public.nav_menu (
    id integer NOT NULL,
    title character varying,
    main integer,
    main_id integer,
    icon character varying,
    url character varying,
    roles text,
    menu_order integer,
    is_active smallint DEFAULT 1 NOT NULL,
    sub_level boolean DEFAULT false NOT NULL
);


ALTER TABLE public.nav_menu OWNER TO postgres;

--
-- Name: nav_menu_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.nav_menu_id_seq
    START WITH 6
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.nav_menu_id_seq OWNER TO postgres;

--
-- Name: nav_menu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.nav_menu_id_seq OWNED BY public.nav_menu.id;


--
-- Name: parameters_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.parameters_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.parameters_id_seq OWNER TO postgres;

--
-- Name: parameters; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE public.parameters (
    id integer DEFAULT nextval('public.parameters_id_seq'::regclass) NOT NULL,
    date_created timestamp without time zone DEFAULT now() NOT NULL,
    created_by character varying,
    modified_at timestamp without time zone,
    is_active smallint DEFAULT 1 NOT NULL,
    deleted_at timestamp without time zone,
    company_id integer,
    code character varying NOT NULL,
    description character varying,
    type character varying(10) NOT NULL
);


ALTER TABLE public.parameters OWNER TO postgres;

--
-- Name: COLUMN parameters.is_active; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.parameters.is_active IS '1-active; 2-inactive; 3-deleted';


--
-- Name: COLUMN parameters.type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.parameters.type IS 'ITMCLASS - Items Classifications; ITMUOM - Item uom lists; STRTYP = Store Types; PAYTERM = payment terms';


--
-- Name: price_matrix_codes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.price_matrix_codes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.price_matrix_codes_id_seq OWNER TO postgres;

--
-- Name: price_matrix_codes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE public.price_matrix_codes (
    id integer DEFAULT nextval('public.price_matrix_codes_id_seq'::regclass) NOT NULL,
    date_created timestamp without time zone DEFAULT now() NOT NULL,
    created_by character varying,
    modified_at timestamp without time zone,
    is_active smallint DEFAULT 1 NOT NULL,
    deleted_at timestamp without time zone,
    company_id integer,
    code character varying,
    description character varying
);


ALTER TABLE public.price_matrix_codes OWNER TO postgres;

--
-- Name: price_matrix_dtl_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.price_matrix_dtl_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.price_matrix_dtl_id_seq OWNER TO postgres;

--
-- Name: price_matrix_dtl; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE public.price_matrix_dtl (
    id integer DEFAULT nextval('public.price_matrix_dtl_id_seq'::regclass) NOT NULL,
    date_created timestamp without time zone DEFAULT now() NOT NULL,
    created_by character varying,
    modified_at timestamp without time zone,
    is_active smallint DEFAULT 1 NOT NULL,
    deleted_at timestamp without time zone,
    company_id integer,
    hdr_id integer,
    items_id integer,
    cbb_code character varying,
    ax_code character varying,
    description character varying,
    uom character varying,
    price double precision DEFAULT 0
);


ALTER TABLE public.price_matrix_dtl OWNER TO postgres;

--
-- Name: price_matrix_dtlbckup_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.price_matrix_dtlbckup_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.price_matrix_dtlbckup_id_seq OWNER TO postgres;

--
-- Name: price_matrix_dtlbckup; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE public.price_matrix_dtlbckup (
    id integer DEFAULT nextval('public.price_matrix_dtlbckup_id_seq'::regclass) NOT NULL,
    date_created timestamp without time zone NOT NULL,
    created_by character varying,
    modified_at timestamp without time zone,
    is_active smallint NOT NULL,
    deleted_at timestamp without time zone,
    company_id integer,
    hdr_id integer,
    items_id integer,
    cbb_code character varying,
    ax_code character varying,
    description character varying,
    uom character varying,
    price double precision
);


ALTER TABLE public.price_matrix_dtlbckup OWNER TO postgres;

--
-- Name: price_matrix_hdr_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.price_matrix_hdr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.price_matrix_hdr_id_seq OWNER TO postgres;

--
-- Name: price_matrix_hdr; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE public.price_matrix_hdr (
    id integer DEFAULT nextval('public.price_matrix_hdr_id_seq'::regclass) NOT NULL,
    date_created timestamp without time zone DEFAULT now() NOT NULL,
    created_by character varying,
    modified_at timestamp without time zone,
    is_active smallint DEFAULT 1 NOT NULL,
    deleted_at timestamp without time zone,
    company_id integer,
    batch_no character varying,
    transaction_no character varying,
    effect_date date,
    remarks character varying,
    pm_code character varying
);


ALTER TABLE public.price_matrix_hdr OWNER TO postgres;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE public.users (
    id integer NOT NULL,
    date_created timestamp without time zone DEFAULT now() NOT NULL,
    created_by character varying,
    modified_at timestamp without time zone,
    is_active smallint DEFAULT 1 NOT NULL,
    deleted_at timestamp without time zone,
    user_id character varying(50),
    fullname character varying(255),
    password text,
    email character varying(255),
    role_id integer,
    logged_token text,
    user_image text
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_company_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_company_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_company_id_seq OWNER TO postgres;

--
-- Name: users_company; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE public.users_company (
    id integer DEFAULT nextval('public.users_company_id_seq'::regclass) NOT NULL,
    date_created timestamp without time zone DEFAULT now(),
    created_by character varying,
    modified_at timestamp without time zone,
    is_active smallint DEFAULT 1 NOT NULL,
    deleted_at timestamp without time zone,
    user_id integer,
    company_id character varying
);


ALTER TABLE public.users_company OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: users_reset_password; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE public.users_reset_password (
    id integer NOT NULL,
    date_created timestamp without time zone DEFAULT now() NOT NULL,
    created_by character varying,
    modified_at timestamp without time zone,
    is_active smallint DEFAULT 1 NOT NULL,
    deleted_at timestamp without time zone,
    email character varying(128) DEFAULT NULL::character varying,
    activation_id character varying(32) DEFAULT NULL::character varying,
    agent character varying(512) DEFAULT NULL::character varying,
    client_ip character varying(32) DEFAULT NULL::character varying
);


ALTER TABLE public.users_reset_password OWNER TO postgres;

--
-- Name: users_reset_password_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_reset_password_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_reset_password_id_seq OWNER TO postgres;

--
-- Name: users_reset_password_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_reset_password_id_seq OWNED BY public.users_reset_password.id;


--
-- Name: users_roles; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE public.users_roles (
    id integer NOT NULL,
    date_created timestamp without time zone DEFAULT now() NOT NULL,
    created_by character varying,
    modified_at timestamp without time zone,
    is_active smallint DEFAULT 1 NOT NULL,
    deleted_at timestamp without time zone,
    title character varying(50),
    description character varying(255),
    roles text
);


ALTER TABLE public.users_roles OWNER TO postgres;

--
-- Name: users_roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_roles_id_seq OWNER TO postgres;

--
-- Name: users_roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_roles_id_seq OWNED BY public.users_roles.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.company ALTER COLUMN id SET DEFAULT nextval('public.company_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.customers ALTER COLUMN id SET DEFAULT nextval('public.customers_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.items ALTER COLUMN id SET DEFAULT nextval('public.items_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.logfile ALTER COLUMN id SET DEFAULT nextval('public.logfile_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nav_menu ALTER COLUMN id SET DEFAULT nextval('public.nav_menu_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users_reset_password ALTER COLUMN id SET DEFAULT nextval('public.users_reset_password_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users_roles ALTER COLUMN id SET DEFAULT nextval('public.users_roles_id_seq'::regclass);


--
-- Data for Name: company; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.company VALUES (1, '2022-07-07 21:21:45.358', 'Admin', NULL, 1, NULL, '801', 'CAKEPLANT');
INSERT INTO public.company VALUES (2, '2022-07-07 21:22:17.174', 'Admin', NULL, 1, NULL, '802', 'FOODPLANT');
INSERT INTO public.company VALUES (3, '2022-07-07 21:22:32.604', 'Admin', NULL, 1, NULL, '803', 'BREADPLANT');


--
-- Name: company_created_by_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.company_created_by_seq', 1, false);


--
-- Name: company_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.company_id_seq', 3, true);


--
-- Data for Name: customers; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.customers VALUES (5, '2022-07-08 04:50:30', 'Admin', NULL, 1, NULL, 801, '100004', '100004', '3030 DPP VENTURES,INC.-MARVIN', 'DOMINOS-MARVIN P', '498 Shaw Boulevard Pleasant Hills Mandaluyong City NCR 1550 PHL', 'Insti', '003-058-789-010', '07D', 'SPINS013');
INSERT INTO public.customers VALUES (2, '2022-07-07 16:32:18', 'Admin', '2022-07-07 16:48:01', 3, '2022-07-07 16:50:40', 801, '125878', '12579', 'GOLDILOCKS SM CITY MANILA', 'GBSI SM Manila', 'Ground Floor SM City Manila', 'Co-Owned', '003-058-789-010', '07D', 'SPMMF');
INSERT INTO public.customers VALUES (4, '2022-07-07 16:45:29', 'Admin', NULL, 1, NULL, 801, '119656', '119656', 'SM PRIME HOLDINGS, INC.', 'SM PRIME-SM CALAMBA', 'SM City Calamba National Road Brgy. Real Calamba City Laguna 4027PHL', 'Co-Owned', '003-058-789-062', '07D', 'SPMMF');
INSERT INTO public.customers VALUES (3, '2022-07-07 16:37:23', 'Admin', NULL, 1, NULL, 801, '119654', '119654', 'SM PRIME HOLDINGS, INC.', 'SM PRIME-SM ROSARIO', 'SM City Rosario General Trias Drive Tejeros Convention Rosario Cavite 4106PHL', 'Insti', '003-058-789-059', '07D', 'SPINS013');
INSERT INTO public.customers VALUES (1, '2022-07-07 16:22:09', 'Admin', NULL, 1, NULL, 802, '100004', '100004', '3030 DPP VENTURES,INC.-MARVIN', 'DOMINOS-MARVIN P', '498 Shaw Boulevard Pleasant Hills Mandaluyong City NCR 1550 PHL', 'Insti', '007-846-162-000', '07D', 'SPINS013');


--
-- Name: customers_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.customers_id_seq', 5, true);


--
-- Data for Name: invoice_dtl; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: invoice_dtl_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.invoice_dtl_id_seq', 1, false);


--
-- Data for Name: invoice_hdr; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: invoice_hdr_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.invoice_hdr_id_seq', 1, false);


--
-- Data for Name: items; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.items VALUES (1, '2022-07-07 16:16:16', 'Admin', NULL, 1, NULL, 801, '3100047', '3100047', 'Strawberry Lush Cake', 'PCS', 'G0002');
INSERT INTO public.items VALUES (2, '2022-07-07 16:16:32', 'Admin', NULL, 1, NULL, 801, '3190007', '3190007', 'Cathedral Window Singles', 'PCS', 'G0002');
INSERT INTO public.items VALUES (3, '2022-07-07 16:16:50', 'Admin', NULL, 1, NULL, 801, '3210007', '3210007', 'Luscious Caramel 9 Round', 'PCS', 'G0002');


--
-- Name: items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.items_id_seq', 3, true);


--
-- Data for Name: logfile; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.logfile VALUES (1, '2022-07-07 16:12:44', 'Admin', '127.0.0.1', 'Login', 'Logged In', 'Admin', NULL);
INSERT INTO public.logfile VALUES (2, '2022-07-07 16:13:19', 'Admin', '127.0.0.1', 'parameters', 'Insert', 'SELECT LASTVAL() AS ins_id', 1);
INSERT INTO public.logfile VALUES (3, '2022-07-07 16:13:34', 'Admin', '127.0.0.1', 'parameters', 'Insert', 'SELECT LASTVAL() AS ins_id', 2);
INSERT INTO public.logfile VALUES (4, '2022-07-07 16:13:47', 'Admin', '127.0.0.1', 'parameters', 'Insert', 'SELECT LASTVAL() AS ins_id', 3);
INSERT INTO public.logfile VALUES (5, '2022-07-07 16:14:28', 'Admin', '127.0.0.1', 'parameters', 'Insert', 'SELECT LASTVAL() AS ins_id', 4);
INSERT INTO public.logfile VALUES (6, '2022-07-07 16:14:43', 'Admin', '127.0.0.1', 'parameters', 'Insert', 'SELECT LASTVAL() AS ins_id', 5);
INSERT INTO public.logfile VALUES (7, '2022-07-07 16:15:01', 'Admin', '127.0.0.1', 'parameters', 'Insert', 'SELECT LASTVAL() AS ins_id', 6);
INSERT INTO public.logfile VALUES (8, '2022-07-07 16:15:11', 'Admin', '127.0.0.1', 'parameters', 'Insert', 'SELECT LASTVAL() AS ins_id', 7);
INSERT INTO public.logfile VALUES (9, '2022-07-07 16:16:16', 'Admin', '127.0.0.1', 'items', 'Insert', 'SELECT LASTVAL() AS ins_id', 1);
INSERT INTO public.logfile VALUES (10, '2022-07-07 16:16:32', 'Admin', '127.0.0.1', 'items', 'Insert', 'SELECT LASTVAL() AS ins_id', 2);
INSERT INTO public.logfile VALUES (11, '2022-07-07 16:16:50', 'Admin', '127.0.0.1', 'items', 'Insert', 'SELECT LASTVAL() AS ins_id', 3);
INSERT INTO public.logfile VALUES (12, '2022-07-07 16:17:58', 'Admin', '127.0.0.1', 'parameters', 'Insert', 'SELECT LASTVAL() AS ins_id', 8);
INSERT INTO public.logfile VALUES (13, '2022-07-07 16:18:38', 'Admin', '127.0.0.1', 'parameters', 'Insert', 'SELECT LASTVAL() AS ins_id', 9);
INSERT INTO public.logfile VALUES (14, '2022-07-07 16:18:59', 'Admin', '127.0.0.1', 'parameters', 'Insert', 'SELECT LASTVAL() AS ins_id', 10);
INSERT INTO public.logfile VALUES (15, '2022-07-07 16:22:09', 'Admin', '127.0.0.1', 'customers', 'Insert', 'SELECT LASTVAL() AS ins_id', 1);
INSERT INTO public.logfile VALUES (16, '2022-07-07 16:32:18', 'Admin', '127.0.0.1', 'customers', 'Insert', 'SELECT LASTVAL() AS ins_id', 2);
INSERT INTO public.logfile VALUES (17, '2022-07-07 16:37:23', 'Admin', '127.0.0.1', 'customers', 'Insert', 'SELECT LASTVAL() AS ins_id', 3);
INSERT INTO public.logfile VALUES (18, '2022-07-07 16:45:29', 'Admin', '127.0.0.1', 'customers', 'Insert', 'INSERT INTO "customers" ("cbb_code", "ax_code", "name", "search_name", "address", "tin", "store_type", "payment_terms", "price_code", "date_created", "created_by") VALUES (''119656'', ''119656'', ''SM PRIME HOLDINGS, INC.'', ''SM PRIME-SM CALAMBA'', ''SM City Calamba National Road Brgy. Real Calamba City Laguna 4027PHL'', ''003-058-789-062'', ''Co-Owned'', ''07D'', ''SPMMF'', ''2022-07-07 16:45:29'', ''Admin'')', NULL);
INSERT INTO public.logfile VALUES (19, '2022-07-07 16:48:01', 'Admin', '127.0.0.1', 'customers', 'Update', 'UPDATE "customers" SET "cbb_code" = ''125878'', "ax_code" = ''12579'', "name" = ''GOLDILOCKS SM CITY MANILA'', "search_name" = ''GBSI SM Manila'', "address" = ''Ground Floor SM City Manila'', "tin" = ''003-058-789-010'', "store_type" = ''Co-Owned'', "payment_terms" = ''07D'', "price_code" = ''SPMMF'', "modified_at" = ''2022-07-07 16:48:01''
WHERE "id" = ''2''', 2);
INSERT INTO public.logfile VALUES (20, '2022-07-07 16:50:40', 'Admin', '127.0.0.1', 'customers', 'Delete', 'UPDATE "customers" SET "is_active" = 3, "deleted_at" = ''2022-07-07 16:50:40''
WHERE "id" = ''2''', 2);
INSERT INTO public.logfile VALUES (21, '2022-07-07 17:46:12', 'Admin', '127.0.0.1', 'Login', 'Logged In', 'Admin', NULL);
INSERT INTO public.logfile VALUES (22, '2022-07-07 17:56:06', 'Admin', '127.0.0.1', 'Login', 'Logged In', 'Admin', NULL);
INSERT INTO public.logfile VALUES (23, '2022-07-07 17:57:33', NULL, '127.0.0.1', 'Login', 'Logged In', 'Admin', NULL);
INSERT INTO public.logfile VALUES (24, '2022-07-07 17:58:09', 'Admin', '127.0.0.1', 'Login', 'Logged In', 'Admin', NULL);
INSERT INTO public.logfile VALUES (25, '2022-07-07 18:00:19', 'Admin', '127.0.0.1', 'Login', 'Logged In', 'Admin', NULL);
INSERT INTO public.logfile VALUES (26, '2022-07-07 18:01:00', 'Admin', '127.0.0.1', 'Login', 'Logged In', 'Admin', NULL);
INSERT INTO public.logfile VALUES (27, '2022-07-07 18:02:29', 'Admin', '127.0.0.1', 'Login', 'Logged In', 'Admin', NULL);
INSERT INTO public.logfile VALUES (28, '2022-07-07 18:02:39', 'Admin', '127.0.0.1', 'Login', 'Logged In', 'Admin', NULL);
INSERT INTO public.logfile VALUES (29, '2022-07-07 18:04:01', NULL, '127.0.0.1', 'Login', 'Logged In', 'Admin', NULL);
INSERT INTO public.logfile VALUES (30, '2022-07-07 18:04:15', 'Admin', '127.0.0.1', 'Login', 'Logged In', 'Admin', NULL);
INSERT INTO public.logfile VALUES (31, '2022-07-07 18:11:14', NULL, '127.0.0.1', 'Login', 'Logged In', 'Admin', NULL);
INSERT INTO public.logfile VALUES (32, '2022-07-07 18:48:05', 'Admin', '127.0.0.1', 'price_matrix_hdr', 'Insert', 'SELECT LASTVAL() AS ins_id', 1);
INSERT INTO public.logfile VALUES (33, '2022-07-07 18:48:05', 'Admin', '127.0.0.1', 'price_matrix_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 1);
INSERT INTO public.logfile VALUES (34, '2022-07-07 18:48:05', 'Admin', '127.0.0.1', 'price_matrix_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 2);
INSERT INTO public.logfile VALUES (35, '2022-07-07 18:48:05', 'Admin', '127.0.0.1', 'price_matrix_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 3);
INSERT INTO public.logfile VALUES (36, '2022-07-07 18:48:06', 'Admin', '127.0.0.1', 'price_matrix_hdr', 'Insert', 'SELECT LASTVAL() AS ins_id', 2);
INSERT INTO public.logfile VALUES (37, '2022-07-07 18:48:06', 'Admin', '127.0.0.1', 'price_matrix_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 4);
INSERT INTO public.logfile VALUES (38, '2022-07-07 18:48:06', 'Admin', '127.0.0.1', 'price_matrix_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 5);
INSERT INTO public.logfile VALUES (39, '2022-07-07 18:48:06', 'Admin', '127.0.0.1', 'price_matrix_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 6);
INSERT INTO public.logfile VALUES (40, '2022-07-08 03:35:53', NULL, '127.0.0.1', 'Login', 'Logged In', 'Admin', NULL);
INSERT INTO public.logfile VALUES (41, '2022-07-08 04:23:12', NULL, '127.0.0.1', 'Login', 'Logged In', 'Admin', NULL);
INSERT INTO public.logfile VALUES (42, '2022-07-08 04:41:53', NULL, '127.0.0.1', 'Login', 'Logged In', 'Admin', NULL);
INSERT INTO public.logfile VALUES (43, '2022-07-08 04:42:14', 'Admin', '127.0.0.1', 'Login', 'Logged In', 'Admin', NULL);
INSERT INTO public.logfile VALUES (44, '2022-07-08 04:44:37', NULL, '127.0.0.1', 'Login', 'Logged In', 'Admin', NULL);
INSERT INTO public.logfile VALUES (45, '2022-07-08 04:46:20', NULL, '127.0.0.1', 'Login', 'Logged In', 'Admin', NULL);
INSERT INTO public.logfile VALUES (46, '2022-07-08 04:50:30', 'Admin', '127.0.0.1', 'customers', 'Insert', 'INSERT INTO "customers" ("cbb_code", "ax_code", "name", "search_name", "address", "tin", "store_type", "payment_terms", "price_code", "date_created", "created_by", "company_id") VALUES (''100004'', ''100004'', ''3030 DPP VENTURES,INC.-MARVIN'', ''DOMINOS-MARVIN P'', ''498 Shaw Boulevard Pleasant Hills Mandaluyong City NCR 1550 PHL'', ''003-058-789-010'', ''Insti'', ''07D'', ''SPINS013'', ''2022-07-08 04:50:30'', ''Admin'', ''801'')', NULL);
INSERT INTO public.logfile VALUES (47, '2022-07-08 04:55:32', 'Admin', '127.0.0.1', 'invoice_hdr', 'Insert', 'SELECT LASTVAL() AS ins_id', 1);
INSERT INTO public.logfile VALUES (48, '2022-07-08 04:55:32', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 1);
INSERT INTO public.logfile VALUES (49, '2022-07-08 04:55:32', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 2);
INSERT INTO public.logfile VALUES (50, '2022-07-08 04:55:32', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 3);
INSERT INTO public.logfile VALUES (51, '2022-07-08 04:55:32', 'Admin', '127.0.0.1', 'invoice_hdr', 'Insert', 'SELECT LASTVAL() AS ins_id', 2);
INSERT INTO public.logfile VALUES (52, '2022-07-08 04:55:32', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 4);
INSERT INTO public.logfile VALUES (53, '2022-07-08 04:55:32', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 5);
INSERT INTO public.logfile VALUES (54, '2022-07-08 04:55:32', 'Admin', '127.0.0.1', 'invoice_hdr', 'Insert', 'SELECT LASTVAL() AS ins_id', 3);
INSERT INTO public.logfile VALUES (55, '2022-07-08 04:55:32', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 6);
INSERT INTO public.logfile VALUES (56, '2022-07-08 04:55:32', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 7);
INSERT INTO public.logfile VALUES (57, '2022-07-08 04:55:32', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 8);
INSERT INTO public.logfile VALUES (58, '2022-07-08 04:55:32', 'Admin', '127.0.0.1', 'invoice_hdr', 'Insert', 'SELECT LASTVAL() AS ins_id', 4);
INSERT INTO public.logfile VALUES (59, '2022-07-08 04:55:32', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 9);
INSERT INTO public.logfile VALUES (60, '2022-07-08 04:56:12', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 10);
INSERT INTO public.logfile VALUES (61, '2022-07-08 04:56:12', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 11);
INSERT INTO public.logfile VALUES (62, '2022-07-08 04:56:12', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 12);
INSERT INTO public.logfile VALUES (63, '2022-07-08 04:56:12', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 13);
INSERT INTO public.logfile VALUES (64, '2022-07-08 04:56:12', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 14);
INSERT INTO public.logfile VALUES (65, '2022-07-08 04:56:12', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 15);
INSERT INTO public.logfile VALUES (66, '2022-07-08 04:56:12', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 16);
INSERT INTO public.logfile VALUES (67, '2022-07-08 04:56:12', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 17);
INSERT INTO public.logfile VALUES (68, '2022-07-08 04:56:12', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 18);
INSERT INTO public.logfile VALUES (69, '2022-07-08 05:01:17', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 19);
INSERT INTO public.logfile VALUES (70, '2022-07-08 05:01:17', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 20);
INSERT INTO public.logfile VALUES (71, '2022-07-08 05:01:17', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 21);
INSERT INTO public.logfile VALUES (72, '2022-07-08 05:01:17', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 22);
INSERT INTO public.logfile VALUES (73, '2022-07-08 05:01:17', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 23);
INSERT INTO public.logfile VALUES (74, '2022-07-08 05:01:17', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 24);
INSERT INTO public.logfile VALUES (75, '2022-07-08 05:01:17', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 25);
INSERT INTO public.logfile VALUES (76, '2022-07-08 05:01:17', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 26);
INSERT INTO public.logfile VALUES (77, '2022-07-08 05:01:17', 'Admin', '127.0.0.1', 'invoice_dtl', 'Insert', 'SELECT LASTVAL() AS ins_id', 27);


--
-- Name: logfile_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.logfile_id_seq', 77, true);


--
-- Data for Name: nav_menu; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.nav_menu VALUES (1, 'Items Masterlist', 1, NULL, 'fas fa-fw fa-list', 'items', 'add,edit,delete,view', 2, 1, false);
INSERT INTO public.nav_menu VALUES (2, 'Price Matrix', 1, NULL, 'fas fa-fw fa-hand-holding-usd', 'price_matrix', 'add,edit,delete,view', 3, 1, false);
INSERT INTO public.nav_menu VALUES (3, 'System Settings', 1, NULL, 'fas fa-fw fa-cog', NULL, NULL, 5, 1, true);
INSERT INTO public.nav_menu VALUES (4, 'System Users', 1, 3, NULL, 'users', 'add,edit,delete,view', 1, 1, false);
INSERT INTO public.nav_menu VALUES (5, 'Roles', 1, 3, NULL, 'roles', 'add,edit,delete,view', 2, 1, false);
INSERT INTO public.nav_menu VALUES (6, 'Customers Masterlist', 1, NULL, 'fas fa-users', 'customers', 'add,edit,delete,view', 1, 1, false);
INSERT INTO public.nav_menu VALUES (7, 'Parameters', 1, NULL, 'fas fa-cogs', 'parameters', 'add,edit,delete,view', 4, 1, false);
INSERT INTO public.nav_menu VALUES (8, 'Invoice List', 2, NULL, 'fas fa-file-invoice', 'invoices', 'edit,view,cancel', 1, 1, false);
INSERT INTO public.nav_menu VALUES (9, 'Create Invoice', 2, NULL, 'fas fa-folder-plus', 'invoices/add', 'add', 2, 1, false);
INSERT INTO public.nav_menu VALUES (10, 'Upload CSV', 2, NULL, 'fas fa-file-upload', 'upload_csv', 'add', 3, 1, false);


--
-- Name: nav_menu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.nav_menu_id_seq', 6, false);


--
-- Data for Name: parameters; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.parameters VALUES (1, '2022-07-07 16:13:19', 'Admin', NULL, 1, NULL, 801, 'PCS', 'PCS', 'ITMUOM');
INSERT INTO public.parameters VALUES (2, '2022-07-07 16:13:34', 'Admin', NULL, 1, NULL, 801, 'BOX', 'BOX', 'ITMUOM');
INSERT INTO public.parameters VALUES (3, '2022-07-07 16:13:47', 'Admin', NULL, 1, NULL, 801, 'SET', 'SET', 'ITMUOM');
INSERT INTO public.parameters VALUES (4, '2022-07-07 16:14:28', 'Admin', NULL, 1, NULL, 801, 'G0001', 'BREADS AND PASTRIES', 'ITMCLASS');
INSERT INTO public.parameters VALUES (5, '2022-07-07 16:14:43', 'Admin', NULL, 1, NULL, 801, 'G0002', 'CAKES', 'ITMCLASS');
INSERT INTO public.parameters VALUES (6, '2022-07-07 16:15:01', 'Admin', NULL, 1, NULL, 801, '07D', '15 Days', 'PAYTERM');
INSERT INTO public.parameters VALUES (7, '2022-07-07 16:15:11', 'Admin', NULL, 1, NULL, 801, '15D', '15 Days', 'PAYTERM');
INSERT INTO public.parameters VALUES (8, '2022-07-07 16:17:58', 'Admin', NULL, 1, NULL, 801, 'Insti', 'Institutional', 'STRTYP');
INSERT INTO public.parameters VALUES (9, '2022-07-07 16:18:38', 'Admin', NULL, 1, NULL, 801, 'Franch-Reg', 'Franchise Regular', 'STRTYP');
INSERT INTO public.parameters VALUES (10, '2022-07-07 16:18:59', 'Admin', NULL, 1, NULL, 801, 'Co-Owned', 'Company Owned', 'STRTYP');


--
-- Name: parameters_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.parameters_id_seq', 10, true);


--
-- Data for Name: price_matrix_codes; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.price_matrix_codes VALUES (1, '2022-07-07 22:20:45.331', 'Admin', NULL, 1, NULL, 801, 'SPMMF', 'Selling Price Metro Manila Franchise');
INSERT INTO public.price_matrix_codes VALUES (2, '2022-07-07 22:21:15.966', 'Admin', NULL, 1, NULL, 801, 'SPINS013', '13 Version of Institutional Prices');


--
-- Name: price_matrix_codes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.price_matrix_codes_id_seq', 3, true);


--
-- Data for Name: price_matrix_dtl; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.price_matrix_dtl VALUES (1, '2022-07-07 18:48:05', 'Admin', NULL, 1, NULL, 801, 1, 1, '3100047', '3100047', 'Strawberry Lush Cake', 'PCS', 250.36000000000001);
INSERT INTO public.price_matrix_dtl VALUES (2, '2022-07-07 18:48:05', 'Admin', NULL, 1, NULL, 801, 1, 2, '3190007', '3190007', 'Cathedral Window Singles', 'PCS', 100.5);
INSERT INTO public.price_matrix_dtl VALUES (3, '2022-07-07 18:48:05', 'Admin', NULL, 1, NULL, 801, 1, 3, '3210007', '3210007', 'Luscious Caramel 9 Round', 'PCS', 458.57999999999998);
INSERT INTO public.price_matrix_dtl VALUES (4, '2022-07-07 18:48:06', 'Admin', NULL, 1, NULL, 801, 2, 1, '3100047', '3100047', 'Strawberry Lush Cake', 'PCS', 255);
INSERT INTO public.price_matrix_dtl VALUES (5, '2022-07-07 18:48:06', 'Admin', NULL, 1, NULL, 801, 2, 2, '3190007', '3190007', 'Cathedral Window Singles', 'PCS', 125);
INSERT INTO public.price_matrix_dtl VALUES (6, '2022-07-07 18:48:06', 'Admin', NULL, 1, NULL, 801, 2, 3, '3210007', '3210007', 'Luscious Caramel 9 Round', 'PCS', 547.21000000000004);


--
-- Name: price_matrix_dtl_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.price_matrix_dtl_id_seq', 6, true);


--
-- Data for Name: price_matrix_dtlbckup; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: price_matrix_dtlbckup_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.price_matrix_dtlbckup_id_seq', 1, false);


--
-- Data for Name: price_matrix_hdr; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.price_matrix_hdr VALUES (1, '2022-07-07 18:48:05', 'Admin', NULL, 1, NULL, 801, 'PM20220708004703', 'SPMMF20220708004703', '2022-07-29', 'Test Only', 'SPMMF');
INSERT INTO public.price_matrix_hdr VALUES (2, '2022-07-07 18:48:06', 'Admin', NULL, 1, NULL, 801, 'PM20220708004703', 'SPINS01320220708004703', '2022-07-29', 'Test Only', 'SPINS013');


--
-- Name: price_matrix_hdr_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.price_matrix_hdr_id_seq', 2, true);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.users VALUES (1, '2022-07-01 11:01:23.68', 'Admin', '2022-07-01 15:22:56', 1, NULL, 'Admin', 'Administrator Goldi', '$2a$08$os3Bv7PbTno5/p8h5sFKYeQ1cpgWGXe5/Lgt3Nyzuwu3hkM4zoOjm', 'maita.galang@gmail.com', 1, NULL, NULL);


--
-- Data for Name: users_company; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.users_company VALUES (1, '2022-07-07 23:55:17.128', 'Admin', NULL, 1, NULL, 1, '801');
INSERT INTO public.users_company VALUES (2, '2022-07-08 00:03:39.227', 'Admin', NULL, 1, NULL, 1, '802');
INSERT INTO public.users_company VALUES (3, '2022-07-08 00:03:50.8', 'Admin', NULL, 1, NULL, 1, '803');


--
-- Name: users_company_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_company_id_seq', 3, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 1, false);


--
-- Data for Name: users_reset_password; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: users_reset_password_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_reset_password_id_seq', 1, false);


--
-- Data for Name: users_roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.users_roles VALUES (1, '2022-07-01 11:18:51.718', 'Admin', '2022-07-04 17:44:05', 1, NULL, 'Administrator', 'Admin all access', '[{"id":"6","main_id":0,"access":["add","edit","delete","view"]},{"id":"4","main_id":"3","access":["add","edit","delete","view"]},{"id":"5","main_id":"3","access":["add","edit","delete","view"]},{"id":"1","main_id":0,"access":["add","edit","delete","view"]},{"id":"2","main_id":0,"access":["add","edit","delete","view"]},{"id":"7","main_id":0,"access":["add","edit","delete","view"]},{"id":"8","main_id":0,"access":["edit","view","cancel"]},{"id":"9","main_id":0,"access":["add"]},{"id":"10","main_id":0,"access":["add"]}]');


--
-- Name: users_roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_roles_id_seq', 1, false);


--
-- Name: company_code_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.company
    ADD CONSTRAINT company_code_key UNIQUE (code);


--
-- Name: company_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.company
    ADD CONSTRAINT company_pkey PRIMARY KEY (id);


--
-- Name: customers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.customers
    ADD CONSTRAINT customers_pkey PRIMARY KEY (id);


--
-- Name: invoice_hdr_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.invoice_hdr
    ADD CONSTRAINT invoice_hdr_pkey PRIMARY KEY (id);


--
-- Name: items_ax_code_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.items
    ADD CONSTRAINT items_ax_code_key UNIQUE (ax_code);


--
-- Name: items_cbb_code_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.items
    ADD CONSTRAINT items_cbb_code_key UNIQUE (cbb_code);


--
-- Name: items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.items
    ADD CONSTRAINT items_pkey PRIMARY KEY (id);


--
-- Name: logfile_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.logfile
    ADD CONSTRAINT logfile_pkey PRIMARY KEY (id);


--
-- Name: nav_menu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.nav_menu
    ADD CONSTRAINT nav_menu_pkey PRIMARY KEY (id);


--
-- Name: parameters_cbb_code_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.parameters
    ADD CONSTRAINT parameters_cbb_code_key UNIQUE (code);


--
-- Name: parameters_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.parameters
    ADD CONSTRAINT parameters_pkey PRIMARY KEY (id);


--
-- Name: price_matrix_codes_cbb_code_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.price_matrix_codes
    ADD CONSTRAINT price_matrix_codes_cbb_code_key UNIQUE (code);


--
-- Name: price_matrix_codes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.price_matrix_codes
    ADD CONSTRAINT price_matrix_codes_pkey PRIMARY KEY (id);


--
-- Name: price_matrix_dtl_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.price_matrix_dtl
    ADD CONSTRAINT price_matrix_dtl_pkey PRIMARY KEY (id);


--
-- Name: price_matrix_dtlbckup_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.price_matrix_dtlbckup
    ADD CONSTRAINT price_matrix_dtlbckup_pkey PRIMARY KEY (id);


--
-- Name: price_matrix_hdr_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.price_matrix_hdr
    ADD CONSTRAINT price_matrix_hdr_pkey PRIMARY KEY (id);


--
-- Name: price_matrix_hdr_transaction_no_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.price_matrix_hdr
    ADD CONSTRAINT price_matrix_hdr_transaction_no_key UNIQUE (transaction_no);


--
-- Name: users_company_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.users_company
    ADD CONSTRAINT users_company_pkey PRIMARY KEY (id);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: users_reset_password_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.users_reset_password
    ADD CONSTRAINT users_reset_password_pkey PRIMARY KEY (id);


--
-- Name: users_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY public.users_roles
    ADD CONSTRAINT users_roles_pkey PRIMARY KEY (id);


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

