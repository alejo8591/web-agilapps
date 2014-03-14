<?php 
/**
 * SMOF Modified / portal
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @theme portal
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		global $portal_data;

		//Access the WordPress Categories via an Array
		$of_categories 		= array();
		$of_categories_obj 	= get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
			$of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp 	= array_unshift($of_categories, "Select a category");

		//Footer Elements
		$footer_counters = array (
			"disabled" => array (
				"subsrcibers" => __('Subscribers', 'portal'),
				"months" => __('Months Running', 'portal'),
				"years" => __('Years Running', 'portal'),
				"authors" => __('Authors', 'portal')
			), 
			"enabled" => array (
				"days" => __('Days Running', 'portal'),
				"posts" => __('Articles', 'portal'),
				"comments" => __('Comments', 'portal'),
			),
		);


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
$fonts = array( /* Google Fonts */ "ABeeZee" => "ABeeZee", "Abel" => "Abel", "Abril Fatface" => "Abril Fatface", "Aclonica" => "Aclonica", "Acme" => "Acme", "Actor" => "Actor", "Adamina" => "Adamina", "Advent Pro" => "Advent Pro", "Aguafina Script" => "Aguafina Script", "Akronim" => "Akronim", "Aladin" => "Aladin", "Aldrich" => "Aldrich", "Alegreya" => "Alegreya", "Alegreya SC" => "Alegreya SC", "Alex Brush" => "Alex Brush", "Alfa Slab One" => "Alfa Slab One", "Alice" => "Alice", "Alike" => "Alike", "Alike Angular" => "Alike Angular", "Allan" => "Allan", "Allerta" => "Allerta", "Allerta Stencil" => "Allerta Stencil", "Allura" => "Allura", "Almendra" => "Almendra", "Almendra Display" => "Almendra Display", "Almendra SC" => "Almendra SC", "Amarante" => "Amarante", "Amaranth" => "Amaranth", "Amatic SC" => "Amatic SC", "Amethysta" => "Amethysta", "Anaheim" => "Anaheim", "Andada" => "Andada", "Andika" => "Andika", "Angkor" => "Angkor", "Annie Use Your Telescope" => "Annie Use Your Telescope", "Anonymous Pro" => "Anonymous Pro", "Antic" => "Antic", "Antic Didone" => "Antic Didone", "Antic Slab" => "Antic Slab", "Anton" => "Anton", "Arapey" => "Arapey", "Arbutus" => "Arbutus", "Arbutus Slab" => "Arbutus Slab", "Architects Daughter" => "Architects Daughter", "Archivo Black" => "Archivo Black", "Archivo Narrow" => "Archivo Narrow", "Arimo" => "Arimo", "Arizonia" => "Arizonia", "Armata" => "Armata", "Artifika" => "Artifika", "Arvo" => "Arvo", "Asap" => "Asap", "Asset" => "Asset", "Astloch" => "Astloch", "Asul" => "Asul", "Atomic Age" => "Atomic Age", "Aubrey" => "Aubrey", "Audiowide" => "Audiowide", "Autour One" => "Autour One", "Average" => "Average", "Average Sans" => "Average Sans", "Averia Gruesa Libre" => "Averia Gruesa Libre", "Averia Libre" => "Averia Libre", "Averia Sans Libre" => "Averia Sans Libre", "Averia Serif Libre" => "Averia Serif Libre", "Bad Script" => "Bad Script", "Balthazar" => "Balthazar", "Bangers" => "Bangers", "Basic" => "Basic", "Battambang" => "Battambang", "Baumans" => "Baumans", "Bayon" => "Bayon", "Belgrano" => "Belgrano", "Belleza" => "Belleza", "BenchNine" => "BenchNine", "Bentham" => "Bentham", "Berkshire Swash" => "Berkshire Swash", "Bevan" => "Bevan", "Bigelow Rules" => "Bigelow Rules", "Bigshot One" => "Bigshot One", "Bilbo" => "Bilbo", "Bilbo Swash Caps" => "Bilbo Swash Caps", "Bitter" => "Bitter", "Black Ops One" => "Black Ops One", "Bokor" => "Bokor", "Bonbon" => "Bonbon", "Boogaloo" => "Boogaloo", "Bowlby One" => "Bowlby One", "Bowlby One SC" => "Bowlby One SC", "Brawler" => "Brawler", "Bree Serif" => "Bree Serif", "Bubblegum Sans" => "Bubblegum Sans", "Bubbler One" => "Bubbler One", "Buda" => "Buda", "Buenard" => "Buenard", "Butcherman" => "Butcherman", "Butterfly Kids" => "Butterfly Kids", "Cabin" => "Cabin", "Cabin Condensed" => "Cabin Condensed", "Cabin Sketch" => "Cabin Sketch", "Caesar Dressing" => "Caesar Dressing", "Cagliostro" => "Cagliostro", "Calligraffitti" => "Calligraffitti", "Cambo" => "Cambo", "Candal" => "Candal", "Cantarell" => "Cantarell", "Cantata One" => "Cantata One", "Cantora One" => "Cantora One", "Capriola" => "Capriola", "Cardo" => "Cardo", "Carme" => "Carme", "Carrois Gothic" => "Carrois Gothic", "Carrois Gothic SC" => "Carrois Gothic SC", "Carter One" => "Carter One", "Caudex" => "Caudex", "Cedarville Cursive" => "Cedarville Cursive", "Ceviche One" => "Ceviche One", "Changa One" => "Changa One", "Chango" => "Chango", "Chau Philomene One" => "Chau Philomene One", "Chela One" => "Chela One", "Chelsea Market" => "Chelsea Market", "Chenla" => "Chenla", "Cherry Cream Soda" => "Cherry Cream Soda", "Cherry Swash" => "Cherry Swash", "Chewy" => "Chewy", "Chicle" => "Chicle", "Chivo" => "Chivo", "Cinzel" => "Cinzel", "Cinzel Decorative" => "Cinzel Decorative", "Clicker Script" => "Clicker Script", "Coda" => "Coda", "Coda Caption" => "Coda Caption", "Codystar" => "Codystar", "Combo" => "Combo", "Comfortaa" => "Comfortaa", "Coming Soon" => "Coming Soon", "Concert One" => "Concert One", "Condiment" => "Condiment", "Content" => "Content", "Contrail One" => "Contrail One", "Convergence" => "Convergence", "Cookie" => "Cookie", "Copse" => "Copse", "Corben" => "Corben", "Courgette" => "Courgette", "Cousine" => "Cousine", "Coustard" => "Coustard", "Covered By Your Grace" => "Covered By Your Grace", "Crafty Girls" => "Crafty Girls", "Creepster" => "Creepster", "Crete Round" => "Crete Round", "Crimson Text" => "Crimson Text", "Croissant One" => "Croissant One", "Crushed" => "Crushed", "Cuprum" => "Cuprum", "Cutive" => "Cutive", "Cutive Mono" => "Cutive Mono", "Damion" => "Damion", "Dancing Script" => "Dancing Script", "Dangrek" => "Dangrek", "Dawning of a New Day" => "Dawning of a New Day", "Days One" => "Days One", "Delius" => "Delius", "Delius Swash Caps" => "Delius Swash Caps", "Delius Unicase" => "Delius Unicase", "Della Respira" => "Della Respira", "Denk One" => "Denk One", "Devonshire" => "Devonshire", "Didact Gothic" => "Didact Gothic", "Diplomata" => "Diplomata", "Diplomata SC" => "Diplomata SC", "Domine" => "Domine", "Donegal One" => "Donegal One", "Doppio One" => "Doppio One", "Dorsa" => "Dorsa", "Dosis" => "Dosis", "Dr Sugiyama" => "Dr Sugiyama", "Droid Sans" => "Droid Sans", "Droid Sans Mono" => "Droid Sans Mono", "Droid Serif" => "Droid Serif", "Duru Sans" => "Duru Sans", "Dynalight" => "Dynalight", "EB Garamond" => "EB Garamond", "Eagle Lake" => "Eagle Lake", "Eater" => "Eater", "Economica" => "Economica", "Electrolize" => "Electrolize", "Elsie" => "Elsie", "Elsie Swash Caps" => "Elsie Swash Caps", "Emblema One" => "Emblema One", "Emilys Candy" => "Emilys Candy", "Engagement" => "Engagement", "Englebert" => "Englebert", "Enriqueta" => "Enriqueta", "Erica One" => "Erica One", "Esteban" => "Esteban", "Euphoria Script" => "Euphoria Script", "Ewert" => "Ewert", "Exo" => "Exo", "Expletus Sans" => "Expletus Sans", "Fanwood Text" => "Fanwood Text", "Fascinate" => "Fascinate", "Fascinate Inline" => "Fascinate Inline", "Faster One" => "Faster One", "Fasthand" => "Fasthand", "Federant" => "Federant", "Federo" => "Federo", "Felipa" => "Felipa", "Fenix" => "Fenix", "Finger Paint" => "Finger Paint", "Fjalla One" => "Fjalla One", "Fjord One" => "Fjord One", "Flamenco" => "Flamenco", "Flavors" => "Flavors", "Fondamento" => "Fondamento", "Fontdiner Swanky" => "Fontdiner Swanky", "Forum" => "Forum", "Francois One" => "Francois One", "Freckle Face" => "Freckle Face", "Fredericka the Great" => "Fredericka the Great", "Fredoka One" => "Fredoka One", "Freehand" => "Freehand", "Fresca" => "Fresca", "Frijole" => "Frijole", "Fruktur" => "Fruktur", "Fugaz One" => "Fugaz One", "GFS Didot" => "GFS Didot", "GFS Neohellenic" => "GFS Neohellenic", "Gabriela" => "Gabriela", "Gafata" => "Gafata", "Galdeano" => "Galdeano", "Galindo" => "Galindo", "Gentium Basic" => "Gentium Basic", "Gentium Book Basic" => "Gentium Book Basic", "Geo" => "Geo", "Geostar" => "Geostar", "Geostar Fill" => "Geostar Fill", "Germania One" => "Germania One", "Gilda Display" => "Gilda Display", "Give You Glory" => "Give You Glory", "Glass Antiqua" => "Glass Antiqua", "Glegoo" => "Glegoo", "Gloria Hallelujah" => "Gloria Hallelujah", "Goblin One" => "Goblin One", "Gochi Hand" => "Gochi Hand", "Gorditas" => "Gorditas", "Goudy Bookletter 1911" => "Goudy Bookletter 1911", "Graduate" => "Graduate", "Grand Hotel" => "Grand Hotel", "Gravitas One" => "Gravitas One", "Great Vibes" => "Great Vibes", "Griffy" => "Griffy", "Gruppo" => "Gruppo", "Gudea" => "Gudea", "Habibi" => "Habibi", "Hammersmith One" => "Hammersmith One", "Hanalei" => "Hanalei", "Hanalei Fill" => "Hanalei Fill", "Handlee" => "Handlee", "Hanuman" => "Hanuman", "Happy Monkey" => "Happy Monkey", "Headland One" => "Headland One", "Henny Penny" => "Henny Penny", "Herr Von Muellerhoff" => "Herr Von Muellerhoff", "Holtwood One SC" => "Holtwood One SC", "Homemade Apple" => "Homemade Apple", "Homenaje" => "Homenaje", "IM Fell DW Pica" => "IM Fell DW Pica", "IM Fell DW Pica SC" => "IM Fell DW Pica SC", "IM Fell Double Pica" => "IM Fell Double Pica", "IM Fell Double Pica SC" => "IM Fell Double Pica SC", "IM Fell English" => "IM Fell English", "IM Fell English SC" => "IM Fell English SC", "IM Fell French Canon" => "IM Fell French Canon", "IM Fell French Canon SC" => "IM Fell French Canon SC", "IM Fell Great Primer" => "IM Fell Great Primer", "IM Fell Great Primer SC" => "IM Fell Great Primer SC", "Iceberg" => "Iceberg", "Iceland" => "Iceland", "Imprima" => "Imprima", "Inconsolata" => "Inconsolata", "Inder" => "Inder", "Indie Flower" => "Indie Flower", "Inika" => "Inika", "Irish Grover" => "Irish Grover", "Istok Web" => "Istok Web", "Italiana" => "Italiana", "Italianno" => "Italianno", "Jacques Francois" => "Jacques Francois", "Jacques Francois Shadow" => "Jacques Francois Shadow", "Jim Nightshade" => "Jim Nightshade", "Jockey One" => "Jockey One", "Jolly Lodger" => "Jolly Lodger", "Josefin Sans" => "Josefin Sans", "Josefin Slab" => "Josefin Slab", "Joti One" => "Joti One", "Judson" => "Judson", "Julee" => "Julee", "Julius Sans One" => "Julius Sans One", "Junge" => "Junge", "Jura" => "Jura", "Just Another Hand" => "Just Another Hand", "Just Me Again Down Here" => "Just Me Again Down Here", "Kameron" => "Kameron", "Karla" => "Karla", "Kaushan Script" => "Kaushan Script", "Kavoon" => "Kavoon", "Keania One" => "Keania One", "Kelly Slab" => "Kelly Slab", "Kenia" => "Kenia", "Khmer" => "Khmer", "Kite One" => "Kite One", "Knewave" => "Knewave", "Kotta One" => "Kotta One", "Koulen" => "Koulen", "Kranky" => "Kranky", "Kreon" => "Kreon", "Kristi" => "Kristi", "Krona One" => "Krona One", "La Belle Aurore" => "La Belle Aurore", "Lancelot" => "Lancelot", "Lato" => "Lato", "League Script" => "League Script", "Leckerli One" => "Leckerli One", "Ledger" => "Ledger", "Lekton" => "Lekton", "Lemon" => "Lemon", "Libre Baskerville" => "Libre Baskerville", "Life Savers" => "Life Savers", "Lilita One" => "Lilita One", "Limelight" => "Limelight", "Linden Hill" => "Linden Hill", "Lobster" => "Lobster", "Lobster Two" => "Lobster Two", "Londrina Outline" => "Londrina Outline", "Londrina Shadow" => "Londrina Shadow", "Londrina Sketch" => "Londrina Sketch", "Londrina Solid" => "Londrina Solid", "Lora" => "Lora", "Love Ya Like A Sister" => "Love Ya Like A Sister", "Loved by the King" => "Loved by the King", "Lovers Quarrel" => "Lovers Quarrel", "Luckiest Guy" => "Luckiest Guy", "Lusitana" => "Lusitana", "Lustria" => "Lustria", "Macondo" => "Macondo", "Macondo Swash Caps" => "Macondo Swash Caps", "Magra" => "Magra", "Maiden Orange" => "Maiden Orange", "Mako" => "Mako", "Marcellus" => "Marcellus", "Marcellus SC" => "Marcellus SC", "Marck Script" => "Marck Script", "Margarine" => "Margarine", "Marko One" => "Marko One", "Marmelad" => "Marmelad", "Marvel" => "Marvel", "Mate" => "Mate", "Mate SC" => "Mate SC", "Maven Pro" => "Maven Pro", "McLaren" => "McLaren", "Meddon" => "Meddon", "MedievalSharp" => "MedievalSharp", "Medula One" => "Medula One", "Megrim" => "Megrim", "Meie Script" => "Meie Script", "Merienda" => "Merienda", "Merienda One" => "Merienda One", "Merriweather" => "Merriweather", "Merriweather Sans" => "Merriweather Sans", "Metal" => "Metal", "Metal Mania" => "Metal Mania", "Metamorphous" => "Metamorphous", "Metrophobic" => "Metrophobic", "Michroma" => "Michroma", "Milonga" => "Milonga", "Miltonian" => "Miltonian", "Miltonian Tattoo" => "Miltonian Tattoo", "Miniver" => "Miniver", "Miss Fajardose" => "Miss Fajardose", "Modern Antiqua" => "Modern Antiqua", "Molengo" => "Molengo", "Molle" => "Molle", "Monda" => "Monda", "Monofett" => "Monofett", "Monoton" => "Monoton", "Monsieur La Doulaise" => "Monsieur La Doulaise", "Montaga" => "Montaga", "Montez" => "Montez", "Montserrat" => "Montserrat", "Montserrat Alternates" => "Montserrat Alternates", "Montserrat Subrayada" => "Montserrat Subrayada", "Moul" => "Moul", "Moulpali" => "Moulpali", "Mountains of Christmas" => "Mountains of Christmas", "Mouse Memoirs" => "Mouse Memoirs", "Mr Bedfort" => "Mr Bedfort", "Mr Dafoe" => "Mr Dafoe", "Mr De Haviland" => "Mr De Haviland", "Mrs Saint Delafield" => "Mrs Saint Delafield", "Mrs Sheppards" => "Mrs Sheppards", "Muli" => "Muli", "Mystery Quest" => "Mystery Quest", "Neucha" => "Neucha", "Neuton" => "Neuton", "New Rocker" => "New Rocker", "News Cycle" => "News Cycle", "Niconne" => "Niconne", "Nixie One" => "Nixie One", "Nobile" => "Nobile", "Nokora" => "Nokora", "Norican" => "Norican", "Nosifer" => "Nosifer", "Nothing You Could Do" => "Nothing You Could Do", "Noticia Text" => "Noticia Text", "Nova Cut" => "Nova Cut", "Nova Flat" => "Nova Flat", "Nova Mono" => "Nova Mono", "Nova Oval" => "Nova Oval", "Nova Round" => "Nova Round", "Nova Script" => "Nova Script", "Nova Slim" => "Nova Slim", "Nova Square" => "Nova Square", "Numans" => "Numans", "Nunito" => "Nunito", "Odor Mean Chey" => "Odor Mean Chey", "Offside" => "Offside", "Old Standard TT" => "Old Standard TT", "Oldenburg" => "Oldenburg", "Oleo Script" => "Oleo Script", "Oleo Script Swash Caps" => "Oleo Script Swash Caps", "Open Sans" => "Open Sans", "Open Sans Condensed" => "Open Sans Condensed", "Oranienbaum" => "Oranienbaum", "Orbitron" => "Orbitron", "Oregano" => "Oregano", "Orienta" => "Orienta", "Original Surfer" => "Original Surfer", "Oswald" => "Oswald", "Over the Rainbow" => "Over the Rainbow", "Overlock" => "Overlock", "Overlock SC" => "Overlock SC", "Ovo" => "Ovo", "Oxygen" => "Oxygen", "Oxygen Mono" => "Oxygen Mono", "PT Mono" => "PT Mono", "PT Sans" => "PT Sans", "PT Sans Caption" => "PT Sans Caption", "PT Sans Narrow" => "PT Sans Narrow", "PT Serif" => "PT Serif", "PT Serif Caption" => "PT Serif Caption", "Pacifico" => "Pacifico", "Paprika" => "Paprika", "Parisienne" => "Parisienne", "Passero One" => "Passero One", "Passion One" => "Passion One", "Patrick Hand" => "Patrick Hand", "Patrick Hand SC" => "Patrick Hand SC", "Patua One" => "Patua One", "Paytone One" => "Paytone One", "Peralta" => "Peralta", "Permanent Marker" => "Permanent Marker", "Petit Formal Script" => "Petit Formal Script", "Petrona" => "Petrona", "Philosopher" => "Philosopher", "Piedra" => "Piedra", "Pinyon Script" => "Pinyon Script", "Pirata One" => "Pirata One", "Plaster" => "Plaster", "Play" => "Play", "Playball" => "Playball", "Playfair Display" => "Playfair Display", "Playfair Display SC" => "Playfair Display SC", "Podkova" => "Podkova", "Poiret One" => "Poiret One", "Poller One" => "Poller One", "Poly" => "Poly", "Pompiere" => "Pompiere", "Pontano Sans" => "Pontano Sans", "Port Lligat Sans" => "Port Lligat Sans", "Port Lligat Slab" => "Port Lligat Slab", "Prata" => "Prata", "Preahvihear" => "Preahvihear", "Press Start 2P" => "Press Start 2P", "Princess Sofia" => "Princess Sofia", "Prociono" => "Prociono", "Prosto One" => "Prosto One", "Puritan" => "Puritan", "Purple Purse" => "Purple Purse", "Quando" => "Quando", "Quantico" => "Quantico", "Quattrocento" => "Quattrocento", "Quattrocento Sans" => "Quattrocento Sans", "Questrial" => "Questrial", "Quicksand" => "Quicksand", "Quintessential" => "Quintessential", "Qwigley" => "Qwigley", "Racing Sans One" => "Racing Sans One", "Radley" => "Radley", "Raleway" => "Raleway", "Raleway Dots" => "Raleway Dots", "Rambla" => "Rambla", "Rammetto One" => "Rammetto One", "Ranchers" => "Ranchers", "Rancho" => "Rancho", "Rationale" => "Rationale", "Redressed" => "Redressed", "Reenie Beanie" => "Reenie Beanie", "Revalia" => "Revalia", "Ribeye" => "Ribeye", "Ribeye Marrow" => "Ribeye Marrow", "Righteous" => "Righteous", "Risque" => "Risque", "Roboto" => "Roboto", "Roboto Condensed" => "Roboto Condensed", "Rochester" => "Rochester", "Rock Salt" => "Rock Salt", "Rokkitt" => "Rokkitt", "Romanesco" => "Romanesco", "Ropa Sans" => "Ropa Sans", "Rosario" => "Rosario", "Rosarivo" => "Rosarivo", "Rouge Script" => "Rouge Script", "Ruda" => "Ruda", "Rufina" => "Rufina", "Ruge Boogie" => "Ruge Boogie", "Ruluko" => "Ruluko", "Rum Raisin" => "Rum Raisin", "Ruslan Display" => "Ruslan Display", "Russo One" => "Russo One", "Ruthie" => "Ruthie", "Rye" => "Rye", "Sacramento" => "Sacramento", "Sail" => "Sail", "Salsa" => "Salsa", "Sanchez" => "Sanchez", "Sancreek" => "Sancreek", "Sansita One" => "Sansita One", "Sarina" => "Sarina", "Satisfy" => "Satisfy", "Scada" => "Scada", "Schoolbell" => "Schoolbell", "Seaweed Script" => "Seaweed Script", "Sevillana" => "Sevillana", "Seymour One" => "Seymour One", "Shadows Into Light" => "Shadows Into Light", "Shadows Into Light Two" => "Shadows Into Light Two", "Shanti" => "Shanti", "Share" => "Share", "Share Tech" => "Share Tech", "Share Tech Mono" => "Share Tech Mono", "Shojumaru" => "Shojumaru", "Short Stack" => "Short Stack", "Siemreap" => "Siemreap", "Sigmar One" => "Sigmar One", "Signika" => "Signika", "Signika Negative" => "Signika Negative", "Simonetta" => "Simonetta", "Sintony" => "Sintony", "Sirin Stencil" => "Sirin Stencil", "Six Caps" => "Six Caps", "Skranji" => "Skranji", "Slackey" => "Slackey", "Smokum" => "Smokum", "Smythe" => "Smythe", "Sniglet" => "Sniglet", "Snippet" => "Snippet", "Snowburst One" => "Snowburst One", "Sofadi One" => "Sofadi One", "Sofia" => "Sofia", "Sonsie One" => "Sonsie One", "Sorts Mill Goudy" => "Sorts Mill Goudy", "Source Code Pro" => "Source Code Pro", "Source Sans Pro" => "Source Sans Pro", "Special Elite" => "Special Elite", "Spicy Rice" => "Spicy Rice", "Spinnaker" => "Spinnaker", "Spirax" => "Spirax", "Squada One" => "Squada One", "Stalemate" => "Stalemate", "Stalinist One" => "Stalinist One", "Stardos Stencil" => "Stardos Stencil", "Stint Ultra Condensed" => "Stint Ultra Condensed","Stint Ultra Expanded" => "Stint Ultra Expanded", "Stoke" => "Stoke", "Strait" => "Strait", "Sue Ellen Francisco" => "Sue Ellen Francisco", "Sunshiney" => "Sunshiney", "Supermercado One" => "Supermercado One", "Suwannaphum" => "Suwannaphum", "Swanky and Moo Moo" => "Swanky and Moo Moo", "Syncopate" => "Syncopate", "Tangerine" => "Tangerine", "Taprom" => "Taprom", "Tauri" => "Tauri", "Telex" => "Telex", "Tenor Sans" => "Tenor Sans", "Text Me One" => "Text Me One", "The Girl Next Door" => "The Girl Next Door", "Tienne" => "Tienne", "Tinos" => "Tinos", "Titan One" => "Titan One", "Titillium Web" => "Titillium Web", "Trade Winds" => "Trade Winds", "Trocchi" => "Trocchi", "Trochut" => "Trochut", "Trykker" => "Trykker", "Tulpen One" => "Tulpen One", "Ubuntu" => "Ubuntu", "Ubuntu Condensed" => "Ubuntu Condensed", "Ubuntu Mono" => "Ubuntu Mono", "Ultra" => "Ultra", "Uncial Antiqua" => "Uncial Antiqua", "Underdog" => "Underdog", "Unica One" => "Unica One", "UnifrakturCook" => "UnifrakturCook", "UnifrakturMaguntia" => "UnifrakturMaguntia", "Unkempt" => "Unkempt", "Unlock" => "Unlock", "Unna" => "Unna", "VT323" => "VT323", "Vampiro One" => "Vampiro One", "Varela" => "Varela", "Varela Round" => "Varela Round", "Vast Shadow" => "Vast Shadow", "Vibur" => "Vibur", "Vidaloka" => "Vidaloka", "Viga" => "Viga", "Voces" => "Voces", "Volkhov" => "Volkhov", "Vollkorn" => "Vollkorn", "Voltaire" => "Voltaire", "Waiting for the Sunrise" => "Waiting for the Sunrise", "Wallpoet" => "Wallpoet", "Walter Turncoat" => "Walter Turncoat", "Warnes" => "Warnes", "Wellfleet" => "Wellfleet", "Wendy One" => "Wendy One", "Wire One" => "Wire One", "Yanone Kaffeesatz" => "Yanone Kaffeesatz", "Yellowtail" => "Yellowtail", "Yeseva One" => "Yeseva One", "Yesteryear" => "Yesteryear", "Zeyada" => "Zeyada" );

global $of_options;
$of_options = array();

$of_options[] = array( 	"name" 		=> __('General Settings', 'portal'),
						"type" 		=> "heading"
				);
$of_options[] = array( 	"name" 		=> __('General Settings', 'portal'),
						"desc" 		=> "",
						"id" 		=> "generalsettings",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">".__('Welcome to the Theme Options', 'portal')."</h3>
						".__('Use this Theme Options page to setup your site. Save your option once you customize your portal Theme.', 'portal')."",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> __('Upload logo', 'portal'),
						"desc" 		=> __('Upload your logo using the native media uploader, or define the URL directly.', 'portal'),
						"id" 		=> "logo",
						"std" 		=> get_template_directory_uri() . '/images/logo.png',
						"type" 		=> "media"
				);

$of_options[] = array( 	"name" 		=> __('Style Settings', 'portal'),
						"type" 		=> "heading"
				);

$of_options[] = array( 	"name" 		=> __('Style Settings', 'portal'),
						"desc" 		=> "",
						"id" 		=> "stylesettings",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">".__('Style Settings', 'portal')."</h3>
						".__('Setup your portal Style. Choose menu type, colors and fonts.', 'portal')."",
						"icon" 		=> true,
						"type" 		=> "info"
				);

$of_options[] = array( 	"name" 		=> __('Header Menu Style', 'portal'),
						"desc" 		=> __('Select header menu style.', 'portal'),
						"id" 		=> "header_menu",
						"std" 		=> "portal_standard",
						"type" 		=> "select",
						"options" 	=> array(
										"portal_menu" => "portal_menu",
										"portal_standard" => "portal_standard"
						)
				);

$of_options[] = array( 	"name" 		=> __('Select body font', 'portal'),
						"desc" 		=> __('Selected main font is used for text on pages and posts.', 'portal'),
						"id" 		=> "font",
						"std" 		=> "Raleway",
						"type" 		=> "select_google_font",
						"preview" 	=> array(
										"text" => "Wordpress! ABCD abcd 123#",
										"size" => "30px"
						),
						"options" 	=> $fonts
				);
$of_options[] = array( 	"name" 		=> __('Select header font', 'portal'),
						"desc" 		=> __('Selected font used for post headers.', 'portal'),
						"id" 		=> "font_header",
						"std" 		=> "Raleway",
						"type" 		=> "select_google_font",
						"preview" 	=> array(
										"text" => "Wordpress! ABCD abcd 123#",
										"size" => "30px"
						),
						"options" 	=> $fonts
				);
$of_options[] = array( 	"name" 		=> __('Colors', 'portal'),
						"desc" 		=> "",
						"id" 		=> "stylesettingscolors",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">".__('Color Settings', 'portal')."</h3>
						".__('Setup the colors used with portal Theme. Achieve any style which fits your style.', 'portal')."",
						"icon" 		=> true,
						"type" 		=> "info"
				);

$of_options[] = array( 	"name" 		=> __('Theme Color', 'portal'),
						"desc" 		=> __('Select theme color. Default color code is #ef5a32.', 'portal'),
						"id" 		=> "theme_color",
						"std" 		=> "#ef5a32",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> __('Lighter Theme Color', 'portal'),
						"desc" 		=> __('Select lighter theme color. Default color code is #f27e62.', 'portal'),
						"id" 		=> "theme_color_light",
						"std" 		=> "#f27e62",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> __('Text Color', 'portal'),
						"desc" 		=> __('Select text color. Default color code is #333333.', 'portal'),
						"id" 		=> "text_color",
						"std" 		=> "#333333",
						"type" 		=> "color"
				);


$of_options[] = array( 	"name" 		=> __('Headers Color', 'portal'),
						"desc" 		=> __('Select headers color. Default color code is #222222.', 'portal'),
						"id" 		=> "headers_color",
						"std" 		=> "#222222",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> __('Menu Border', 'portal'),
						"desc" 		=> __('Select main menu border color. Default color code is #d9d9d9.', 'portal'),
						"id" 		=> "menu_border_color",
						"std" 		=> "#d9d9d9",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> __('Pale Color', 'portal'),
						"desc" 		=> __('Select pale color. Default color code is #a0a0a0.', 'portal'),
						"id" 		=> "pale_color",
						"std" 		=> "#a0a0a0",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> __('Color White', 'portal'),
						"desc" 		=> __('Select white color. Default color code is #ffffff.', 'portal'),
						"id" 		=> "white_color",
						"std" 		=> "#ffffff",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> __('Background Color White', 'portal'),
						"desc" 		=> __('Select background white color. Default color code is #ffffff.', 'portal'),
						"id" 		=> "bg_white_color",
						"std" 		=> "#ffffff",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> __('Background Color Pale', 'portal'),
						"desc" 		=> __('Select background pale color. Default color code is #a0a0a0.', 'portal'),
						"id" 		=> "bg_pale_color",
						"std" 		=> "#a0a0a0",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> __('Background Color Default', 'portal'),
						"desc" 		=> __('Select background default color. Default color code is #222222.', 'portal'),
						"id" 		=> "bg_default_color",
						"std" 		=> "#222222",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> __('Border Color Default', 'portal'),
						"desc" 		=> __('Select default border color. Default color code is #222222.', 'portal'),
						"id" 		=> "border_default_color",
						"std" 		=> "#222222",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> __('Border Color Pale', 'portal'),
						"desc" 		=> __('Select pale border color. Default color code is #dddddd.', 'portal'),
						"id" 		=> "border_pale_color",
						"std" 		=> "#dddddd",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> __('Page Background Color', 'portal'),
						"desc" 		=> __('Select page background color. Default color code is #ffffff.', 'portal'),
						"id" 		=> "page_background",
						"std" 		=> "#ffffff",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> __('Pagination Background Color', 'portal'),
						"desc" 		=> __('Select pagination background color. Default color code is #eeeeee.', 'portal'),
						"id" 		=> "pagination_background",
						"std" 		=> "#eeeeee",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> __('Footer Background', 'portal'),
						"desc" 		=> __('Select footer background color. Default color code is #222222.', 'portal'),
						"id" 		=> "footer_background",
						"std" 		=> "#222222",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> __('Footer Background', 'portal'),
						"desc" 		=> __('Select footer background color. Default color code is #ffffff.', 'portal'),
						"id" 		=> "footer_text",
						"std" 		=> "#ffffff",
						"type" 		=> "color"
				);

$of_options[] = array( 	"name" 		=> __('Layout Settings', 'portal'),
						"type" 		=> "heading"
				);
$of_options[] = array( 	"name" 		=> __('Layout Settings Settings', 'portal'),
						"desc" 		=> "",
						"id" 		=> "layoutsettings",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">".__('Layout Settings', 'portal')."</h3>
						".__('Set your layout. Set up your default margins used in the portal Theme.', 'portal')."",
						"icon" 		=> true,
						"type" 		=> "info"
				);

$of_options[] = array( 	"name" 		=> __('Default Bottom Margin', 'portal'),
						"desc" 		=> __('Set the default bottom margin on all elements. Default 20px.', 'portal'),
						"id" 		=> "fb_bmargin",
						"std" 		=> "30",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"type" 		=> "sliderui"
				);

$of_options[] = array( 	"name" 		=> __('Content Width / Responsive', 'portal'),
						"desc" 		=> "",
						"id" 		=> "fb_hres",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">".__('Responsive Content Resolution', 'portal')."</h3>
						".__('Setup your responsive break points. These settings define your layout width on various screen sizes and devices.', 'portal')."",
						"icon" 		=> true,
						"type" 		=> "info"
				);

$of_options[] = array( 	"name" 		=> __('Content Width / High Resolution', 'portal'),
						"desc" 		=> __('Responsive width for high resolutions. Default value 1200px.', 'portal'),
						"id" 		=> "content_width",
						"std" 		=> "1200",
						"min" 		=> "960",
						"step"		=> "1",
						"max" 		=> "1200",
						"type" 		=> "sliderui" 
				);
$of_options[] = array( 	"name" 		=> __('Column Margins', 'portal'),
						"desc" 		=> __('Column margins for high resolutions. Default value 20px.', 'portal'),
						"id" 		=> "fb_hres_c",
						"std" 		=> "30",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "60",
						"type" 		=> "sliderui"
				);

$of_options[] = array( 	"name" 		=> __('Medium Resolution', 'portal'),
						"desc" 		=> __('Responsive width for medium resolutions. Default value 768px.', 'portal'),
						"id" 		=> "fb_mres_w",
						"std" 		=> "768",
						"min" 		=> "480",
						"step"		=> "1",
						"max" 		=> "1200",
						"type" 		=> "sliderui" 
				);
$of_options[] = array( 	"name" 		=> __('Column Margins', 'portal'),
						"desc" 		=> __('Column margins for medium resolutions. Default value 10px.', 'portal'),
						"id" 		=> "fb_mres_c",
						"std" 		=> "20",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "60",
						"type" 		=> "sliderui" 
				);
$of_options[] = array( 	"name" 		=> __("Hide Sidebars", "portal"),
						"desc" 		=> __("Hide sidebars after current width.", "portal"),
						"id" 		=> "fb_mres_s",
						"std" 		=> 0,
						"type" 		=> "switch"
				);

$of_options[] = array( 	"name" 		=> __('Low Resolution', 'portal'),
						"desc" 		=> __('Responsive width for low resolutions. Default value 640px.', 'portal'),
						"id" 		=> "fb_lres_w",
						"std" 		=> "640",
						"min" 		=> "320",
						"step"		=> "1",
						"max" 		=> "1200",
						"type" 		=> "sliderui" 
				);
$of_options[] = array( 	"name" 		=> __('Column Margins', 'portal'),
						"desc" 		=> __('Column margins for low resolutions. Default value 5px.', 'portal'),
						"id" 		=> "fb_lres_c",
						"std" 		=> "10",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "60",
						"type" 		=> "sliderui" 
				);
$of_options[] = array( 	"name" 		=> __("Hide Sidebars", "portal"),
						"desc" 		=> __("Hide sidebars after current width.", "portal"),
						"id" 		=> "fb_lres_s",
						"std" 		=> 1,
						"type" 		=> "switch"
				);

$of_options[] = array( 	"name" 		=> __('Sidebar Settings', 'portal'),
						"type" 		=> "heading"
				);

$of_options[] = array( 	"name" 		=> __('Sidebars', 'portal'),
						"desc" 		=> "",
						"id" 		=> "sidebarsettingssidebars",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">".__('Sidebar Manager', 'portal')."</h3>
						".__('Create new sidebars to use in your pages and posts. Create unlimited number of sidebars and use them in Frontend Builder via Sidebar element.', 'portal')."",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> __('Sidebars', 'portal'),
						"desc" 		=> __('Unlimited sidebars for your pages/posts.', 'portal'),
						"id" 		=> "sidebar",
						"std" 		=> array(
										1 => array(
											'order' => 1,
											'title' => 'Your first Sidebar!'
									)
						),
						"type" 		=> "sidebar"
				);
$of_options[] = array( 	"name" 		=> __('Footer Settings', 'portal'),
						"type" 		=> "heading"
				);
$of_options[] = array( 	"name" 		=> __('Footer Settings', 'portal'),
						"desc" 		=> "",
						"id" 		=> "footersettings",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">".__('Footer Settings', 'portal')."</h3>
						".__('Choose footer columns. Set up the copyright text.', 'portal')."",
						"icon" 		=> true,
						"type" 		=> "info"
				);

$of_options[] = array( 	"name" 		=> __("Disable Footer Widget Areas", "portal"),
						"desc" 		=> __("This option will disable footer widget areas.", "portal"),
						"id" 		=> "footer_widgets",
						"std" 		=> 0,
						"type" 		=> "switch"
				);
$of_options[] = array( 	"name" 		=> __('Footer Widget Areas', 'portal'),
						"desc" 		=> __('Select number of footer widget areas.', 'portal'),
						"id" 		=> "footer_sidebar",
						"std" 		=> "4",
						"type" 		=> "select",
						"options" 	=> array(
										"1" => "1",
										"2" => "2",
										"3" => "3",
										"4" => "4"
						)
				);
$of_options[] = array( 	"name" 		=> __('Copyright Text', 'portal'),
						"desc" 		=> __('Enter copyright text that will appear in footer.', 'portal'),
						"id" 		=> "copyright",
						"std" 		=> "Copyright: <a href='#'>Shindiri Studio</a>, All Rights Reserved. May, 2014",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> __("Facebook URL", "portal"),
						"desc" 		=> __("Enter your Facebook URL e.g. http://www.facebook.com/user/", "portal"),
						"id" 		=> "footer-facebook",
						"std" 		=> '#',
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> __("Twitter URL", "portal"),
						"desc" 		=> __("Enter your Twitter URL e.g. http://www.twitter.com/user/", "portal"),
						"id" 		=> "footer-twitter",
						"std" 		=> '#',
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> __("Google+ URL", "portal"),
						"desc" 		=> __("Enter your Google+ URL e.g. http://www.googleplus.com/user/", "portal"),
						"id" 		=> "footer-google",
						"std" 		=> '#',
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> __("LinkedIn URL", "portal"),
						"desc" 		=> __("Enter your LinkedIn URL e.g. http://www.linkedin.com/user/", "portal"),
						"id" 		=> "footer-linkedin",
						"std" 		=> '#',
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> __("Pinterest URL", "portal"),
						"desc" 		=> __("Enter your Pinterest URL e.g. http://www.pinterest.com/user/", "portal"),
						"id" 		=> "footer-pin",
						"std" 		=> '#',
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> __("Youtube URL", "portal"),
						"desc" 		=> __("Enter your Youtube URL e.g. http://www.youtube.com/user/", "portal"),
						"id" 		=> "footer-youtube",
						"std" 		=> '#',
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> __('Contact Settings', 'portal'),
						"type" 		=> "heading"
				);
$of_options[] = array( 	"name" 		=> __('Contact Form Custom Message', 'portal'),
						"desc" 		=> "",
						"id" 		=> "contactsettingsemail",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">" . __('Contact Form Custom Message', 'portal') . "</h3>" .
						__('Set your Contact Form custom message. This message will appear once the E-Mail is sent.', 'portal'),
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> __('Contact Form Custom Message', 'portal'),
						"desc" 		=> __('Enter cutom HTML/Text.', 'portal'),
						"id" 		=> "contactform_message",
						"std" 		=> "",
						"type" 		=> "textarea"
				);
$of_options[] = array( 	"name" 		=> __('Contact Settings', 'portal'),
						"desc" 		=> "",
						"id" 		=> "contactsettings",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">" . __('Contact Settings', 'portal') . "</h3>" .
						__('Setup your team members.', 'portal'),
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> __('Contact Settings / Team Members', 'portal'),
						"desc" 		=> __('Add or remove contact options/team members. You can use this entries later in your content as Team element or Contact Form element.', 'portal'),
						"id" 		=> "contact",
						"std" 		=> array(
										1 => array (
											'order' => 1,
											'name' => 'Your first Contact!',
											'url' => get_template_directory_uri() . '/images/logo.png',
											'job' => 'designer',
											'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
											'email' => 'google@gmail.com',
											'contact' => array (
												1 => array (
													'socialnetworksurl' => '#',
													'socialnetworks' => 'ds_facebook.png'
												)
											)
										)
						),
						"type" 		=> "contact"
				);

$of_options[] = array( 	"name" 		=> __('Twitter Settings', 'portal'),
						"type" 		=> "heading"
				);

$of_options[] = array( 	"name" 		=> __('Twitter Settings', 'portal'),
						"desc" 		=> "",
						"id" 		=> "advancedsettings",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">".__('Twitter Settings', 'portal')."</h3>
						".__('Set custom Twitter API keys. Go to <a href="http://dev.twitter.com/" target="_blank">Twitter Developer pages</a> to get your secure keys.', 'portal')."",
						"icon" 		=> true,
						"type" 		=> "info"
				);

$of_options[] = array( 	"name" 		=> __('Consumer Key', 'portal'),
						"desc" 		=> __('Consumer key provided by dev.twitter.com', 'portal'),
						"id" 		=> "twitter_ck",
						"std" 		=> "iRJW8Yi5RlCCFWfen2dg",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> __('Consumer Secret', 'portal'),
						"desc" 		=> __('Consumer secret provided by dev.twitter.com', 'portal'),
						"id" 		=> "twitter_cs",
						"std" 		=> "clLgN3meKBRAbHC8nR5rlXIVa2JkdoEKoEyKTXwthc",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> __('Access token', 'portal'),
						"desc" 		=> __('Access token provided by dev.twitter.com', 'portal'),
						"id" 		=> "twitter_at",
						"std" 		=> "966576138-qo63Ci3BiKDaiFWo1HcolrlFTdgU6ifZLBqwIsYL",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> __('Access token secret', 'portal'),
						"desc" 		=> __('Access token secret provided by dev.twitter.com', 'portal'),
						"id" 		=> "twitter_ats",
						"std" 		=> "sA8h9DFFN8HwiYJjBhQSg4oOKw50BGmraqcKODnf5yKmN",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> __('Advanced Settings', 'portal'),
						"type" 		=> "heading"
				);
					
$of_options[] = array( 	"name" 		=> __('Advanced Settings', 'portal'),
						"desc" 		=> "",
						"id" 		=> "advancedsettings",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">".__('Advanced Settings', 'portal')."</h3>
						".__('Set custom CSS classes, Google Analytics code.', 'portal')."",
						"icon" 		=> true,
						"type" 		=> "info"
				);
$of_options[] = array( 	"name" 		=> __("Enable Comments on Pages", "portal"),
						"desc" 		=> __("If you need comments on pages please enable this switch.", "portal"),
						"id" 		=> "enable_comments",
						"std" 		=> 0,
						"type" 		=> "switch"
				);

$of_options[] = array( 	"name" 		=> __("Responsive / Fixed Layout", "portal"),
						"desc" 		=> __("Enable Responsive layout or use Fixed layout insted.", "portal"),
						"id" 		=> "responsive",
						"std" 		=> 1,
						"on" 		=> "Responsive",
						"off" 		=> "Fixed",
						"type" 		=> "switch",
				);
$of_options[] = array( 	"name" 		=> __("Service Mode", "portal"),
						"desc" 		=> __("Enable Theme Settings Bar on site. This is used for theme displays and previews. It will enable visiting user to set custom colors, widths or layouts.", "portal"),
						"id" 		=> "service_mode",
						"std" 		=> 0,
						"type" 		=> "switch"
				);

$of_options[] = array( 	"name" 		=> __('Tracking Code', 'portal'),
						"desc" 		=> __('Paste your Google Analytics (or other) tracking code here. This will be added into the header of your site.', 'portal'),
						"id" 		=> "tracking-code",
						"std" 		=> "",
						"type" 		=> "textarea"
				);

$of_options[] = array( 	"name" 		=> __('Custom CSS', 'portal'),
						"desc" 		=> __('Quickly add some CSS to your theme by adding it to this block.', 'portal'),
						"id" 		=> "custom-css",
						"std" 		=> "",
						"type" 		=> "textarea"
				);

if ( !get_transient('PortalWP_Demo_Remove') ) {
	$of_options[] = array( 	"name" 		=> __('Demo Installation', 'portal'),
							"type" 		=> "heading"
					);
	$of_options[] = array( 	"name" 		=> __('Demo Installation', 'portal'),
							"desc" 		=> "",
							"id" 		=> "demoinstallation",
							"std" 		=> "<h3 style=\"margin: 0 0 10px;\">".__('Install PortalWP demo content', 'portal')."</h3><h5><span class='red'>".__("IMPORTANT",'portal')."</span></h5>
							".__('Demo content can only be installed on a clean Wordpress installation. If you have any posts/pages do not install demo as it will overwrite all your posts and pages. Make sure that your Wordpress version is 3.8 or newer.', 'portal'),
							"icon" 		=> true,
							"type" 		=> "info"
					);

	$of_options[] = array( 	"name" 		=> __('Step 1', 'portal'),
							"desc" 		=> "",
							"id" 		=> "demo_plugins_h",
							"std" 		=> "<h3 style=\"margin: 0 0 10px;\">".__('Step 1 - Plugins', 'portal')."</h3>
							".__('Install and activate all the plugins used by PortalWP Theme.', 'portal')."",
							"icon" 		=> true,
							"type" 		=> "info"
					);

	$of_options[] = array( 	"name" 		=> __('Installed Plugins', 'portal'),
							"desc" 		=> __('This list shows needed plugins. Please install and activate all the plugins before you continue with the demo installation.', 'portal'),
							"id" 		=> "demo_plugins",
							"std" 		=> "",
							"type" 		=> "demoplugins"
					);

	$of_options[] = array( 	"name" 		=> __('Step 2', 'portal'),
							"desc" 		=> "",
							"id" 		=> "demo_images_h",
							"std" 		=> "<h3 style=\"margin: 0 0 10px;\">".__('Step 2 - Images', 'portal')."</h3>
							".__('Download images used in the demo content.', 'portal')."",
							"icon" 		=> true,
							"type" 		=> "info"
					);

	$of_options[] = array( 	"name" 		=> __('Download Images', 'portal'),
							"desc" 		=> __('If you cannot see all of the images on left then your installation has failed due to an error caused by max_execution_time of your server. Either contact your service provider or try uploading the file again and again until you can see all the images.', 'portal'),
							"id" 		=> "demo_images",
							"std" 		=> "",
							"type" 		=> "demoimages"
					);

	$of_options[] = array( 	"name" 		=> __('Step 3', 'portal'),
							"desc" 		=> "",
							"id" 		=> "demo_content_h",
							"std" 		=> "<h3 style=\"margin: 0 0 10px;\">".__('Step 3 - Demo Content', 'portal')."</h3>
							".__('One click demo installation. Please make sure you have completed the previous two steps!', 'portal')."",
							"icon" 		=> true,
							"type" 		=> "info"
					);

	$of_options[] = array( 	"name" 		=> __('Demo Content', 'portal'),
							"desc" 		=> __('Click the Install Demo Content button to make your site look just like our PortalWP Demo', 'portal').' <a href="http://www.shindiristudio.com/demo/?item=Portal_Wordpress">'.__('LINK', 'portal').'</a>',
							"id" 		=> "demo_content",
							"std" 		=> "",
							"type" 		=> "democontent"
					);

	$of_options[] = array( 	"name" 		=> __('Remove Demo', 'portal'),
							"desc" 		=> "",
							"id" 		=> "demoinstallation",
							"std" 		=> "<h3 style=\"margin: 0 0 10px;\">".__('Notice', 'portal')."</h3><h5><span class='red'>".__("IMPORTANT",'portal')."</span></h5>
							".__('If you do not want to use the Demo Content and you wish this option to be removed from the PortalWP Theme options panel click the Remove Demo Tab button.', 'portal')."<br/><br/><a href='#' id='demo_remove' class='button-primary'>".__('Remove Demo Tab', 'portal')."</a>",
							"icon" 		=> true,
							"type" 		=> "info"
					);
}


$of_options[] = array( 	"name" 		=> __("Backup Options", 'portal'),
						"type" 		=> "heading"
				);
$of_options[] = array( 	"name" 		=> __('"Backup and Restore Options"', 'portal'),
						"id" 		=> "of_backup",
						"std" 		=> "",
						"type" 		=> "backup",
						"desc" 		=> __('You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.', 'portal'),
				);

$of_options[] = array( 	"name" 		=> __("Transfer Theme Options Data", 'portal'),
						"id" 		=> "of_transfer",
						"std" 		=> "",
						"type" 		=> "transfer",
						"desc" 		=> __('You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".', 'portal'),
				);
				
	}//End function: of_options()
}//End chack if function exists: of_options()
?>