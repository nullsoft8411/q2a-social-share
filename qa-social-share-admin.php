<?php

    class qa_social_share_admin
    {

        function allow_template( $template )
        {
            return ( $template != 'admin' );
        }

        function option_default( $option )
        {
            switch ( $option ) {
                case qa_sss_opt::SHARE_TEXT:
                case qa_sss_opt::SHARE_TEXT_HOME:
                    return;
                    break;
                case qa_sss_opt::FB_BUTTON:
                case qa_sss_opt::GP_BUTTON:
                case qa_sss_opt::TW_BUTTON:
                case qa_sss_opt::BUTTON_STATUS:
                    return true;
                    break;
                case qa_sss_opt::LI_BUTTON:
                case qa_sss_opt::RE_BUTTON:
                case qa_sss_opt::VK_BUTTON:
                case qa_sss_opt::EM_BUTTON:
                    return false;
                    break;
            }
        }

        function admin_form()
        {
            //require_once QA_INCLUDE_DIR.'qa-util-sort.php';

            $saved = false;

            if ( qa_clicked( qa_sss_opt::ADMIN_SAVE_BTN ) ) {

                $trimchars = "=;\"\' \t\r\n"; // prevent common errors by copying and pasting from Javascript
                qa_opt( qa_sss_opt::SHARE_TEXT, trim( qa_post_text( qa_sss_opt::SHARE_TEXT ), $trimchars ) );
                qa_opt( qa_sss_opt::SHARE_TEXT_HOME, trim( qa_post_text( qa_sss_opt::SHARE_TEXT_HOME ), $trimchars ) );
                qa_opt( qa_sss_opt::FB_BUTTON, (bool) qa_post_text( qa_sss_opt::FB_BUTTON ) );
                qa_opt( qa_sss_opt::GP_BUTTON, (bool) qa_post_text( qa_sss_opt::GP_BUTTON ) );
                qa_opt( qa_sss_opt::TW_BUTTON, (bool) qa_post_text( qa_sss_opt::TW_BUTTON ) );
                qa_opt( qa_sss_opt::LI_BUTTON, (bool) qa_post_text( qa_sss_opt::LI_BUTTON ) );
                qa_opt( qa_sss_opt::RE_BUTTON, (bool) qa_post_text( qa_sss_opt::RE_BUTTON ) );
                qa_opt( qa_sss_opt::VK_BUTTON, (bool) qa_post_text( qa_sss_opt::VK_BUTTON ) );
                qa_opt( qa_sss_opt::EM_BUTTON, (bool) qa_post_text( qa_sss_opt::EM_BUTTON ) );
                qa_opt( qa_sss_opt::BUTTON_STATUS, (bool) qa_post_text( qa_sss_opt::BUTTON_STATUS ) );

                qa_opt( qa_sss_opt::SHARE_TYPE_OPTION, qa_post_text( qa_sss_opt::SHARE_TYPE_OPTION ) );
                qa_opt( qa_sss_opt::CUSTOM_CSS, qa_post_text( qa_sss_opt::CUSTOM_CSS ) );

                $saved = true;
            }

            $social_share_types = array(
                qa_sss_opt::SHARE_TYPE_IMAGE                  => 'Image',
                qa_sss_opt::SHARE_TYPE_TEXT                   => 'Textual sharing',
                qa_sss_opt::SHARE_TYPE_COLORED_BTNS           => 'Colored buttons',
                qa_sss_opt::SHARE_TYPE_COLORED_BTNS_WITH_ICON => 'Colored buttons with icon',
                qa_sss_opt::SHARE_TYPE_FI_SQ                  => 'Squared icons',
                qa_sss_opt::SHARE_TYPE_FI_SEMI_ROUNDED        => 'Semi-rounded buttons with icon',
                qa_sss_opt::SHARE_TYPE_FI_ROUNDED             => 'Rounded buttons with icon',
                qa_sss_opt::SHARE_TYPE_ANIMATED_FI            => 'Animated buttons with icon',
            );

            $form = array(
                'ok'      => $saved ? qa_lang( 'sss_lang/sss_settings_saved' ) : null,

                'fields'  => array(
                    qa_sss_opt::SHARE_TEXT_HOME   => $this->get_share_text_home_field(),
                    qa_sss_opt::SHARE_TEXT        => $this->get_share_text_field(),
                    qa_sss_opt::FB_BUTTON         => $this->get_fb_button_field(),
                    qa_sss_opt::GP_BUTTON         => $this->get_gp_button_field(),
                    qa_sss_opt::TW_BUTTON         => $this->get_tw_button_field(),
                    qa_sss_opt::LI_BUTTON         => $this->get_li_button_field(),
                    qa_sss_opt::RE_BUTTON         => $this->get_re_button_field(),
                    qa_sss_opt::VK_BUTTON         => $this->get_vk_button_field(),
                    qa_sss_opt::EM_BUTTON         => $this->get_em_button_field(),
                    qa_sss_opt::BUTTON_STATUS     => $this->get_button_status_field(),
                    qa_sss_opt::SHARE_TYPE_OPTION => $this->get_share_type_button( $social_share_types ),
                    qa_sss_opt::CUSTOM_CSS        => $this->get_custom_css_field(),
                ),

                'buttons' => array(
                    array(
                        'label' => qa_lang( 'sss_lang/save_changes' ),
                        'tags'  => 'name="' . qa_sss_opt::ADMIN_SAVE_BTN . '"',
                    ),
                ),
            );

            return $form;
        }

        /**
         * @return array
         */
        public function get_share_text_home_field()
        {
            return array(
                'id'    => qa_sss_opt::SHARE_TEXT_HOME,
                'label' => qa_lang( 'sss_lang/enter_share_text_for_home' ),
                'value' => qa_html( qa_opt( qa_sss_opt::SHARE_TEXT_HOME ) ),
                'tags'  => 'name="' . qa_sss_opt::SHARE_TEXT_HOME . '"',
            );
        }

        /**
         * @return array
         */
        public function get_share_text_field()
        {
            return array(
                'id'    => qa_sss_opt::SHARE_TEXT,
                'label' => qa_lang( 'sss_lang/enter_share_text' ),
                'value' => qa_html( qa_opt( qa_sss_opt::SHARE_TEXT ) ),
                'tags'  => 'name="' . qa_sss_opt::SHARE_TEXT . '"',
                'note'  => qa_lang( 'sss_lang/choose_buttons_from_below' ),
            );
        }

        /**
         * @return array
         */
        public function get_fb_button_field()
        {
            return array(
                'id'    => qa_sss_opt::FB_BUTTON,
                'label' => qa_lang( 'sss_lang/fb' ),
                'type'  => 'checkbox',
                'value' => (int) qa_opt( qa_sss_opt::FB_BUTTON ),
                'tags'  => 'name="' . qa_sss_opt::FB_BUTTON . '"',
            );
        }

        /**
         * @return array
         */
        public function get_gp_button_field()
        {
            return array(
                'id'    => qa_sss_opt::GP_BUTTON,
                'label' => qa_lang( 'sss_lang/gp' ),
                'type'  => 'checkbox',
                'value' => (int) qa_opt( qa_sss_opt::GP_BUTTON ),
                'tags'  => 'name="' . qa_sss_opt::GP_BUTTON . '"',
            );
        }

        /**
         * @return array
         */
        public function get_tw_button_field()
        {
            return array(
                'id'    => qa_sss_opt::TW_BUTTON,
                'label' => qa_lang( 'sss_lang/tw' ),
                'type'  => 'checkbox',
                'value' => (int) qa_opt( qa_sss_opt::TW_BUTTON ),
                'tags'  => 'name="' . qa_sss_opt::TW_BUTTON . '"',
            );
        }

        /**
         * @return array
         */
        public function get_li_button_field()
        {
            return array(
                'id'    => qa_sss_opt::LI_BUTTON,
                'label' => qa_lang( 'sss_lang/li' ),
                'type'  => 'checkbox',
                'value' => (int) qa_opt( qa_sss_opt::LI_BUTTON ),
                'tags'  => 'name="' . qa_sss_opt::LI_BUTTON . '"',
            );
        }

        /**
         * @return array
         */
        public function get_re_button_field()
        {
            return array(
                'id'    => qa_sss_opt::RE_BUTTON,
                'label' => qa_lang( 'sss_lang/reddit' ),
                'type'  => 'checkbox',
                'value' => (int) qa_opt( qa_sss_opt::RE_BUTTON ),
                'tags'  => 'name="' . qa_sss_opt::RE_BUTTON . '"',
            );
        }

        /**
         * @return array
         */
        public function get_vk_button_field()
        {
            return array(
                'id'    => qa_sss_opt::VK_BUTTON,
                'label' => qa_lang( 'sss_lang/vk' ),
                'type'  => 'checkbox',
                'value' => (int) qa_opt( qa_sss_opt::VK_BUTTON ),
                'tags'  => 'name="' . qa_sss_opt::VK_BUTTON . '"',
            );
        }

        /**
         * @return array
         */
        public function get_em_button_field()
        {
            return array(
                'id'    => qa_sss_opt::EM_BUTTON,
                'label' => qa_lang( 'sss_lang/email' ),
                'type'  => 'checkbox',
                'value' => (int) qa_opt( qa_sss_opt::EM_BUTTON ),
                'tags'  => 'name="' . qa_sss_opt::EM_BUTTON . '"',
                'note'  => qa_lang( 'sss_lang/sharing_btn_enable_note' ),
            );
        }

        /**
         * @return array
         */
        public function get_button_status_field()
        {
            return array(
                'id'    => qa_sss_opt::BUTTON_STATUS,
                'label' => (int) qa_opt( qa_sss_opt::BUTTON_STATUS ) ? qa_lang( 'sss_lang/currently_enabled' ) : qa_lang( 'sss_lang/currently_disabled' ),
                'type'  => 'checkbox',
                'value' => (int) qa_opt( qa_sss_opt::BUTTON_STATUS ),
                'tags'  => 'name="' . qa_sss_opt::BUTTON_STATUS . '"',
            );
        }

        /**
         * @param $social_share_types
         *
         * @return array
         */
        public function get_share_type_button( $social_share_types )
        {
            return array(
                'id'       => qa_sss_opt::SHARE_TYPE_OPTION,
                'label'    => qa_lang( 'sss_lang/choose_share_type' ),
                'type'     => 'select',
                'value'    => qa_opt( qa_sss_opt::SHARE_TYPE_OPTION ),
                'tags'     => 'name="' . qa_sss_opt::SHARE_TYPE_OPTION . '"',
                'options'  => $social_share_types,
                'match_by' => 'key',
            );
        }

        /**
         * @return array
         */
        public function get_custom_css_field()
        {
            return array(
                'id'    => qa_sss_opt::CUSTOM_CSS,
                'label' => qa_lang( 'sss_lang/custom_css' ),
                'type'  => 'textarea',
                'rows'  => 6,
                'value' => qa_opt( qa_sss_opt::CUSTOM_CSS ),
                'tags'  => 'name="' . qa_sss_opt::CUSTOM_CSS . '"',
            );
        }

    }


    /*
        Omit PHP closing tag to help avoid accidental output
    */