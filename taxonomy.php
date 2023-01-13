<?php

/*---------------------------[ START ]---------------------------*/
echo '<pre class="debug" style="
                        background-color: rgba(0,0,0,0.8);
                        display: inline-block;
                        border: 5px solid springgreen;
                        color: white;
                        padding: 1rem;">';
            
            var_dump('taxonomy');
            echo '</pre>';
            die;
/*---------------------------[ END ]---------------------------*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

wc_get_template( 'archive-product.php' );
