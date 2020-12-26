<?php
/**
 * Cấu hình cơ bản cho WordPress
 *
 * Trong quá trình cài đặt, file "wp-config.php" sẽ được tạo dựa trên nội dung 
 * mẫu của file này. Bạn không bắt buộc phải sử dụng giao diện web để cài đặt, 
 * chỉ cần lưu file này lại với tên "wp-config.php" và điền các thông tin cần thiết.
 *
 * File này chứa các thiết lập sau:
 *
 * * Thiết lập MySQL
 * * Các khóa bí mật
 * * Tiền tố cho các bảng database
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Thiết lập MySQL - Bạn có thể lấy các thông tin này từ host/server ** //
/** Tên database MySQL */
define( 'DB_NAME', 'wordpress' );

/** Username của database */
define( 'DB_USER', 'root' );

/** Mật khẩu của database */
define( 'DB_PASSWORD', '' );

/** Hostname của database */
define( 'DB_HOST', 'localhost' );

/** Database charset sử dụng để tạo bảng database. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Kiểu database collate. Đừng thay đổi nếu không hiểu rõ. */
define('DB_COLLATE', '');

/**#@+
 * Khóa xác thực và salt.
 *
 * Thay đổi các giá trị dưới đây thành các khóa không trùng nhau!
 * Bạn có thể tạo ra các khóa này bằng công cụ
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Bạn có thể thay đổi chúng bất cứ lúc nào để vô hiệu hóa tất cả
 * các cookie hiện có. Điều này sẽ buộc tất cả người dùng phải đăng nhập lại.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '+G*;2.c*I8X+c!bxQ]O3%=@o^FHB6N+zY- G:WAsT|!%17uxP7gXCx[>[&M&V@,+' );
define( 'SECURE_AUTH_KEY',  '2gOWE-s7+5&`)C%siB)~#IRnGEK:/`kY*pL(Ea`X].#`JgX7zz5u9q/LjV3K7%V#' );
define( 'LOGGED_IN_KEY',    'kjyKz`cJvsz^yTas=zx4xV}Y8gQt3mW1^hvZsNK|q)2K0mv5-upDnN=p9&Uy#wf-' );
define( 'NONCE_KEY',        '_[Pb]Nc;_,}%U1;#B`<.V*snW~w HjPZ:l={n>G&V7|k)2T1A RQ{{~Dx<VlRRF<' );
define( 'AUTH_SALT',        'MK-(:aKGYwSt9$x~^kJ@okaEB2@+0TLM%G?+]79n/X d&L,j)p(XD#kZ/PBh9)xj' );
define( 'SECURE_AUTH_SALT', '&3AQ4W`h)ro#A}$0e7gA.nU1ivA3U::]ZR3K|zAUn4BGJ#HU)jxn%E~;T]V;Iy.|' );
define( 'LOGGED_IN_SALT',   'p5JH(U{e2(?#9Y6A1V;}bl=NavyKEP;2}=Q67_Gx]&BCp09:gs+sCV!/6jrHBJi[' );
define( 'NONCE_SALT',       'O@E}Q7X?(i+Ch6WR`EX`k&1 t>k`M@mbnb(R-5hZsl,h*Ucp|,I-@%(3;U.mA_hK' );

/**#@-*/

/**
 * Tiền tố cho bảng database.
 *
 * Đặt tiền tố cho bảng giúp bạn có thể cài nhiều site WordPress vào cùng một database.
 * Chỉ sử dụng số, ký tự và dấu gạch dưới!
 */
$table_prefix = 'wp_';

/**
 * Dành cho developer: Chế độ debug.
 *
 * Thay đổi hằng số này thành true sẽ làm hiện lên các thông báo trong quá trình phát triển.
 * Chúng tôi khuyến cáo các developer sử dụng WP_DEBUG trong quá trình phát triển plugin và theme.
 *
 * Để có thông tin về các hằng số khác có thể sử dụng khi debug, hãy xem tại Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);

/* Đó là tất cả thiết lập, ngưng sửa từ phần này trở xuống. Chúc bạn viết blog vui vẻ. */

/** Đường dẫn tuyệt đối đến thư mục cài đặt WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Thiết lập biến và include file. */
require_once(ABSPATH . 'wp-settings.php');
