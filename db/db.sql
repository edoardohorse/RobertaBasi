use casa_disco;

CREATE TABLE IF NOT EXISTS Genere_musicale(
    idgenere integer NOT NULL AUTO_INCREMENT,
    nome     varchar(150) NOT NULL UNIQUE,

    PRIMARY KEY(idgenere)
);

CREATE TABLE IF NOT EXISTS Cliente(
    idcliente integer NOT NULL AUTO_INCREMENT,
    nome        varchar(150) NOT NULL,
    cognome     varchar(150) NOT NULL,
    data        date NOT NULL,
    genere_musicale integer NOT NULL,

    PRIMARY KEY(idcliente),
    FOREIGN KEY(genere_musicale) REFERENCES Genere_musicale(idgenere)
);

CREATE TABLE IF NOT EXISTS Evento(
    luogo varchar(150) NOT NULL,
    data date NOT NULL,
    
    numero_ospiti integer NOT NULL,
    costo_totale   float  NOT NULL,
    tipo enum('Festa compleanno','Evento pubblico','Evento privato') NOT NULL,

    cliente integer NOT NULL,

    PRIMARY KEY(luogo, data),
    FOREIGN KEY(cliente) REFERENCES Cliente(idcliente)
);


CREATE TABLE IF NOT EXISTS Artista(
    idartista   integer NOT NULL AUTO_INCREMENT,
    nome        varchar(150) NOT NULL,
    cognome     varchar(150) NOT NULL,
    eta         integer NOT NULL,
    genere_musicale integer NOT NULL,
    costo_ingaggio  float NOT NULL,

    PRIMARY KEY(idartista),
    FOREIGN KEY(genere_musicale) REFERENCES Genere_musicale(idgenere),
    CHECK(eta > 0)
);


CREATE TABLE IF NOT EXISTS Cantante(
    idcantante  integer NOT NULL AUTO_INCREMENT,
    artista     integer NOT NULL,

    PRIMARY KEY(idcantante),
    FOREIGN KEY(artista) REFERENCES Artista(idartista)
);

CREATE TABLE IF NOT EXISTS Autore(
    idautore integer NOT NULL AUTO_INCREMENT,
    artista     integer NOT NULL,
    
    PRIMARY KEY(idautore),
    FOREIGN KEY(artista) REFERENCES Artista(idartista)
);


CREATE TABLE IF NOT EXISTS Canzone(
    idcanzone       integer NOT NULL AUTO_INCREMENT,
    titolo          varchar(200) NOT NULL,
    anno_produzione integer NOT NULL,
    costo           float NOT NULL,
    
    genere_musicale integer NOT NULL,
    autore          integer NOT NULL,

    PRIMARY KEY(idcanzone),
    FOREIGN KEY(genere_musicale) REFERENCES Genere_musicale(idgenere),
    FOREIGN KEY(autore)          REFERENCES Autore(idautore)
);


CREATE TABLE IF NOT EXISTS Album(
    idalbum     integer NOT NULL AUTO_INCREMENT,
    titolo      varchar(250) NOT NULL,
    anno        integer NOT NULL,
    descrizione varchar(400) NOT NULL,
    prezzo      float NOT NULL,

    PRIMARY KEY(idalbum)
);

CREATE TABLE IF NOT EXISTS Acquisto_album(
    album   integer NOT NULL,
    cliente integer NOT NULL,
    data    date NOT NULL,

    PRIMARY KEY (album,cliente),
    FOREIGN KEY(album) REFERENCES Album(idalbum),
    FOREIGN KEY(cliente) REFERENCES Cliente(idcliente)
);

CREATE TABLE IF NOT EXISTS Acquisto_canzone(
    canzone integer NOT NULL,
    cliente integer NOT NULL,
    data    date NOT NULL,

    PRIMARY KEY (canzone,cliente),
    FOREIGN KEY(canzone) REFERENCES Canzone(idcanzone),
    FOREIGN KEY(cliente) REFERENCES Cliente(idcliente)
);

CREATE TABLE IF NOT EXISTS Suona(
    cantante    integer NOT NULL,
    canzone integer NOT NULL,

    PRIMARY KEY(cantante, canzone),
    FOREIGN KEY(cantante)   REFERENCES Cantante(idcantante),
    FOREIGN KEY(canzone)    REFERENCES Canzone(idcanzone)
);

CREATE TABLE IF NOT EXISTS Partecipazione(
    evento_luogo varchar(150),
    evento_data date NOT NULL,    
    artista integer NOT NULL,

    PRIMARY KEY(evento_luogo, evento_data, artista),
    FOREIGN KEY(evento_luogo, evento_data) REFERENCES Evento(luogo, data),
    FOREIGN KEY(artista) REFERENCES Artista(idartista)
);

CREATE TABLE Colleziona(
    canzone integer NOT NULL,
    album   integer NOT NULL,

    PRIMARY KEY(canzone, album),
    FOREIGN KEY(canzone) REFERENCES Canzone(idcanzone),
    FOREIGN KEY(album) REFERENCES Album(idalbum)
);


