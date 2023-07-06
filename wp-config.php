<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link https://fr.wordpress.org/support/article/editing-wp-config-php/ Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'delta-theme-wp23' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'e%@56sz~dlPHo(B?D^CS5`;iMBfR<}(C:NNa>4-Y-&n2d>UH>@av5:6-6=n)wCeO' );
define( 'SECURE_AUTH_KEY',  ':f8=?9%Uxee$N8+}Ajn,wCWH<vF}vW;>g1Wg/vHA&F_Ra]QLQNGRDN^HQ;J+l5D%' );
define( 'LOGGED_IN_KEY',    '=&j-He8#O2}g[[6Dc|AFppgK~_vtcvNn%+?*U~o^dO~fp%ZoAoSzK0wAD?#I$cUs' );
define( 'NONCE_KEY',        'a_lZVa{;rubeyXbJe[nTn~NqHL{(mn&;4 |=,RzMHYl|MmDnOP[0P?UaZrtvS6R1' );
define( 'AUTH_SALT',        'j&kf0EDk]Jap;&eg<o~UV!&[d_=+N<JOL3;p> :+WM<cH[6Bnfy?vX*>6fhYtz+d' );
define( 'SECURE_AUTH_SALT', 'lVoY8F%<LJ.00lJnw8HvyFI/>*,,yB:4OzT|BOGH0DRQ|nF($O1e!kq11T= b<TJ' );
define( 'LOGGED_IN_SALT',   'KtUq?^|i!|Re;47IRU]LmU,U:WetMf*4QXstac1.Z4S7vx3MgZw;]~ft_wgmd<+3' );
define( 'NONCE_SALT',       ';NuG^?v:]02}UrN2c:j-GQHNut:zN2-M!Xpx{aW5+0q$I2rkZ`C )uUOFpZMdK$,' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'w465p_';

/**
 * Pour les développeurs et développeuses : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur la documentation.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define('WP_DEBUG', true);

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
