<?php

    $name = get_post_meta($post->ID, 'contact_list_name', true);
    $email = get_post_meta($post->ID, 'contact_list_email', true);
    $code = get_post_meta($post->ID, 'contact_list_code_number', true);
    $number = get_post_meta($post->ID, 'contact_list_number', true);

?>
<table class="form-table contact-list-metabox"> 

    <input type="hidden" name="contact_list_nonce" value="<?php echo wp_create_nonce('contact_list_nonce'); ?>">

    <tr class="col-12">

        <th class="col-12">
            <h3 class="messageinputsuccess text-center w-100 col-12"> </h3>
            <h3 class="messageinputerror text-center w-100 col-12"> </h3>
            <h3 class="messageinput text-center w-100 col-12"> </h3>
        </th>

       
    </tr>

    <tr>
        <th>
            <label for="contact_list_name"><?php esc_html_e( 'Please Inform a Name', 'contact-list' ); ?></label>
        </th>
        <td>
            <input 
                type="text" 
                name="contact_list_name" 
                id="contact_list_name" 
                class="regular-text namecontactlist"
                minlength="5"
                value="<?php echo (isset($name)) ? esc_html($name) : ''; ?>"
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="contact_list_email"><?php esc_html_e( 'Please Inform an Email', 'contact-list' ); ?></label>
        </th>
        <td>
            <input 
                type="text" 
                name="contact_list_email" 
                id="contact_list_email" 
                class="regular-text emailcontactlist"
                value="<?php echo (isset($email)) ? esc_html($email) : ''; ?>"
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="contact_list_code_number"><?php esc_html_e( 'Select your CountryCode', 'contact-list' ); ?></label>
        </th>
        <td class="w-100">
            <input 
                type="text" 
                id="country_name" 
                class="regular-text country_name form-control"
                placeholder="<?php esc_attr_e( 'Inform a Country name', 'contact-list' ); ?>"
            >
            <button type="button" name="getcode" id="getcode" class="getcode btn btn-outline-secondary"><?php esc_html_e( 'Search', 'contact-list' ); ?></button>
            <br>
            <br>
            <input 
                type="text" 
                name="contact_list_code_number" 
                id="contact_list_code_number" 
                class="regular-text contact_list_code_number"
                value="<?php echo (isset($code)) ? esc_html($code) : ''; ?>"
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="contact_list_number"><?php esc_html_e( 'Please inform a Number for Contact', 'contact-list' ); ?></label>
        </th>
        <td>
            <input 
                type="text" 
                name="contact_list_number" 
                id="contact_list_number" 
                class="regular-text numbercontactlist"
                maxlength="9"
                value="<?php echo (isset($number)) ? esc_html($number) : ''; ?>"
            >
        </td>
    </tr>
</table>