CREATE TABLE public.chats
(
    id bigint NOT NULL DEFAULT nextval('chats_id_seq'::regclass),
    messages_amount bigint NOT NULL,
    creator bigint NOT NULL,
    invited bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT chats_pkey PRIMARY KEY (id),
    CONSTRAINT chats_creator_foreign FOREIGN KEY (creator)
        REFERENCES public.users (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT chats_invited_foreign FOREIGN KEY (invited)
        REFERENCES public.users (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.chats
    OWNER to grupo08sa;
	
CREATE TABLE public.comments
(
    id bigint NOT NULL DEFAULT nextval('comments_id_seq'::regclass),
    content text COLLATE pg_catalog."default" NOT NULL,
    publication_id bigint NOT NULL,
    user_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT comments_pkey PRIMARY KEY (id),
    CONSTRAINT comments_publication_id_foreign FOREIGN KEY (publication_id)
        REFERENCES public.publications (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT comments_user_id_foreign FOREIGN KEY (user_id)
        REFERENCES public.users (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.comments
    OWNER to grupo08sa;
	
CREATE TABLE public.contacts
(
    user_a bigint NOT NULL,
    user_b bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT contacts_user_a_foreign FOREIGN KEY (user_a)
        REFERENCES public.users (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT contacts_user_b_foreign FOREIGN KEY (user_b)
        REFERENCES public.users (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.contacts
    OWNER to grupo08sa;
	
CREATE TABLE public.friend_requests
(
    id bigint NOT NULL DEFAULT nextval('friend_requests_id_seq'::regclass),
    requesting bigint NOT NULL,
    requested bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT friend_requests_pkey PRIMARY KEY (id),
    CONSTRAINT friend_requests_requested_foreign FOREIGN KEY (requested)
        REFERENCES public.users (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT friend_requests_requesting_foreign FOREIGN KEY (requesting)
        REFERENCES public.users (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.friend_requests
    OWNER to grupo08sa;
	
CREATE TABLE public.messages
(
    id bigint NOT NULL DEFAULT nextval('messages_id_seq'::regclass),
    sender bigint NOT NULL,
    receiver bigint NOT NULL,
    content character varying(255) COLLATE pg_catalog."default" NOT NULL,
    chat_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT messages_pkey PRIMARY KEY (id),
    CONSTRAINT messages_chat_id_foreign FOREIGN KEY (chat_id)
        REFERENCES public.chats (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT messages_receiver_foreign FOREIGN KEY (receiver)
        REFERENCES public.users (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT messages_sender_foreign FOREIGN KEY (sender)
        REFERENCES public.users (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.messages
    OWNER to grupo08sa;
	
CREATE TABLE public.migrations
(
    id integer NOT NULL DEFAULT nextval('migrations_id_seq'::regclass),
    migration character varying(255) COLLATE pg_catalog."default" NOT NULL,
    batch integer NOT NULL,
    CONSTRAINT migrations_pkey PRIMARY KEY (id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.migrations
    OWNER to grupo08sa;
	
CREATE TABLE public.publications
(
    id bigint NOT NULL DEFAULT nextval('publications_id_seq'::regclass),
    content text COLLATE pg_catalog."default" NOT NULL,
    user_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT publications_pkey PRIMARY KEY (id),
    CONSTRAINT publications_user_id_foreign FOREIGN KEY (user_id)
        REFERENCES public.users (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.publications
    OWNER to grupo08sa;
	
CREATE TABLE public.reports
(
    id bigint NOT NULL DEFAULT nextval('reports_id_seq'::regclass),
    information character varying(255) COLLATE pg_catalog."default" NOT NULL,
    value character varying(255) COLLATE pg_catalog."default" NOT NULL,
    type character varying(255) COLLATE pg_catalog."default" NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT reports_pkey PRIMARY KEY (id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.reports
    OWNER to grupo08sa;
	
CREATE TABLE public.roles
(
    id bigint NOT NULL DEFAULT nextval('roles_id_seq'::regclass),
    name character varying(255) COLLATE pg_catalog."default" NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT roles_pkey PRIMARY KEY (id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.roles
    OWNER to grupo08sa;
	
CREATE TABLE public.users
(
    id bigint NOT NULL DEFAULT nextval('users_id_seq'::regclass),
    names character varying(255) COLLATE pg_catalog."default" NOT NULL,
    last_names character varying(255) COLLATE pg_catalog."default" NOT NULL,
    phone_number character varying(255) COLLATE pg_catalog."default",
    email character varying(255) COLLATE pg_catalog."default" NOT NULL,
    birthday date,
    password character varying(255) COLLATE pg_catalog."default" NOT NULL,
    sex character(255) COLLATE pg_catalog."default" NOT NULL,
    profile_picture_path character varying(255) COLLATE pg_catalog."default" NOT NULL,
    style character varying(255) COLLATE pg_catalog."default",
    role_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT users_pkey PRIMARY KEY (id),
    CONSTRAINT users_role_id_foreign FOREIGN KEY (role_id)
        REFERENCES public.roles (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.users
    OWNER to grupo08sa;