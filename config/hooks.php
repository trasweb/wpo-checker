<?php

namespace Trasweb\Plugins\WpoChecker;

use Trasweb\Plugins\WpoChecker\Framework\Hook;
use Trasweb\Plugins\WpoChecker\Places\Plugins_List;
use Trasweb\Plugins\WpoChecker\Places\Posts_List;
use Trasweb\Plugins\WpoChecker\Places\Sites_Selection;
use Trasweb\Plugins\WpoChecker\Places\Terms_List;
use Trasweb\Plugins\WpoChecker\Repositories\Settings;
use Trasweb\Plugins\WpoChecker\Repositories\Sites;

return [
    Hook::new('post_row_actions', [
        'listener' => Posts_List::class,
        'filter'   => 'show_wpo_links_in_cpt_row_actions',
    ]),
    Hook::new('page_row_actions', [
        'listener' => Posts_List::class,
        'filter'   => 'show_wpo_links_in_cpt_row_actions',
    ]),
    Hook::new('tag_row_actions', [
        'listener' => Terms_List::class,
        'filter'   => 'show_wpo_links_in_tags_row_actions',
    ]),
    Hook::new('admin_menu', [
        'listener' => Sites_Selection::class,
        'action'   => 'show_menu',
        'options'  => [
            'page_title' => __('Sites selection', PLUGIN_NAME),
            'menu_title' => PLUGIN_TITLE,
            'capability' => 'manage_options',
            'menu_slug'  => 'sites_selection_page',
        ],
    ]),
    Hook::new('plugin_action_links', [
        'listener' => Plugins_List::class,
        'filter'   => 'show_settings_in_plugin_links',
        'options'  => [
            'link_to_settings' => [
                'capability' => 'manage_options',
                'slug'       => 'sites_selection_page',
                'label'      => __('Settings', PLUGIN_NAME),
                'format'     => '<a href="%s">%s</a>',
            ],
        ],
    ]),
    Hook::new(PLUGIN_NAME . '-loaded', [
        'listener'  => Settings::class,
        'action'    => 'register',
        'with_args' => false,
        'options'   => [
            'sites' => [
                'sanitize_callback' => Hook::callback(Sites::class, 'sanitize'),
                'show_in_rest'      => false,
                'default'           => [],
            ],
        ],
    ]),
];
