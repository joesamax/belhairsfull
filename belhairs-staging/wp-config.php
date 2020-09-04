<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'db819636783' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'dbo819636783' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', 'Pa$$w0rdkaechung$' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'db819636783.hosting-data.io' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         's$CTR}~q(%k8ZLYXZ)D^&-BVY|k42=Q|@~J_yQPw)v1VW~(rfT*8I!y%}Q_`9sM<' );
define( 'SECURE_AUTH_KEY',  ',t.`zTaL$q]hNG K8<Rn1oLXM;r]xb7N<n^Lm+0Mpc!9}?W6OP4rRTgL}aCee`{+' );
define( 'LOGGED_IN_KEY',    '$#|7*iaIxL*4b6Z4v..82-}0DyB]cqdL;$/%m<,Mf/0)F8)2Zs]igIG8_4]oN4G]' );
define( 'NONCE_KEY',        'C4H<aI~h?^^q uNX,;APrV<06>sZh7dH%ls+L&uWes/fl` ?YcL2js&e1pbuUNi)' );
define( 'AUTH_SALT',        '4g8<Cak_O4]wxt8O3g6g06K8t`xX(G]j@[;!VlF*n5=(8*57g64bT{q]Zz1HRV=W' );
define( 'SECURE_AUTH_SALT', 'K_NB`)M^]{K+NLou(lC_+3uP}ow<UQ#-QP%GsniT=CA8j3S1PGf^8fC?a_%Mx0*o' );
define( 'LOGGED_IN_SALT',   '0&I?0Hg+AAdD9P0VK;4%^~jffuL_ f{J4#gH)1l_=Ven:<,)Ef/#)Qsn&WmF[0l=' );
define( 'NONCE_SALT',       'gHW3rqEr1aZF=lPmB6`~:iwkYHT8vo,e8ifM])LGb%7y0ypb(:=1?9}CE2ApWtE;' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wpstg0_'; // Changed by WP Staging

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
define('UPLOADS', 'wp-content/uploads'); 
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );
