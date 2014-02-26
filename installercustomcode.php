<?php

//==============================================================================
//! Installatron Custom Code
//  
//  This code handles all customization of Installatron including hooks
//  that run before and after installs.
//  
//  for more information go to http://installatron.com/developer/customization
//==============================================================================


class i_installer_customcode{
	
	function init(){
			
		//===============================================
		//! Register all plugins, themes, and functions
		//===============================================

			
		//========================================
		//! Plugins for Professional Portfolio
		//========================================

		$this->registerArchive("wp_importer","http://downloads.wordpress.org/plugin/wordpress-importer.0.6.1.zip", "zip");
		$this->registerArchive("cookies","http://downloads.wordpress.org/plugin/cookies-for-comments.0.5.5.zip", "zip");
		$this->registerArchive("sub2comments","http://downloads.wordpress.org/plugin/subscribe-to-comments.2.1.2.zip", "zip");
		$this->registerArchive("jetpack","http://downloads.wordpress.org/plugin/jetpack.2.7.zip", "zip");
		$this->registerArchive("googleanalytics","http://downloads.wordpress.org/plugin/googleanalytics.zip", "zip");
		$this->registerArchive("googlefonts","http://downloads.wordpress.org/plugin/wp-google-fonts.zip", "zip");
		$this->registerArchive("testimonials","http://downloads.wordpress.org/plugin/testimonials-widget.2.17.2.zip", "zip");
		$this->registerArchive("tinymcewidget","http://downloads.wordpress.org/plugin/black-studio-tinymce-widget.1.2.0.zip", "zip");
		$this->registerArchive("researchfields", "http://umwdomains.com/installatron/plugins/research-log-fields.zip", "zip");
		$this->registerArchive("giscategories","http://umwdomains.com/installatron/plugins/gis_categories.zip", "zip");
		$this->registerArchive("githubshortcode","http://downloads.wordpress.org/plugin/github-shortcode.zip", "zip");
		$this->registerArchive("wpgithubcommits","http://downloads.wordpress.org/plugin/wp-github-commits.0.5.zip", "zip");
		$this->registerArchive("githubwordpresswidget","http://downloads.wordpress.org/plugin/github-profile-display.0.99.zip", "zip");
		$this->registerArchive("crayonsyntaxhighlighter","http://downloads.wordpress.org/plugin/crayon-syntax-highlighter.zip", "zip");
			
		//=====================================
		//! Themes for Professional Portfolio
		//=====================================
		
		$this->registerArchive("responsive","http://wordpress.org/themes/download/responsive.1.9.4.3.zip","zip");
		$this->registerArchive("corpo","http://wordpress.org/themes/download/corpo.1.3.2.zip","zip");
		$this->registerArchive("iconicone","http://wordpress.org/themes/download/iconic-one.1.3.2.zip","zip");
		$this->registerArchive("squirrel","http://wordpress.org/themes/download/squirrel.1.6.2.zip","zip");
		$this->registerArchive("zeedynamic","http://wordpress.org/themes/download/zeedynamic.1.0.2.zip","zip");
		$this->registerArchive("zeebizzcard","http://wordpress.org/themes/download/zeebizzcard.1.4.zip","zip");
		$this->registerArchive("priimo","http://wordpress.org/themes/download/priimo.1.3.zip","zip");
		$this->registerArchive("preferencelite","http://wordpress.org/themes/download/preference-lite.1.7.5.zip","zip");
		$this->registerArchive("highwind","http://wordpress.org/themes/download/highwind.1.2.1.zip","zip");
	
		//============================
		//! Themes for art portfolio
		//============================

		$this->registerArchive("ward","http://wordpress.org/themes/download/ward.1.0.4.zip","zip");
		$this->registerArchive("opulus","http://wordpress.org/themes/download/wp-opulus.2.4.0.zip","zip");
		$this->registerArchive("parabola","http://wordpress.org/themes/download/parabola.1.3.2.zip","zip");
		$this->registerArchive("snapshot","http://wordpress.org/themes/download/snapshot.1.2.8.zip","zip");
		$this->registerArchive("virtue","http://wordpress.org/themes/download/virtue.1.8.5.zip","zip");
		$this->registerArchive("gridsterlite","http://wordpress.org/themes/download/gridster-lite.1.0.5.1.zip","zip");
		$this->registerArchive("portfoliopress","http://wordpress.org/themes/download/portfolio-press.1.8.zip","zip");
			
		//=============================
		//! Plugins for art portfolio
		//=============================

		$this->registerArchive("nextgen","http://downloads.wordpress.org/plugin/nextgen-gallery.zip","zip");
		$this->registerArchive("gallery","http://downloads.wordpress.org/plugin/gallery-plugin.latest-stable.zip","zip");
		$this->registerArchive("awesomeportfolio","http://downloads.wordpress.org/plugin/awesome-filterable-portfolio.1.7.8.zip","zip");
			
		//==============================
		//! Extensions for Mediawiki
		//==============================
	
		$this->registerArchive("confirmaccount","http://umwdomains.com/installatron/extensions/confirmaccount.zip","zip");
		
		//============================================
		//! Setup functions for the install routines
		//============================================
			
		$this->registerCustomCode("all", "all", "install", "last", "process", "addsite");
		$this->registerCustomCode("all", "all", "install", 1, "init", "allinstallinput");
		$this->registerCustomCode("wordpress", "all", "install", 1, "init", "wordpressinstallinput");
		$this->registerCustomCode("wordpress", "all", "install", "last", "process", "wordpressinstall");
		$this->registerCustomCode("all", "all", "uninstall", "last", "process", "alluninstall");
		$this->registerCustomCode("mediawiki", "all", "install", "last", "process", "mediawikiinstall");
	}

	function allinstallinput($o) {
	
		//===========================
		//! Grab Course Information
		//===========================
		include_once 'config.php';
		include_once 'FeedCache.php';
		$feed_cache = new FeedCache('local_file.xml', $googlespreadsheeturl);
		$rss = simplexml_load_string($feed_cache->get_data());
			
		foreach($rss->xpath('channel/item') as $item)
			{
				$option_description = explode (",", $item->description);
				$option_coursecode = substr($option_description[0], 12);
				$option_arr[$option_coursecode] = $item->title; 
			}		
	
		//=============================
		//! Setup installer UI fields
		//=============================

		$o->setInputFields(array(
			array(
			"ID" => "course",
			"LABEL" => "Course or Project",
			"TEXT" => "Choose an associated course or project (optional)",
			"TYPE" => "select",
			"OPTIONS" => $option_arr),
            array(
            "ID" => "status",
            "LABEL"=>"Status",
            "TEXT"=>"Please indicate your current status at the University.",
            "TYPE"=>"select",
            "OPTIONS"=> array("none" => "Choose One", "faculty"=>"Faculty","student"=>"Student","staff"=>"Staff"))
			));
	}


	function wordpressinstallinput($o){
			
		//=============================
		//! Setup installer UI fields
		//=============================

		$o->setInputFields(array(
			array(
			"ID" => "package_type",
			"LABEL" => "Package Type",
			"TEXT" => "Choose a package (optional)",
			"TYPE" => "radio",
			"OPTIONS" => array( "profPort" => "Professional Portfolio", "artPort" => "Art Portfolio"))
			)
		);
	}
	
	function addsite($o){
		include_once 'config.php';
		
		$siteurl = $o->install->ini["url"];
		$cleanurlhost = parse_url($siteurl, PHP_URL_HOST);
		$cleanurlpath = parse_url($siteurl, PHP_URL_PATH);
		
		if (is_null($cleanurlpath)) {
			$cleanurl = str_replace('.', '', $cleanurlhost);
		} else {
			$cleanurl = str_replace('.', '', $cleanurlhost) . str_replace('/', '', $cleanurlpath);
		}
		
		$regtime = time();
		$wpregdate = date("Y-m-d H:i:s");
		
		//=============================================
		//! retrieve info about user  to link to site
		//=============================================

		$user = $o->install->owner["user"];
		$useridquery = $thedb->query("SELECT ID FROM wp_users WHERE user_login='$user'");
		$useridresult = $useridquery->fetch();
		$userid = $useridresult[0];
		
		//===========================================
		//! Write taxonomy information to variables
		//===========================================
		
		$software = $o->install->ini["installer"];
		$course = $o->input["field_course"];
		$status = $o->input["field_status"];
        
        //===========================================
		//! retreive instructor/dept code information from RSS Feed based on
		//===========================================
        include_once 'FeedCache.php';
			
		$feed_cache = new FeedCache('local_file.xml', $googlespreadsheeturl);
		$array = json_decode(json_encode((array)simplexml_load_string($feed_cache->get_data())),1);
		
		$itemArray = $array['channel']['item'];
		
		foreach ($itemArray as $key => $val){
           foreach ($val as $key1 => $val1) {
			   if (strpos($val1, $course) !== false) {
				   $itemid = $key;
               }
		    }
		}
		
		$coursedescription = $itemArray[$itemid]['description'];
		$coursedescriptionexp = explode (",", $coursedescription);
		$courseinstructor = substr($coursedescriptionexp[1], 18);
		$coursedept = substr($coursedescriptionexp[2], 14);
		$course2 = substr($coursedescriptionexp[4], 6);


		//=================================================
		//! API call to community.umwdomains.com to write Site post
		//=================================================

		$apiurl = $wp_apiurl . 'posts/create_post/';
		
		$customfields["wpcf-siteurl"] = $siteurl;
		$customfields["wpcf-install-date"] = $regtime;
		$customtax["software"] = $software;
		$customtax["course"] = $course2;
		$customtax["instructor"] = $courseinstructor;
		$customtax["status"] = $status;
		$customtax["department"] = $coursedept;

		$postfields = array();
		$postfields["author"] = $userid;
		$postfields["title"] = $siteurl;
		$postfields["status"] = "publish";
		$postfields["type"] = "site";
		$postfields["customfields"] = $customfields;
		$postfields["customtax"] = $customtax;
 	
		$query_string = http_build_query($postfields);
 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiurl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
		$jsondata = curl_exec($ch);
		curl_close($ch);
		
		//===========================
		//! Add site feed on community
		//===========================
		
		$feedapiurl = $wp_apiurl . 'links/add_feed/';
    
		$feedpostfields = array();
		$feedpostfields["link_url"] = $siteurl;
		$feedpostfields["link_owner"] = $userid;
		$feedpostfields["link_instructor"] = $courseinstructor;
		$feedpostfields["link_course"] = $course2;
		$feedpostfields["link_dept"] = $coursedept;
 	
		$feedquery_string = http_build_query($feedpostfields);
 
		$feedch = curl_init();
		curl_setopt($feedch, CURLOPT_URL, $feedapiurl);
		curl_setopt($feedch, CURLOPT_POST, 1);
		curl_setopt($feedch, CURLOPT_TIMEOUT, 30);
		curl_setopt($feedch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($feedch, CURLOPT_POSTFIELDS, $feedquery_string);
		$feedjsondata = curl_exec($feedch);
		curl_close($feedch);

 		
	}

	function wordpressinstall($o){
    		
		//===========================
		//! Install default plugins
		//===========================

		$o->extract("wp_importer", "wp-content/plugins");
		$o->extract("cookies", "wp-content/plugins");
		$o->extract("sub2comments", "wp-content/plugins");
			
		//=================================
		//! Set default plugins to active
		//=================================

		$o->db_query("UPDATE `{$o->db_prefix}options` SET `option_value`=? WHERE `option_name`='active_plugins' LIMIT 1",array( serialize(array("cookies-for-comments/cookies-for-comments.php","wordpress-importer/wordpress-importer.php","subscribe-to-comments/subscribe-to-comments.php")) ));
			
		//==============================================================
		//! If user chose a package, install set of plugins and themes
		//==============================================================

		if ($o->input["field_package_type"] === "profPort"){
		
			$o->extract("responsive", "wp-content/themes");
			$o->extract("corpo", "wp-content/themes");
			$o->extract("iconicone", "wp-content/themes");
			$o->extract("squirrel", "wp-content/themes");
			$o->extract("zeedynamic", "wp-content/themes");
			$o->extract("zeebizzcard", "wp-content/themes");
			$o->extract("priimo", "wp-content/themes");
			$o->extract("preferencelite", "wp-content/themes");
			$o->extract("highwind", "wp-content/themes");
			$o->extract("jetpack", "wp-content/plugins");
			$o->extract("googleanalytics", "wp-content/plugins");
			$o->extract("googlefonts", "wp-content/plugins");
			$o->extract("testimonials", "wp-content/plugins");
			$o->extract("tinymcewidget", "wp-content/plugins");
			$o->extract("researchfields", "wp-content/plugins");
			$o->extract("giscategories", "wp-content/plugins");
			$o->extract("githubshortcode", "wp-content/plugins");
			$o->extract("wpgithubcommits", "wp-content/plugins");
			$o->extract("githubwordpresswidget", "wp-content/plugins");
			$o->extract("crayonsyntaxhighlighter", "wp-content/plugins");
			$page1url = $siteurl . '/?page_id=3';
			$page2url = $siteurl . '/?page_id=4';
			$page3url = $siteurl . '/?page_id=5';
			$o->db_query("INSERT INTO `{$o->db_prefix}posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
				(null, 1, '$wpregdate', '$wpregdate', '\r\n\r\n<strong>Remember, you can always <a href=\"http://academics.umw.edu/academicandcareerservices\">contact UMW''s Office for Academic and Career Services</a> to seek help with writing your cover letter and resume.</strong>\r\n\r\nThis is an example of a cover letter you might wish to have on your professional portfolio site. In the first paragraph it is typical to describe the type of position you are seeking and tell a little bit of information about yourself (where you went to school, what your major was, etc). You could also link to your <a title=\"About\" href=\"about\">About page</a> and be more descriptive about yourself on that page.\r\n\r\nIn the second paragraph it is customary to outline a few of the qualifications that make you the <strong>perfect</strong> fit for the type of position that you are seeking. Since this is a web-based portfolio it is a great idea to link to specific examples of work you''ve done. If you participated in organizations, clubs, or projects that are relevant to your experience and further exemplify why you are qualified for a position, this is the point of a cover letter where you would highlight those experiences.\r\n\r\nIn your closing paragraph you outline some details of the field for which you are interested in seeking employment while linking to examples of work that highlights your expertise in the field. If there are sections of the site you want to promote to a potential employer this is a good time to mention those. Make sure you close by linking again to your About page (where you should add contact information) and remind the reader that you''d be happy to speak over the phone or in person about opportunities they might have that would be a great fit.\r\n', 'Cover Letter', '', 'publish', 'closed', 'closed', '', 'cover-letter', '', '', '$wpregdate', '$wpregdate', '', 0, '$page1url', 0, 'page', '', 0),
				(null, 1, '$wpregdate', '$wpregdate', '\r\n\r\n<strong>Remember, you can always <a href=\"http://academics.umw.edu/academicandcareerservices\">contact UMW''s Office for Academic and Career Services</a> to seek help with writing your cover letter and resume.</strong><h1>Your Name</h1>\r\n123 Address Street • City, State Zip Code\r\n(555) 555-5555\r\nyouremail@address.com\r\n<h2>Education</h2>\r\n<h3>University of Mary Washington • Fredericksburg, VA • 2012-Present</h3>\r\nMajor: Geography\r\nConcentration: GIS\r\nGPA: 3.5\r\n<h3>Example High School • Fredericksburg, VA • 2008-2012</h3>\r\nDiploma with Honors\r\n<h2>Experience</h2>\r\n<h3>Example Job One (2013-Present) • Fredericksburg, VA</h3>\r\n<h4>Position</h4>\r\nA description of your job including responsibilities that you had while working there.\r\n<h3>Example Job Two (2011-2013) • Fredericksburg, VA</h3>\r\n<h4>Position</h4>\r\nA description of your job including responsibilities that you had while working there.\r\n<h2>Special Skills</h2>\r\n<h3>Technology</h3>\r\n<ul>\r\n	<li>Microsoft Office</li>\r\n	<li>Adobe Creative Suite</li>\r\n	<li>ESRI and ArcGIS</li>\r\n	<li>Python programming within the ArcGIS 10.1 framework</li>\r\n</ul>\r\n<h3>Leadership Positions</h3>\r\n<ul>\r\n	<li>UMW Soccer Captain</li>\r\n	<li>Youth Group Leader</li>\r\n</ul>\r\n<h2>Awards and Honors</h2>\r\n<h3>University of Mary Washington • Fredericksburg, VA</h3>\r\n<ul>\r\n	<li>Dean''s List</li>\r\n	<li>Pi Gamma Mu Member</li>\r\n	<li>Gamma Theta Upsilon Member</li>\r\n</ul>', 'Resume', '', 'publish', 'closed', 'closed', '', 'resume', '', '', '$wpregdate', '$wpregdate', '', 0, '$page2url', 0, 'page', '', 0),
				(null, 1, '$wpregdate', '$wpregdate', '', 'Portfolio', '', 'publish', 'closed', 'closed', '', 'portfolio', '', '', '$wpregdate', '$wpregdate', '', 0, '$page3url', 0, 'page', '', 0)");
			$o->db_query("UPDATE `{$o->db_prefix}options` SET `option_value`='page' WHERE `option_name`='show_on_front' LIMIT 1");
			$o->db_query("UPDATE `{$o->db_prefix}options` SET `option_value`='5' WHERE `option_name`='page_for_posts' LIMIT 1");
			$o->db_query("UPDATE `{$o->db_prefix}options` SET `option_value`='2' WHERE `option_name`='page_on_front' LIMIT 1");
		}
			
		if ($o->input["field_package_type"] === "artPort"){
		
			$o->extract("portfoliopress", "wp-content/themes");
			$o->extract("ward", "wp-content/themes");
			$o->extract("opulus", "wp-content/themes");
			$o->extract("parabola", "wp-content/themes");
			$o->extract("snapshot", "wp-content/themes");
			$o->extract("virtue", "wp-content/themes");
			$o->extract("gridsterlite", "wp-content/themes");

			$o->extract("jetpack", "wp-content/plugins");
			$o->extract("googleanalytics", "wp-content/plugins");
			$o->extract("googlefonts", "wp-content/plugins");
			$o->extract("testimonials", "wp-content/plugins");
			$o->extract("tinymcewidget", "wp-content/plugins");
			$o->extract("nextgen", "wp-content/plugins");
			$o->extract("gallery", "wp-content/plugins");
			$o->extract("awesomeportfolio", "wp-content/plugins");
		}
			
	}
	
	//===================================================================================
	//! Set defaults for MediaWiki install to require registration and approval to edit
	//===================================================================================
	
	function mediawikiinstall($o){
	
		//$o->extract("confirmaccount", "extensions/");
		$o->sr("LocalSettings.php", "#Add\s*more\s*configuration\s*options\s*below.#", "End of automatically generated settings. \n\n \$wgGroupPermissions['*']['edit'] = false; \n\n \$wgGroupPermissions['*']['createpage'] = false; \n\n \$wgEmailConfirmToEdit = true;");
	}
	
	function alluninstall($o){
		include_once 'config.php';
		
		$siteurl = $o->install->ini["url"];
		
		//===========================
		//! Remove site from Community
		//===========================
		
		$apiurl = $wp_apiurl . 'posts/delete_post/';
    
		$postfields = array();
		$postfields["post_url"] = $siteurl;
 	
		$query_string = http_build_query($postfields);
 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $apiurl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $query_string);
		$jsondata = curl_exec($ch);
		curl_close($ch);
		
	}
}
?>