
CREATE TABLE sport(
        sport_id  int (11) Auto_increment  NOT NULL ,
        sport_nom Varchar (100) ,
        PRIMARY KEY (sport_id )
)ENGINE=InnoDB;


CREATE TABLE sp_match(
        match_id    int (11) NOT NULL ,
        match_date  Date ,
        sport_id    Int ,
        equipe_1_id Int ,
        equipe_2_id Int ,
        PRIMARY KEY (match_id )
)ENGINE=InnoDB;


CREATE TABLE cote(
        cote_id      int (11) Auto_increment  NOT NULL ,
        cote_date    Date ,
        cote_equipe1 Float(6,2) ,
        cote_equipe2 Float(6,2) ,
        cote_nul     Float(6,2) ,
        match_id     Int ,
        PRIMARY KEY (cote_id )
)ENGINE=InnoDB;


CREATE TABLE equipe(
        equipe_id  int (11) Auto_increment NOT NULL ,
        equipe_nom Varchar (100) ,
        PRIMARY KEY (equipe_id )
)ENGINE=InnoDB;

ALTER TABLE sp_match ADD CONSTRAINT FK_sp_match_sport_id FOREIGN KEY (sport_id) REFERENCES sport(sport_id);
ALTER TABLE sp_match ADD CONSTRAINT FK_sp_match_equipe_1_id FOREIGN KEY (equipe_1_id) REFERENCES equipe(equipe_id);
ALTER TABLE sp_match ADD CONSTRAINT FK_sp_match_equipe_2_id FOREIGN KEY (equipe_2_id) REFERENCES equipe(equipe_id);
ALTER TABLE cote ADD CONSTRAINT FK_cote_match_id FOREIGN KEY (match_id) REFERENCES sp_match(match_id);