<?php global $uatcOptions; ?>
<div id="uatc-manager">
<div id="create-styles" class="bc-box">
    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
                <h3>Created styles</h3>
                <ul id="created-styles">
                    <?php
                    $themes = get_posts([
                        'post_type' => BC_ULTIMATE_ATC_CUSTOM_THEME,
                        'post_status' => 'publish',
                        'numberposts' => -1

                        // 'order'    => 'ASC'
                    ]);

                    foreach ($themes as $theme)
                    {
                        ?>
                        <li data-id="<?php echo $theme->ID; ?>"><i class="fa fa-pencil edit-theme"></i> <i class="fa fa-trash trash-theme"></i><?php echo $theme->post_title; ?></li>

                        <?php
                    }


                    ?>

                </ul>
            </div>
            <div class="col-10">
                <h1>Create your own styles below</h1>

                <label for="">Set the style class</label>
                <p class="bc-atc-explain">The CSS class of your style, no space or special character allowed (dash and underscore are fine)</p>
                <input type="text" placeholder="enter your style class, no space or special characters allowed" id="style-class">

                <label for="">Enter a friendly name</label>
                <input type="text" placeholder="enter your style class" id="style-name">

                <label for="">CSS code for the style</label>
                <p class="bc-atc-explain">You can enter your custom CSS here. You can set anything you like. The list of classes below are the ones you need to style the elements:</p>
                <ul>
                    <li></li>
                </ul>

                <textarea name="" id="uatc-code-box" cols="30" rows="10"><?php echo BC_ATC_Options::bc_atc_get_option($uatcOptions, 'customCSS'); ?></textarea>

                <button class="button button-primary">Save style</button>

            </div>

        </div>

    </div>

</div>

</div>