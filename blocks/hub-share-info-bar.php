<?php
/**
 * Block template for HUB Share Info Bar.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="share-info-bar">
    <div class="container py-5">
        <div class="row g-3 justify-content-center text-center">
            <div class="col-md-4">
                <h2>Share price</h2>
                <div class="share-info-bar__value"><?= wp_kses_post( get_field( 'share_price' ) ); ?></div>
            </div>
            <div class="col-md-4">
                <h2>NAV per share</h2>
                <div class="share-info-bar__value"><?= wp_kses_post( get_field( 'nav_per_share' ) ); ?></div>
            </div>
            <div class="col-md-4">
                <h2>NAV of fund</h2>
                <div class="share-info-bar__value"><?= wp_kses_post( get_field( 'nav_of_fund' ) ); ?></div>
            </div>
        </div>
    </div>
</section>