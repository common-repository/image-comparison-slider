<?php
for ($i = 0; $i < 2; $i++) {
    if (empty($data_tables[$i]['bs_img_comparison_pic']))
        $data_tables[$i]['bs_img_comparison_pic'] = '';
    if($i==0){
        $msg="Before Image";
        $name='bs_img_comparison_before';
    }else{  
        $msg="After Image";
        $name='bs_img_comparison_after';
    }
    ?>
    <div class="bs_image_comparison">
        <h3 class="img_comparison"><?php echo $msg ?></h3>
        <div class="bs_image_comparison_des">
            <div class="bs_image_comparison_left">
                <label class="bs_price_table_label" ><?php echo $msg;?></label>
            </div>
            <div class="bs_image_comparison_right">
                <input class="price_table_cl bs_img_value_<?= $i ?>" type="text" value="<?= esc_attr($data_tables[$i][$name]); ?>" disabled></input>
                <input class="price_table_cl bs_img_value_<?= $i ?>" type="hidden" name="<?= 'bs_image_comparison_group[' . $i . ']['.$name.']'; ?>" value="<?= $data_tables[$i][$name]; ?>"></input>

                <a href="#" id='bs_add_image_comparison_<?= $i ?>' class="bs_image_comparison_btn">Upload</a>
            </div>
            <?php //echo $data_tables[$i][$name];?>
            <div class="bs_img_show">
                <img class="bs_image_comparison_img_<?= $i ?>" src="<?php echo esc_attr($data_tables[$i][$name]); ?>"></img>
            </div>
        </div>

    </div>
    <script>
        jQuery.noConflict();
        jQuery(function ($) {

            var frame,
                    bs_img_comparison_metaBox = $('#bs_image_comparison_meta_id'),
                    bs_add_img = bs_img_comparison_metaBox.find('#bs_add_image_comparison_<?= $i ?>'),
                    imgContainer = bs_img_comparison_metaBox.find('.bs_image_comparison_img_<?= $i ?>'),
                    imgIdInput = bs_img_comparison_metaBox.find('.bs_img_value_<?= $i ?>');

            bs_add_img.on('click', function (event) {

                event.preventDefault();
                if (frame) {
                    frame.open();
                    return;
                }
                frame = wp.media({
                    title: 'Select or Upload Media Of Your Chosen Persuasion',
                    button: {
                        text: 'Use this media'
                    },
                    multiple: false
                });
                frame.on('select', function () {
                    var attachment = frame.state().get('selection').first().toJSON();
                    imgContainer.attr('src', attachment.url);
                    imgIdInput.attr('value', attachment.url);
                });
                frame.open();
            });

        });

    </script>

<?php } ?>








