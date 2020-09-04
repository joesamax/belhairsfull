<?php
namespace BinaryCarpenter\BC_ATC;

use \BinaryCarpenter\BC_ATC\Config as Config;
use BinaryCarpenter\BC_ATC\Activation as Activation;
use \BinaryCarpenter\BC_ATC\BC_Static_UI as Static_UI;

?>

<div id="bc-uatc-welcome-page">
    <div class="bc-uk-container">
        <div class="bc-uk-flex bc-uk-grid">

            <div class="bc-uk-width-1-2">

                <h2>Thanks for using Ultimate Add To Cart Button For WooCommerce!</h2>

                <p>To get instant support, please drop me an email at <a href="mailto:dat.tm24@gmail.com">dat.tm24@gmail.com</a> </p>
                <p><strong>VERY IMPORTANT!</strong> To watch the tutorials on how to use the plugin, please <a href="https://www.youtube.com/playlist?list=PL6rw2AEN42Eqa_4OnTBlkaRTbg4jM3fz8">click here</a></p>

                <?php if (!Config::BC_ULTIMATE_ATC_IS_PRO): ?>
                    <h3>Upgrade to pro version for more features</h3>
                    <p>Upgrading to the pro version enable you to get some essential features such as:</p>
                    <ol>
                        <li>Use images as button's icon</li>
                        <li>Get access to more icons</li>
                        <li>Enable ajax add to cart for all buttons, even in product page</li>
                    </ol>

                    <a href="https://binarycarpenter.com/ultimate-add-to-cart-button-for-woocommerce/?src=upgrade-button-free" class="button button-primary">Upgrade now</a>
                <?php else: ?>


                    <?php
                    //try to activate here if it's pro
                    if (Config::BC_ULTIMATE_ATC_IS_PRO)
                    {
                        $activation_result = json_decode(Activation::activate(Config::KEY_CHECK_OPTION));

                        Static_UI::notice($activation_result->message, 'info', false, true);
                    }

                    ?>



                <?php endif; ?>
            </div>




            <div  class="bc-uk-width-1-2">
                <h3>Recommended plugins</h3>
                <div id="bc-recommended-products">

                </div>

            </div>
        </div>


    </div>
</div>
