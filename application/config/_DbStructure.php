<?php
$DbStructure=array();
$DbStructure["_Files"]=array();
$DbStructure["_Files"]["file_id"]=array("Type"=>"mediumint(7) unsigned","Collation"=>"","Null"=>"NO","Key"=>"PRI","Default"=>"","Extra"=>"auto_increment","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_Files"]["file_name"]=array("Type"=>"int(11)","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_Files"]["file_type"]=array("Type"=>"char(3)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_comments"]=array();
$DbStructure["_comments"]["id_commento"]=array("Type"=>"mediumint(7) unsigned","Collation"=>"","Null"=>"NO","Key"=>"PRI","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_comments"]["id_commentato"]=array("Type"=>"mediumint(7) unsigned","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_correlations"]=array();
$DbStructure["_correlations"]["uid1"]=array("Type"=>"mediumint(7) unsigned","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_correlations"]["uid2"]=array("Type"=>"mediumint(7) unsigned","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_definitions"]=array();
$DbStructure["_definitions"]["definition_id"]=array("Type"=>"smallint(6)","Collation"=>"","Null"=>"NO","Key"=>"PRI","Default"=>"","Extra"=>"auto_increment","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_definitions"]["base_name"]=array("Type"=>"char(30)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"MUL","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_definitions"]["context"]=array("Type"=>"char(20)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_definitions"]["to_user_type"]=array("Type"=>"char(10)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_definitions"]["lang"]=array("Type"=>"char(2)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_drafts"]=array();
$DbStructure["_drafts"]["draft_id"]=array("Type"=>"mediumint(7) unsigned","Collation"=>"","Null"=>"NO","Key"=>"MUL","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_drafts"]["original_id"]=array("Type"=>"mediumint(7) unsigned","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_geoLocation"]=array();
$DbStructure["_geoLocation"]["cap"]=array("Type"=>"int(5) unsigned zerofill","Collation"=>"","Null"=>"NO","Key"=>"PRI","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_geoLocation"]["comune"]=array("Type"=>"varchar(100)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_geoLocation"]["provincia"]=array("Type"=>"varchar(2)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"PRI","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_geoLocation"]["regione"]=array("Type"=>"varchar(30)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"PRI","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_geoLocation"]["prefisso_telefonico"]=array("Type"=>"varchar(5)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_geoLocation"]["codice_fisco"]=array("Type"=>"varchar(5)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"PRI","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_item_generator"]=array();
$DbStructure["_item_generator"]["universal_id"]=array("Type"=>"mediumint(7) unsigned","Collation"=>"","Null"=>"NO","Key"=>"PRI","Default"=>"","Extra"=>"auto_increment","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_item_generator"]["creation_date"]=array("Type"=>"timestamp","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"0000-00-00 00:00:00","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_item_generator"]["last_modify"]=array("Type"=>"timestamp","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"CURRENT_TIMESTAMP","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_item_generator"]["item_status"]=array("Type"=>"enum('draft','public','to publish','private','edit','unlisted','recycle bin','confirmed','not confirmed')","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"not confirmed","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_item_generator"]["creator_id"]=array("Type"=>"mediumint(7) unsigned zerofill","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"0000000","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_item_generator"]["parent"]=array("Type"=>"mediumint(7)","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"0","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_item_long_desc"]=array();
$DbStructure["_item_long_desc"]["universal_id"]=array("Type"=>"mediumint(7)","Collation"=>"","Null"=>"NO","Key"=>"PRI","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_item_long_desc"]["long_desc"]=array("Type"=>"text","Collation"=>"utf8_general_ci","Null"=>"YES","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_item_metadata"]=array();
$DbStructure["_item_metadata"]["universal_id"]=array("Type"=>"mediumint(7) unsigned","Collation"=>"","Null"=>"NO","Key"=>"PRI","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_item_metadata"]["name_or_title"]=array("Type"=>"varchar(120)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_item_metadata"]["item_snippet"]=array("Type"=>"varchar(255)","Collation"=>"utf8_general_ci","Null"=>"YES","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_item_metadata"]["item_keywords"]=array("Type"=>"varchar(255)","Collation"=>"utf8_general_ci","Null"=>"YES","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_item_metadata"]["item_url"]=array("Type"=>"varchar(100)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_item_metadata"]["item_lang"]=array("Type"=>"enum('it','en','fr','es','de','ru')","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"it","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_item_metadata"]["foto"]=array("Type"=>"tinyint(1)","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"0","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_item_metadata"]["youtube_video"]=array("Type"=>"char(11)","Collation"=>"utf8_general_ci","Null"=>"YES","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_item_metadata"]["descrizione_foto"]=array("Type"=>"varchar(255)","Collation"=>"utf8_general_ci","Null"=>"YES","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_item_metadata"]["ordine"]=array("Type"=>"smallint(6)","Collation"=>"","Null"=>"YES","Key"=>"","Default"=>"0","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_log"]=array();
$DbStructure["_log"]["log_id"]=array("Type"=>"int(11)","Collation"=>"","Null"=>"NO","Key"=>"PRI","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_log"]["ip"]=array("Type"=>"int(11)","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_log"]["url"]=array("Type"=>"int(11)","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_log"]["post_requests"]=array("Type"=>"text","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_log"]["get_requests"]=array("Type"=>"text","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_log"]["user_id"]=array("Type"=>"mediumint(7) unsigned zerofill","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_translations"]=array();
$DbStructure["_translations"]["it"]=array("Type"=>"mediumint(7) unsigned zerofill","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_translations"]["en"]=array("Type"=>"mediumint(7) unsigned zerofill","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_translations"]["fr"]=array("Type"=>"mediumint(7) unsigned zerofill","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_translations"]["es"]=array("Type"=>"mediumint(7) unsigned zerofill","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_translations"]["de"]=array("Type"=>"mediumint(7) unsigned zerofill","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_translations"]["ru"]=array("Type"=>"mediumint(7) unsigned zerofill","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["_translations"]["jp"]=array("Type"=>"mediumint(7) unsigned zerofill","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["categorie"]=array();
$DbStructure["categorie"]["id_categoria"]=array("Type"=>"mediumint(7)","Collation"=>"","Null"=>"NO","Key"=>"PRI","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["categorie"]["descrizione_categoria"]=array("Type"=>"text","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["ristoranti"]=array();
$DbStructure["ristoranti"]["id_ristorante"]=array("Type"=>"mediumint(7) unsigned","Collation"=>"","Null"=>"NO","Key"=>"PRI","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["ristoranti"]["indirizzo_ristorante"]=array("Type"=>"varchar(100)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["ristoranti"]["cap_ristorante"]=array("Type"=>"int(5) unsigned zerofill","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["ristoranti"]["telefono_ristorante"]=array("Type"=>"varchar(50)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["ristoranti"]["email_ristorante"]=array("Type"=>"varchar(100)","Collation"=>"utf8_general_ci","Null"=>"YES","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["ristoranti"]["sito_web"]=array("Type"=>"varchar(255)","Collation"=>"utf8_general_ci","Null"=>"YES","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["ristoranti_aderenti"]=array();
$DbStructure["ristoranti_aderenti"]["id_ristorante"]=array("Type"=>"int(11)","Collation"=>"","Null"=>"NO","Key"=>"PRI","Default"=>"","Extra"=>"auto_increment","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["ristoranti_aderenti"]["nome"]=array("Type"=>"varchar(100)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["ristoranti_aderenti"]["indirizzo"]=array("Type"=>"varchar(100)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["ristoranti_aderenti"]["localita"]=array("Type"=>"varchar(100)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["ristoranti_aderenti"]["telefono"]=array("Type"=>"varchar(100)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["ristoranti_aderenti"]["chiuso_il"]=array("Type"=>"varchar(100)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["ristoranti_aderenti"]["categoria_menu"]=array("Type"=>"enum('25','35','45')","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["utenti"]=array();
$DbStructure["utenti"]["user_id"]=array("Type"=>"mediumint(7) unsigned","Collation"=>"","Null"=>"NO","Key"=>"PRI","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["utenti"]["user_email"]=array("Type"=>"varchar(100)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"UNI","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"email mandatory");
$DbStructure["utenti"]["user_password"]=array("Type"=>"char(40)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"MUL","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["utenti"]["newsletter_subscribed"]=array("Type"=>"tinyint(1)","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["utenti"]["pwd_salt"]=array("Type"=>"timestamp","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"0000-00-00 00:00:00","Extra"=>"on update CURRENT_TIMESTAMP","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["utenti"]["user_level"]=array("Type"=>"enum('developer','admin','supervisor','editor','registered','public')","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["utenti"]["groups"]=array("Type"=>"set('CATEGORIE_PRODOTTI','COMMENTI','CONCORSI','CUOCHI_PATRON','PIATTI','PRODOTTI','RISTORANTI','UTENTI','UTENTI_ANAGRAFICA','VOTI_RISTORANTI')","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["utenti"]["terms_acceptance"]=array("Type"=>"tinyint(1)","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["utenti"]["confirmed"]=array("Type"=>"tinyint(1)","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["utenti_anagrafica"]=array();
$DbStructure["utenti_anagrafica"]["id_anagrafica"]=array("Type"=>"mediumint(7) unsigned","Collation"=>"","Null"=>"NO","Key"=>"PRI","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["utenti_anagrafica"]["user_id"]=array("Type"=>"mediumint(7) unsigned","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["utenti_anagrafica"]["nome_e_cognome"]=array("Type"=>"varchar(100)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["utenti_anagrafica"]["cap_utente"]=array("Type"=>"int(5)","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["utenti_anagrafica"]["telefono1_utente"]=array("Type"=>"int(50)","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["utenti_anagrafica"]["telefono2_utente"]=array("Type"=>"varchar(50)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["utenti_anagrafica"]["fax_utente"]=array("Type"=>"varchar(50)","Collation"=>"utf8_general_ci","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["utenti_anagrafica"]["indirizzo_utente"]=array("Type"=>"int(150)","Collation"=>"","Null"=>"NO","Key"=>"","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
$DbStructure["utenti_anagrafica"]["partita_iva_utente"]=array("Type"=>"int(11)","Collation"=>"","Null"=>"NO","Key"=>"UNI","Default"=>"","Extra"=>"","Privileges"=>"select,insert,update,references","Comment"=>"");
?>