<?php

  //Direct access not permitted show 404
  if(count(get_included_files()) ==1){ header("HTTP/1.0 404 Not Found"); die(); }
  
  $APPS = array (
                  "WordPress"  => array ("name" => "WordPress", 
                                  "version" => "4.3", 
                                  "desc" => "WordPress is web software you can use to create a beautiful website or blog. We like to say that WordPress is both free and priceless at the same time.",
                                  "cat" => "Blog",
                                  "link" => "wordpress.org",
                                  "img_link" => "wordpress.png"),
                                  
                  "Nibble"  => array ("name" => "Nibble Blog", 
                                  "version" => "4.0.5", 
                                  "desc" => "Nibbleblog is a powerful engine for creating blogs, all you need is PHP to work. Very simple to install and configure ",
                                  "cat" => "Blog",
                                  "link" => "nibbleblog.com",
                                  "img_link" => "nibbleblog.png"),
                                  
                  "OpenCart"  => array ("name" => "OpenCart", 
                                  "version" => "2.0.3.1", 
                                  "desc" => "A powerful open source shopping cart system that is designed feature rich and user friendly.",
                                  "cat" => "Shopping Cart",
                                  "link" => "opencart.com",
                                  "img_link" => "opencart.png"),
                                  
                  "PrestaShop"  => array ("name" => "PrestaShop", 
                                  "version" => "1.6.1.1", 
                                  "desc" => "Create your online store with PrestaShop free shopping cart software. Build an ecommerce website for free and start selling online with hundreds of powerful features.",
                                  "cat" => "Shopping Cart",
                                  "link" => "prestashop.com",
                                  "img_link" => "prestashop.png"),
                                  
                  "Textpattern"  => array ("name" => "Textpattern CMS", 
                                  "version" => "4.5.7", 
                                  "desc" => "A Flexible, Elegant and Easy-To-Use Content Management System.",
                                  "cat" => "CMS",
                                  "link" => "textpattern.com",
                                  "img_link" => "textpattern.png"),
                                  
                  "Joomla"  => array ("name" => "Joomla", 
                                  "version" => "3.4.3", 
                                  "desc" => "Joomla! is an award-winning open source CMS for building powerful websites.",
                                  "cat" => "CMS",
                                  "link" => "joomla.org",
                                  "img_link" => "joomla.png"),
                                  
                  "phpBB"  => array ("name" => "phpBB", 
                                  "version" => "3.1.5", 
                                  "desc" => "WordPress is web software you can use to create a beautiful website or blog. We like to say that WordPress is both free and priceless at the same time.",
                                  "cat" => "Message Board",
                                  "link" => "phpbb.com",
                                  "img_link" => "phpbb.png"),
                                  
                  "SMF"  => array ("name" => "Simple Machines Forum", 
                                  "version" => "2.0.10", 
                                  "desc" => "Simple Machines Forum aka SMF is a free, professional grade software package that allows you to set up your own online community within minutes.",
                                  "cat" => "Message Board",
                                  "link" => "simplemachines.org",
                                  "img_link" => "smf.png")
                  );
                  
 