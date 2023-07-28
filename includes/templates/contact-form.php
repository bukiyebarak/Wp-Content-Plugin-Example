<?php get_header(); ?>
<?php //wp_head(); ?>

<?php
while ( have_posts() ):the_post();
	the_content();
endwhile;
?>
<div id="form_success" style="background-color : #078c07;padding:10px;margin: 5px; display: none"></div>
<div id="form_error" style="background-color: #d05050; padding:10px;margin: 5px;display: none"></div>

<form id="enquiry_form" style="margin: 10px; padding:10px ; background-color: cornsilk; width: 15%; ">
    <!--    WordPress REST API isteklerine ek güvenlik sağlamak için kullanılır.WordPress'in Nonce (Tek Kullanımlık Anahtar) sistemiyle birlikte çalışır.-->
	<?php wp_nonce_field( 'wp_rest' ); ?>
    <label>
        Name:<input type="text" name="name" style="margin:5px">
    </label> <br>
    <label> Email:
        <input type="text" name="email" style="margin:5px">
    </label><br>
    <label> Phone:
        <input type="text" name="phone" style="margin:5px">
    </label><br>
    <label for="text"> Message:</label><textarea name="message" id="text" cols="20" rows="5"
                                                 style="margin:5px"></textarea><br>
    <button type="submit"> Submit Form</button>
</form>

<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>
<script>
    jQuery(document).ready(function ($) {
        $("#enquiry_form").submit(function (event) {
            event.preventDefault(); // varsayılan davranışını engeller
            var form = $(this);
            $.ajax({
                type: "POST",
                url: "<?php echo get_rest_url( null, 'v1/contact-form/submit' )?>",
                data: form.serialize(), //verileri alır
                success: function (res) {
                    form.hide();
                    var success = $("#form_success");
                    success.show();
                    $("#form_error").hide();
                    success.html(res).fadeIn();
                },
                error: function () {
                    var error = $("#form_error");
                    $("#form_success").hide();
                    error.show();
                    error.html("your message wasn't sent").fadeIn();
                }
            })
        });
    });
</script>

<?php get_footer(); ?>
