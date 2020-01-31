<?php /* Template Name: My form 2 */

?>
<div class="container" style="width:40%; margin-left: 205px; margin-top: -73px; padding-top: 100px;">
    <form method="post" id="myForm">
        <ul class="form-style-1">
            <li><label>Full Name <span class="required">*</span></label>
                <input type="text" name="first_name" id="first_name" class="field-divided" placeholder="First" />
                <input type="text" name="last_name" id="last_name" class="field-divided" placeholder="Last" /></li>
            <li>
                <label>Tel <span class="required">*</span></label>
                <input type="text" name="tel" id="tel" class="field-long" /*pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" */ />
            </li>

            <li>
                <label>Descriere <span class="required">*</span></label>
                <textarea name="field5" id="description" class="field-long field-textarea"></textarea>
            </li>

            <li>
                <input type="submit" value="Submit" />
            </li>

        </ul>
    </form>
</div>

<div id="postbox">
    <form id="new_post" name="new_post" method="post" action="">

        <!-- post name -->
        <p><label for="title">Title</label><br />
            <input type="text" id="title" value="" tabindex="1" size="20" name="title" />
        </p>

        <!-- post Category -->
        <p><label for="Category">Category:</label><br />
            <p><?php wp_dropdown_categories('show_option_none=Category&tab_index=4&taxonomy=category'); ?></p>


            <!-- post Content -->
            <p><label for="description">Content</label><br />
                <textarea id="description" tabindex="3" name="description" cols="50" rows="6"></textarea>
            </p>

            <!-- post tags -->
            <p><label for="post_tags">Tags:</label>
                <input type="text" value="" tabindex="5" size="16" name="post_tags" id="post_tags" /></p>
            <p align="right"><input type="submit" value="Publish" tabindex="6" id="submit" name="submit" /></p>

            <input type="hidden" name="action" value="new_post" />
            <?php wp_nonce_field('new-post'); ?>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>


<script>
    jQuery(function() {
        jQuery('#myForm').submit(function(event) {
            var first_name = jQuery('#first_name').val();
            var last_name = jQuery('#last_name').val();
            var tel = jQuery('#tel').val();
            var description = jQuery('#description').val();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: {
                    'action': 'add_new_user',
                    'first_name': first_name,
                    'last_name': last_name,
                    'tel': tel,
                    'description': description
                },
                success: function(data) {
                    if (data.res == true) {
                        alert("succes"); // success message
                    } else {
                        alert("fail"); // fail
                    }
                }
            });
        });
    });
</script>


























<style type="text/css">
    .form-style-1 {
        margin: 10px auto;
        max-width: 400px;
        padding: 20px 12px 10px 20px;
        font: 13px "Lucida Sans Unicode", "Lucida Grande", sans-serif;
    }

    .form-style-1 li {
        padding: 0;
        display: block;
        list-style: none;
        margin: 10px 0 0 0;
    }

    .form-style-1 label {
        margin: 0 0 3px 0;
        padding: 0px;
        display: block;
        font-weight: bold;
    }

    .form-style-1 input[type=text],
    .form-style-1 input[type=date],
    .form-style-1 input[type=datetime],
    .form-style-1 input[type=number],
    .form-style-1 input[type=search],
    .form-style-1 input[type=time],
    .form-style-1 input[type=url],
    .form-style-1 input[type=email],
    textarea,
    select {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        border: 1px solid #BEBEBE;
        padding: 7px;
        margin: 0px;
        -webkit-transition: all 0.30s ease-in-out;
        -moz-transition: all 0.30s ease-in-out;
        -ms-transition: all 0.30s ease-in-out;
        -o-transition: all 0.30s ease-in-out;
        outline: none;
    }

    .form-style-1 input[type=text]:focus,
    .form-style-1 input[type=date]:focus,
    .form-style-1 input[type=datetime]:focus,
    .form-style-1 input[type=number]:focus,
    .form-style-1 input[type=search]:focus,
    .form-style-1 input[type=time]:focus,
    .form-style-1 input[type=url]:focus,
    .form-style-1 input[type=email]:focus,
    .form-style-1 textarea:focus,
    .form-style-1 select:focus {
        -moz-box-shadow: 0 0 8px #88D5E9;
        -webkit-box-shadow: 0 0 8px #88D5E9;
        box-shadow: 0 0 8px #88D5E9;
        border: 1px solid #88D5E9;
    }

    .form-style-1 .field-divided {
        width: 49%;
    }

    .form-style-1 .field-long {
        width: 100%;
    }

    .form-style-1 .field-select {
        width: 100%;
    }

    .form-style-1 .field-textarea {
        height: 100px;
    }

    .form-style-1 input[type=submit],
    .form-style-1 input[type=button] {
        background: #4B99AD;
        padding: 8px 15px 8px 15px;
        border: none;
        color: #fff;
    }

    .form-style-1 input[type=submit]:hover,
    .form-style-1 input[type=button]:hover {
        background: #4691A4;
        box-shadow: none;
        -moz-box-shadow: none;
        -webkit-box-shadow: none;
    }

    .form-style-1 .required {
        color: red;
    }
</style>

?>

<?php get_footer(); ?>