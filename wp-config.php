<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'inclua_v2' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'root' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', '' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'UPsV)194uy~nyhc,U8T5C7W(!*5?%[f&%F >*No*f=*5?6^KphNiLOya%L9huplS' );
define( 'SECURE_AUTH_KEY',  '6o!xN{CDk;H+w~9hhd[628M]Bkvyr*U*t04*=u+^1X1T`x(*ST&00.?+,of?g`45' );
define( 'LOGGED_IN_KEY',    '?@xVI<^X#-.n`2V:Z</6rl;BJtblSa[GJ*sadGxzt*<`ic*LPJI@LMdJBePnHpVh' );
define( 'NONCE_KEY',        'SX^YjG}kj 6$GUK.d)*9}M#VAo;>:T>3Uw+]th zg6X@89UK,j< z}kr@%1P% F[' );
define( 'AUTH_SALT',        'W&Y$hG+k0AL6G=|Ue(3n(^pdb?vJ35rU-~@Gt$F1f*6gS(a:hhRXoD3w%v~>fHWy' );
define( 'SECURE_AUTH_SALT', 'U>;.T{7v5G1/*Bo-$e??lYTTG?5HPi6A(Mx[)]?6O]el*@-<Wb%ldSYx>=~a@T9c' );
define( 'LOGGED_IN_SALT',   'dZjG&%;6vHM~xt1d4vnELe7Fdv`@h3B~E;U6>{]Uh yl PMf [.I!^:7Jfdxj~H#' );
define( 'NONCE_SALT',       'P)vm;aXUuL 5bQ_~]6cro23,2S9@kPg7ySSo2U*>*Vk`GmG-V|^io=?|C6bBQiD;' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
