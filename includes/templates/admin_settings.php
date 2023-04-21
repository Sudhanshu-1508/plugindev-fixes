<div class="wrap">
    <h1>News Settings</h1>
    <form method="post" action="<?php echo admin_url('edit.php?post_type=news&page=news-settings' ) ?>">
        <?php wp_nonce_field('news-settings-save', 'news_settings_nonce'); ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label for="news_related_title"><?php echo esc_html__( isset( $_POST['news_related_title']) ? $_POST['news_related_title'] : get_option('news_related_title', 'Related News' ) ) ?></label></th>
                    <td><input id="news_related_title" type="text" name="news_related_title" value="<?php echo esc_attr( get_option( 'custom_news_related_title', 'Related News' ))?>" required> </td>
                </tr>
                <tr>
                    <th><label for="news_related_email"><?php echo esc_html__( isset( $_POST['news_related_email']) ? $_POST['news_related_email'] : get_option('news_related_email', '' ) ) ?>News Related Email</label></th>
                    <td><input id="news_related_email" type="email" name="news_related_email" value="<?php echo esc_attr( get_option( 'custom_news_related_email', '' ))?>" required></td>
                </tr>
                <tr>
                    <th><label for="show_related"><?php echo esc_html__('Show Related News?', 'myplugin-sk') ?></label></th>
                    <td><input id="show_related" type="checkbox" name="show_related" value="1"<?php checked(get_option( ' show_related', true)); ?>></td>
                </tr>
                <tr>
                    <th><label for="related_news_amount">Number of Articles</label></th>
                    <td>
                        <select id="related_news_amount" name="related_news_amount">
                            <?php for( $i = 1; $i <=10; $i++) : ?>
                                <option value="<?php echo $i;?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="submit" class="button button-primary"value="<?php echo esc_html (__('Save Changes', 'myplugin-sk')) ?>">
    </form>
</div>
