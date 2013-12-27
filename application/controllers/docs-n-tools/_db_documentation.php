<?php

/*
 * Crudo Framework Version 2.0
 * copyright © Adriano Martino 2011 (www.adrianomartino.com)
 * Database Notes and Documentation1.0
 *
 * NOTE: Currently Supports 1 database
 *
 *
 * Even though Crudo will adapt to several types
 * of database's design, here are some guidelines
 * and innovations I'm trying to bring.
 *
 *
 * One of the goal of Crudo is to stop considering,
 * when talking about websites, very different things
 * for different categories of items that might be found
 * in a website.
 *
 * For instance, even though a website regarding a hotel chain,
 * 1 regarding Real Estate and one regarding Music might seem pretty
 * different, Here we want to Start treating every element for what it is
 * a web crumble, a piece of web.
 *
 * No matter if it's a description of a house, a video, a music track or a pdf,
 * after all they are all pieces of web.
 *
 * For this reason Crudo generates for each item common parts
 * that nearly any piece of information on the web needs.
 *
 * In particular there are 2 tables that manage this fenomenum: _item_generator & _item_metadata
 *
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * * * * * * * * * * * * * * * * * * * * * * Guidelines * * * * * * * * * * * * * * * * * * * * * * *
 * *
 * *            1. You cannot have composite primary keys
 * *
 * *            2. Each db table must have it's own singular primary key
 * *                represented by the id correspondent to the item id
 * *            
 * *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
 *
 *
 * 
 *
 *      *********                       *********
 *      *********_item_generator ********
 *      *********                       *********
 *     
 *
 *              This table generate a unique id for the resource that is being created
 *             to be used all over the database to allow easy many to many relationships
 *            between different kinds of data.
 *
 *            this table stores
 *
 *            universal_id = a Medium INT number ( so we can put uo to 7 million items in our website with no problem )
 *            creation date
 *            last modify
 *            creator_id
 *            item status ('draft','public','private','edit','unlisted','recycle bin')
 *            log_id     ( a number that ties us to the log table where we have stored security info about the transaction )
 *            
 *
 *
 *
 *      *********                       *********
 *      *********_item_metadata*********
 *      *********                       *********
 *      
 *             name_or_title of the item
 *             snippet
 *             keywords
 *             thumbnail in BLOB format
 *             url last piece
 *             item_language
 *
 *             
 *      *********                       *********
 *      *********       _log          *********
 *      *********                       *********
 *
 *
 *          log_id
 *          ip
 *          url
 *          post requests
 *          get requests
 *          user_id
 *      
 * 
*/